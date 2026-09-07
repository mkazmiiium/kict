<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvisionalRecord\StoreProvisionalRecordRequest;
use App\Http\Requests\ProvisionalRecord\UpdateProvisionalRecordRequest;
use App\Models\AcademicSession;
use App\Models\ProvisionalRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class ProvisionalRecordController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');

        $provisionalRecords = $this->filteredQuery($sort, $direction, $search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.provisional.index', [
            'provisionalRecords' => $provisionalRecords,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');

        $provisionalRecords = $this->filteredQuery($sort, $direction, $search)->get();

        $rows = $provisionalRecords->map(fn (ProvisionalRecord $record) => [
            $record->student->matric_no,
            $record->student->name,
            $record->student->program->name_en ?? '—',
            $record->academicSession->label(),
            $record->student->year_of_study ?? '—',
            number_format((float) $record->cgpa, 2),
            $record->created_at->format('d M Y'),
            $record->creator->name ?? '—',
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf(
            'Provisional Records',
            ['Matric No.', 'Name', 'Programme', 'Semester', 'Year of Study', 'CGPA', 'Date Keyed In', 'Created By'],
            $rows,
            $filters
        );
    }

    public function create()
    {
        return view('ddsdce.provisional.create', $this->formData());
    }

    public function store(StoreProvisionalRecordRequest $request)
    {
        $data = $request->validated();

        $record = ProvisionalRecord::create([
            ...$data,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.provisional.index')
            ->with('status', "Provisional record for {$record->student->name} created.");
    }

    public function edit(ProvisionalRecord $provisionalRecord)
    {
        $provisionalRecord->load(['student.program', 'student.department.kulliyyah']);

        return view('ddsdce.provisional.edit', [
            'provisionalRecord' => $provisionalRecord,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateProvisionalRecordRequest $request, ProvisionalRecord $provisionalRecord)
    {
        $data = $request->validated();

        $provisionalRecord->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.provisional.index')
            ->with('status', "Provisional record for {$provisionalRecord->student->name} updated.");
    }

    public function destroy(ProvisionalRecord $provisionalRecord)
    {
        $name = $provisionalRecord->student->name;

        $provisionalRecord->delete();

        return redirect()->route('ddsdce.provisional.index')
            ->with('status', "Provisional record for {$name} deleted.");
    }

    private function filteredQuery(string $sort, string $direction, ?string $search)
    {
        $sortable = [
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'academic_session_id' => 'provisional_records.academic_session_id',
            'cgpa' => 'provisional_records.cgpa',
            'created_at' => 'provisional_records.created_at',
            'year_of_study' => 'students.year_of_study',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['student_name'];

        return ProvisionalRecord::query()
            ->select('provisional_records.*')
            ->join('students', 'students.id', '=', 'provisional_records.student_id')
            ->with(['student.program', 'student.department', 'academicSession', 'creator'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('provisional_records.id');
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'academicSessions' => AcademicSession::orderByDesc('academic_year')->orderByDesc('semester')->get(),
        ];
    }
}
