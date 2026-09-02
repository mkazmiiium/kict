<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\DsuStudent\StoreDsuStudentRequest;
use App\Http\Requests\DsuStudent\UpdateDsuStudentRequest;
use App\Models\AcademicSession;
use App\Models\DisabilityCategory;
use App\Models\DsuStudent;
use App\Models\Student;
use Illuminate\Http\Request;

class DsuStudentController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'student_name');
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $search = $request->get('search');

        $dsuStudents = $this->filteredQuery($sort, $direction, $search)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.dsu.index', [
            'dsuStudents' => $dsuStudents,
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

        $dsuStudents = $this->filteredQuery($sort, $direction, $search)->get();

        $rows = $dsuStudents->map(fn (DsuStudent $dsu) => [
            $dsu->student->matric_no,
            $dsu->student->name,
            $dsu->student->program->name_en ?? '—',
            $dsu->disabilityCategory->name ?? '—',
            $dsu->disability_detail ?? '—',
            $dsu->joinedAcademicSession->label(),
            $dsu->semestersSinceJoining() ?? '—',
        ])->all();

        $filters = $search ? "Search: \"{$search}\"" : '';

        return $this->exportListPdf(
            'DSU Students',
            ['Matric No.', 'Name', 'Programme', 'Disability Category', 'Detail', 'Joined Semester', 'Semesters'],
            $rows,
            $filters
        );
    }

    public function create()
    {
        return view('ddsdce.dsu.create', $this->formData());
    }

    public function store(StoreDsuStudentRequest $request)
    {
        $data = $request->validated();

        $dsu = DsuStudent::create([
            ...$data,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.dsu.index')
            ->with('status', "DSU record for {$dsu->student->name} created.");
    }

    public function show(DsuStudent $dsuStudent)
    {
        $dsuStudent->load(['student.program', 'student.department.kulliyyah', 'disabilityCategory', 'joinedAcademicSession', 'creator', 'updater']);

        return view('ddsdce.dsu.show', compact('dsuStudent'));
    }

    public function edit(DsuStudent $dsuStudent)
    {
        $dsuStudent->load(['student.program', 'student.department.kulliyyah']);

        return view('ddsdce.dsu.edit', [
            'dsuStudent' => $dsuStudent,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateDsuStudentRequest $request, DsuStudent $dsuStudent)
    {
        $data = $request->validated();

        $dsuStudent->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.dsu.index')
            ->with('status', "DSU record for {$dsuStudent->student->name} updated.");
    }

    public function destroy(DsuStudent $dsuStudent)
    {
        $name = $dsuStudent->student->name;

        $dsuStudent->delete();

        return redirect()->route('ddsdce.dsu.index')
            ->with('status', "DSU record for {$name} deleted.");
    }

    private function filteredQuery(string $sort, string $direction, ?string $search)
    {
        $sortable = [
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'disability_category' => 'disability_categories.name',
            'joined_academic_session_id' => 'dsu_students.joined_academic_session_id',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['student_name'];

        return DsuStudent::query()
            ->select('dsu_students.*')
            ->join('students', 'students.id', '=', 'dsu_students.student_id')
            ->leftJoin('disability_categories', 'disability_categories.id', '=', 'dsu_students.disability_category_id')
            ->with(['student.program', 'student.department', 'disabilityCategory', 'joinedAcademicSession'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhere('disability_categories.name', 'like', "%{$search}%")
                        ->orWhere('dsu_students.disability_detail', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('dsu_students.id');
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'disabilityCategories' => DisabilityCategory::where('is_active', true)->orderBy('name')->get(),
            'academicSessions' => AcademicSession::where('semester', '!=', 3)
                ->orderByDesc('academic_year')
                ->orderByDesc('semester')
                ->get(),
        ];
    }
}
