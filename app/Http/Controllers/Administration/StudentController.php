<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\Department;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $search = $request->get('search');

        $students = $this->filteredQuery($request, $sort, $direction, $search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('administration.students.index', [
            'students' => $students,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $search = $request->get('search');

        $students = $this->filteredQuery($request, $sort, $direction, $search)->get();

        $rows = $students->map(fn (Student $student) => [
            $student->matric_no,
            $student->name,
            $student->program->name_en ?? '—',
            $student->department->name_en ?? '—',
            $student->year_of_study ?? '—',
            ucfirst($student->status),
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf('Students', ['Matric No.', 'Name', 'Program', 'Department', 'Year', 'Status'], $rows, $filters);
    }

    private function filteredQuery(Request $request, string $sort, string $direction, ?string $search)
    {
        $sortable = [
            'matric_no' => 'students.matric_no',
            'name' => 'students.name',
            'program' => 'programs.name_en',
            'department' => 'departments.name_en',
            'year_of_study' => 'students.year_of_study',
            'status' => 'students.status',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['name'];

        return Student::query()
            ->select('students.*')
            ->join('programs', 'programs.id', '=', 'students.program_id')
            ->join('departments', 'departments.id', '=', 'students.department_id')
            ->with(['program', 'department'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhere('students.passport_no', 'like', "%{$search}%")
                        ->orWhere('students.nric_no', 'like', "%{$search}%")
                        ->orWhere('students.gender', 'like', "%{$search}%")
                        ->orWhere('students.year_of_study', 'like', "%{$search}%")
                        ->orWhere('students.status', 'like', "%{$search}%")
                        ->orWhere('programs.name_en', 'like', "%{$search}%")
                        ->orWhere('programs.name_bm', 'like', "%{$search}%")
                        ->orWhere('departments.name_en', 'like', "%{$search}%")
                        ->orWhere('departments.name_bm', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('students.id');
    }

    public function create()
    {
        return view('administration.students.create', $this->formData());
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        return redirect()->route('administration.students.index')
            ->with('status', "Student {$student->name} created.");
    }

    public function edit(Student $student)
    {
        return view('administration.students.edit', [
            'student' => $student,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()->route('administration.students.index')
            ->with('status', "Student {$student->name} updated.");
    }

    public function destroy(Student $student)
    {
        $name = $student->name;

        try {
            $student->delete();
        } catch (QueryException $e) {
            return redirect()->route('administration.students.index')
                ->with('error', "Cannot delete {$name} — this student has existing letter records.");
        }

        return redirect()->route('administration.students.index')
            ->with('status', "Student {$name} deleted.");
    }

    private function formData(): array
    {
        return [
            'programs' => Program::orderBy('name_en')->get(),
            'departments' => Department::orderBy('name_en')->get(),
        ];
    }
}
