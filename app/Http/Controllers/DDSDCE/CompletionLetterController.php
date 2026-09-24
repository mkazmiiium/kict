<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompletionLetter\StoreCompletionLetterRequest;
use App\Http\Requests\CompletionLetter\UpdateCompletionLetterRequest;
use App\Models\AcademicSession;
use App\Models\CompletionLetter;
use App\Models\Signatory;
use App\Models\Student;
use App\Services\LetterNumberingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CompletionLetterController extends Controller
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

        return view('ddsdce.completion.index', [
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

        $rows = $letters->map(fn (CompletionLetter $letter) => [
            $letter->reference_no,
            $letter->student->name,
            $letter->student->matric_no,
            $letter->date->format('d M Y'),
            $letter->iaAcademicSession->label(),
            $letter->graduation_status === 'fulfilled' ? 'Fulfilled' : 'Subject to Endorsement',
        ])->all();

        $filters = $this->filterSummary($search, $filterMonth, $filterYear);

        return $this->exportListPdf(
            'Completion Letters',
            ['Reference No.', 'Student Name', 'Matric No.', 'Date Issued', 'IAP Semester', 'Graduation Status'],
            $rows,
            $filters
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, $filterMonth, $filterYear)
    {
        $sortable = [
            'reference_no' => 'completion_letters.reference_no',
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'completion_letters.date',
            'graduation_status' => 'completion_letters.graduation_status',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return CompletionLetter::query()
            ->select('completion_letters.*')
            ->join('students', 'students.id', '=', 'completion_letters.student_id')
            ->with(['student', 'iaAcademicSession'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('completion_letters.reference_no', 'like', "%{$search}%")
                        ->orWhere('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%");
                });
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('completion_letters.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('completion_letters.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('completion_letters.id');
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
        return view('ddsdce.completion.create', $this->formData());
    }

    public function store(StoreCompletionLetterRequest $request, LetterNumberingService $numbering)
    {
        $data = $request->validated();
        $numbered = $numbering->generate('COMPLETION');

        $letter = CompletionLetter::create([
            'reference_no' => $numbered['reference_no'],
            'letter_type_id' => $numbered['letter_type_id'],
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'joined_academic_session_id' => $data['joined_academic_session_id'],
            'ia_academic_session_id' => $data['ia_academic_session_id'],
            'ia_completion_date' => $data['ia_completion_date'] ?? null,
            'graduation_status' => $data['graduation_status'],
            'graduation_semester_text' => $data['graduation_semester_text'] ?? null,
            'expected_graduation_date' => $data['expected_graduation_date'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.completion.index')
            ->with('status', "Completion letter {$letter->reference_no} created.");
    }

    public function show(CompletionLetter $completionLetter)
    {
        $completionLetter->load([
            'student.program', 'student.department', 'signatory',
            'joinedAcademicSession', 'iaAcademicSession',
        ]);

        return view('ddsdce.completion.show', compact('completionLetter'));
    }

    public function edit(CompletionLetter $completionLetter)
    {
        $completionLetter->load(['student.program', 'student.department', 'signatory']);

        return view('ddsdce.completion.edit', [
            'completionLetter' => $completionLetter,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateCompletionLetterRequest $request, CompletionLetter $completionLetter)
    {
        $data = $request->validated();

        $completionLetter->update([
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'joined_academic_session_id' => $data['joined_academic_session_id'],
            'ia_academic_session_id' => $data['ia_academic_session_id'],
            'ia_completion_date' => $data['ia_completion_date'] ?? null,
            'graduation_status' => $data['graduation_status'],
            'graduation_semester_text' => $data['graduation_semester_text'] ?? null,
            'expected_graduation_date' => $data['expected_graduation_date'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.completion.index')
            ->with('status', "Completion letter {$completionLetter->reference_no} updated.");
    }

    public function destroy(Request $request, CompletionLetter $completionLetter)
    {
        $referenceNo = $completionLetter->reference_no;

        $completionLetter->update(['updated_by' => $request->user()->id]);
        $completionLetter->delete();

        return redirect()->route('ddsdce.completion.index')
            ->with('status', "Completion letter {$referenceNo} deleted.");
    }

    public function viewPdf(CompletionLetter $completionLetter)
    {
        return $this->buildPdf($completionLetter)->stream($this->pdfFilename($completionLetter));
    }

    public function print(CompletionLetter $completionLetter)
    {
        return $this->buildPdf($completionLetter)->download($this->pdfFilename($completionLetter));
    }

    private function buildPdf(CompletionLetter $completionLetter)
    {
        $completionLetter->load(['student.program', 'student.department.kulliyyah', 'signatory']);

        $pdf = Pdf::loadView('ddsdce.completion.pdf', [
            'completionLetter' => $completionLetter,
            'formattedDate' => $completionLetter->date->format('j F Y'),
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(CompletionLetter $completionLetter): string
    {
        $reference = str_replace('/', '-', $completionLetter->reference_no);

        return "{$reference}-{$completionLetter->student->matric_no}.pdf";
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'academicSessions' => AcademicSession::orderByDesc('academic_year')->orderByDesc('semester')->get(),
            'signatories' => Signatory::where('is_active', true)->orderByDesc('id')->get(),
            'defaultSignatory' => Signatory::where('is_active', true)->orderBy('id')->first(),
        ];
    }
}
