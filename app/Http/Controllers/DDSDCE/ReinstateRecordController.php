<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReinstateRecord\StoreReinstateRecordRequest;
use App\Http\Requests\ReinstateRecord\UpdateReinstateRecordRequest;
use App\Models\AcademicSession;
use App\Models\ReinstateRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class ReinstateRecordController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'student_name');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $search = $request->get('search');

        $reinstateRecords = $this->filteredQuery($sort, $direction, $search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.reinstate.index', [
            'reinstateRecords' => $reinstateRecords,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'student_name');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $search = $request->get('search');

        $reinstateRecords = $this->filteredQuery($sort, $direction, $search)->get();

        $rows = $reinstateRecords->map(fn (ReinstateRecord $record) => [
            $record->student->matric_no,
            $record->student->name,
            $record->student->program->name_en ?? '—',
            $record->academicSession->label(),
            number_format((float) $record->cgpa, 2),
            $record->date->format('d M Y'),
            $record->creator->name ?? '—',
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf(
            'Reinstatement Records',
            ['Matric No.', 'Name', 'Programme', 'Semester', 'CGPA', 'Date', 'Created By'],
            $rows,
            $filters
        );
    }

    public function create()
    {
        return view('ddsdce.reinstate.create', $this->formData());
    }

    public function store(StoreReinstateRecordRequest $request)
    {
        $data = $request->validated();

        $record = ReinstateRecord::create([
            ...$data,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.reinstate.index')
            ->with('status', "Reinstatement record for {$record->student->name} created.");
    }

    public function edit(ReinstateRecord $reinstateRecord)
    {
        $reinstateRecord->load(['student.program', 'student.department.kulliyyah']);

        return view('ddsdce.reinstate.edit', [
            'reinstateRecord' => $reinstateRecord,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateReinstateRecordRequest $request, ReinstateRecord $reinstateRecord)
    {
        $data = $request->validated();

        $reinstateRecord->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.reinstate.index')
            ->with('status', "Reinstatement record for {$reinstateRecord->student->name} updated.");
    }

    public function destroy(ReinstateRecord $reinstateRecord)
    {
        $name = $reinstateRecord->student->name;

        $reinstateRecord->delete();

        return redirect()->route('ddsdce.reinstate.index')
            ->with('status', "Reinstatement record for {$name} deleted.");
    }

    private function filteredQuery(string $sort, string $direction, ?string $search)
    {
        $sortable = [
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'academic_session_id' => 'reinstate_records.academic_session_id',
            'cgpa' => 'reinstate_records.cgpa',
            'date' => 'reinstate_records.date',
            'year_of_study' => 'students.year_of_study',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['student_name'];

        return ReinstateRecord::query()
            ->select('reinstate_records.*')
            ->join('students', 'students.id', '=', 'reinstate_records.student_id')
            ->with(['student.program', 'student.department', 'academicSession', 'creator'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('reinstate_records.id');
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'academicSessions' => AcademicSession::orderByDesc('academic_year')->orderByDesc('semester')->get(),
        ];
    }
}
