<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpectedGraduationLetter\StoreExpectedGraduationLetterRequest;
use App\Http\Requests\ExpectedGraduationLetter\UpdateExpectedGraduationLetterRequest;
use App\Models\AcademicSession;
use App\Models\ExpectedGraduationLetter;
use App\Models\Signatory;
use App\Models\Student;
use App\Services\LetterNumberingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExpectedGraduationLetterController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $filterMonth = $request->get('month');
        $filterYear = $request->get('year');

        $letters = $this->filteredQuery($sort, $direction, $search, $filterMonth, $filterYear)
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.expected-graduation.index', [
            'letters' => $letters,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'filterMonth' => $filterMonth,
            'filterYear' => $filterYear,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $sort = $request->get('sort', 'date');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $filterMonth = $request->get('month');
        $filterYear = $request->get('year');

        $letters = $this->filteredQuery($sort, $direction, $search, $filterMonth, $filterYear)->get();

        $rows = $letters->map(fn (ExpectedGraduationLetter $letter) => [
            $letter->reference_no,
            $letter->student->name,
            $letter->student->matric_no,
            $letter->date->format('d M Y'),
            $letter->graduation_semester_text,
            $letter->include_cgpa ? 'Yes' : 'No',
        ])->all();

        $filters = $this->filterSummary($search, $filterMonth, $filterYear);

        return $this->exportListPdf(
            'Expected Graduation Letters',
            ['Reference No.', 'Student Name', 'Matric No.', 'Date Issued', 'Expected Graduation', 'CGPA Included?'],
            $rows,
            $filters
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, $filterMonth, $filterYear)
    {
        $sortable = [
            'reference_no' => 'expected_graduation_letters.reference_no',
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'expected_graduation_letters.date',
            'graduation_semester_text' => 'expected_graduation_letters.graduation_semester_text',
            'include_cgpa' => 'expected_graduation_letters.include_cgpa',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return ExpectedGraduationLetter::query()
            ->select('expected_graduation_letters.*')
            ->join('students', 'students.id', '=', 'expected_graduation_letters.student_id')
            ->with('student')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('expected_graduation_letters.reference_no', 'like', "%{$search}%")
                        ->orWhere('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhere('expected_graduation_letters.graduation_semester_text', 'like', "%{$search}%");
                });
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('expected_graduation_letters.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('expected_graduation_letters.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('expected_graduation_letters.id');
    }

    private function filterSummary(?string $search, $filterMonth, $filterYear): string
    {
        $parts = [];

        if ($search) {
            $parts[] = "Search: \"{$search}\"";
        }
        if ($filterMonth) {
            $parts[] = 'Month: '.date('F', mktime(0, 0, 0, (int) $filterMonth, 1));
        }
        if ($filterYear) {
            $parts[] = "Year: {$filterYear}";
        }

        return implode(', ', $parts);
    }

    public function create()
    {
        return view('ddsdce.expected-graduation.create', $this->formData());
    }

    public function store(StoreExpectedGraduationLetterRequest $request, LetterNumberingService $numbering)
    {
        $data = $request->validated();
        $numbered = $numbering->generate('EXPECTED_GRADUATION');

        $letter = ExpectedGraduationLetter::create([
            'reference_no' => $numbered['reference_no'],
            'letter_type_id' => $numbered['letter_type_id'],
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'current_academic_session_id' => $data['current_academic_session_id'] ?? null,
            'joined_academic_session_id' => $data['joined_academic_session_id'],
            'graduation_semester_text' => $data['graduation_semester_text'],
            'include_cgpa' => $request->boolean('include_cgpa'),
            'cgpa_academic_session_id' => $data['cgpa_academic_session_id'] ?? null,
            'cgpa' => $data['cgpa'] ?? null,
            'include_ia_statement' => $request->boolean('include_ia_statement'),
            'ia_academic_session_id' => $data['ia_academic_session_id'] ?? null,
            'ia_completion_date' => $data['ia_completion_date'] ?? null,
            'endorsing_body_text' => $data['endorsing_body_text'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.expected-graduation.index')
            ->with('status', "Expected Graduation letter {$letter->reference_no} created.");
    }

    public function show(ExpectedGraduationLetter $expectedGraduationLetter)
    {
        $expectedGraduationLetter->load([
            'student.program', 'student.department', 'signatory',
            'currentAcademicSession', 'joinedAcademicSession', 'cgpaAcademicSession', 'iaAcademicSession',
        ]);

        return view('ddsdce.expected-graduation.show', compact('expectedGraduationLetter'));
    }

    public function edit(ExpectedGraduationLetter $expectedGraduationLetter)
    {
        $expectedGraduationLetter->load(['student.program', 'student.department', 'signatory']);

        return view('ddsdce.expected-graduation.edit', [
            'expectedGraduationLetter' => $expectedGraduationLetter,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateExpectedGraduationLetterRequest $request, ExpectedGraduationLetter $expectedGraduationLetter)
    {
        $data = $request->validated();

        $expectedGraduationLetter->update([
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'current_academic_session_id' => $data['current_academic_session_id'] ?? null,
            'joined_academic_session_id' => $data['joined_academic_session_id'],
            'graduation_semester_text' => $data['graduation_semester_text'],
            'include_cgpa' => $request->boolean('include_cgpa'),
            'cgpa_academic_session_id' => $data['cgpa_academic_session_id'] ?? null,
            'cgpa' => $data['cgpa'] ?? null,
            'include_ia_statement' => $request->boolean('include_ia_statement'),
            'ia_academic_session_id' => $data['ia_academic_session_id'] ?? null,
            'ia_completion_date' => $data['ia_completion_date'] ?? null,
            'endorsing_body_text' => $data['endorsing_body_text'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.expected-graduation.index')
            ->with('status', "Expected Graduation letter {$expectedGraduationLetter->reference_no} updated.");
    }

    public function destroy(Request $request, ExpectedGraduationLetter $expectedGraduationLetter)
    {
        $referenceNo = $expectedGraduationLetter->reference_no;

        $expectedGraduationLetter->update(['updated_by' => $request->user()->id]);
        $expectedGraduationLetter->delete();

        return redirect()->route('ddsdce.expected-graduation.index')
            ->with('status', "Expected Graduation letter {$referenceNo} deleted.");
    }

    public function viewPdf(ExpectedGraduationLetter $expectedGraduationLetter)
    {
        return $this->buildPdf($expectedGraduationLetter)->stream($this->pdfFilename($expectedGraduationLetter));
    }

    public function print(ExpectedGraduationLetter $expectedGraduationLetter)
    {
        return $this->buildPdf($expectedGraduationLetter)->download($this->pdfFilename($expectedGraduationLetter));
    }

    private function buildPdf(ExpectedGraduationLetter $expectedGraduationLetter)
    {
        $expectedGraduationLetter->load(['student.program', 'student.department.kulliyyah', 'signatory']);

        $pdf = Pdf::loadView('ddsdce.expected-graduation.pdf', [
            'expectedGraduationLetter' => $expectedGraduationLetter,
            'formattedDate' => $expectedGraduationLetter->date->format('j F Y'),
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(ExpectedGraduationLetter $expectedGraduationLetter): string
    {
        $reference = str_replace('/', '-', $expectedGraduationLetter->reference_no);

        return "{$reference}-{$expectedGraduationLetter->student->matric_no}.pdf";
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'academicSessions' => AcademicSession::orderByDesc('academic_year')->orderByDesc('semester')->get(),
            'defaultSignatory' => Signatory::where('is_active', true)->orderBy('id')->first(),
        ];
    }
}
