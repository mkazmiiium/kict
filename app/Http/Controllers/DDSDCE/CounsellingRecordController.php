<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounsellingRecord\StoreCounsellingRecordRequest;
use App\Http\Requests\CounsellingRecord\UpdateCounsellingRecordRequest;
use App\Models\CounsellingRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class CounsellingRecordController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');

        $counsellingRecords = $this->filteredQuery($sort, $direction, $search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.counselling.index', [
            'counsellingRecords' => $counsellingRecords,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');

        $counsellingRecords = $this->filteredQuery($sort, $direction, $search)->get();

        $rows = $counsellingRecords->map(fn (CounsellingRecord $record) => [
            $record->student->matric_no,
            $record->student->name,
            $record->student->program->name_en ?? '—',
            $record->student->department->name_en ?? '—',
            $record->date->format('d M Y'),
            $record->referred_by ?: '—',
            $record->emailed_to_ccsc_date?->format('d M Y') ?? '—',
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf(
            'Counselling Records',
            ['Matric No.', 'Name', 'Programme', 'Department', 'Date', 'Referred By', 'Emailed to CCSC'],
            $rows,
            $filters
        );
    }

    public function create()
    {
        return view('ddsdce.counselling.create', $this->formData());
    }

    public function store(StoreCounsellingRecordRequest $request)
    {
        $data = $request->validated();

        $record = CounsellingRecord::create([
            ...$data,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.counselling.index')
            ->with('status', "Counselling record for {$record->student->name} created.");
    }

    public function show(CounsellingRecord $counsellingRecord)
    {
        $counsellingRecord->load(['student.program', 'student.department.kulliyyah', 'creator', 'updater']);

        return view('ddsdce.counselling.show', compact('counsellingRecord'));
    }

    public function edit(CounsellingRecord $counsellingRecord)
    {
        $counsellingRecord->load(['student.program', 'student.department.kulliyyah']);

        return view('ddsdce.counselling.edit', [
            'counsellingRecord' => $counsellingRecord,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateCounsellingRecordRequest $request, CounsellingRecord $counsellingRecord)
    {
        $data = $request->validated();

        $counsellingRecord->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.counselling.index')
            ->with('status', "Counselling record for {$counsellingRecord->student->name} updated.");
    }

    public function destroy(CounsellingRecord $counsellingRecord)
    {
        $name = $counsellingRecord->student->name;

        $counsellingRecord->delete();

        return redirect()->route('ddsdce.counselling.index')
            ->with('status', "Counselling record for {$name} deleted.");
    }

    private function filteredQuery(string $sort, string $direction, ?string $search)
    {
        $sortable = [
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'counselling_records.date',
            'emailed_to_ccsc_date' => 'counselling_records.emailed_to_ccsc_date',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return CounsellingRecord::query()
            ->select('counselling_records.*')
            ->join('students', 'students.id', '=', 'counselling_records.student_id')
            ->with(['student.program', 'student.department'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhere('counselling_records.referred_by', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('counselling_records.id');
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
        ];
    }
}
