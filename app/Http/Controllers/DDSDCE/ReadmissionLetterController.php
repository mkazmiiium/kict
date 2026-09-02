<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadmissionLetter\StoreReadmissionLetterRequest;
use App\Http\Requests\ReadmissionLetter\UpdateReadmissionLetterRequest;
use App\Models\AcademicSession;
use App\Models\ReadmissionCondition;
use App\Models\ReadmissionLetter;
use App\Models\Signatory;
use App\Models\Student;
use App\Services\LetterNumberingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReadmissionLetterController extends Controller
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

        return view('ddsdce.readmission.index', [
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

        $rows = $letters->map(fn (ReadmissionLetter $letter) => [
            $letter->reference_no,
            $letter->student->name,
            $letter->student->matric_no,
            $letter->date->format('d M Y'),
            $letter->readmissionAcademicSession->label(),
            $letter->readmissionCondition->name,
        ])->all();

        $filters = $this->filterSummary($search, $filterMonth, $filterYear);

        return $this->exportListPdf(
            'Readmission Letters',
            ['Reference No.', 'Student Name', 'Matric No.', 'Date Issued', 'Readmission Semester', 'Condition'],
            $rows,
            $filters
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, $filterMonth, $filterYear)
    {
        $sortable = [
            'reference_no' => 'readmission_letters.reference_no',
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'readmission_letters.date',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return ReadmissionLetter::query()
            ->select('readmission_letters.*')
            ->join('students', 'students.id', '=', 'readmission_letters.student_id')
            ->with(['student', 'readmissionAcademicSession', 'readmissionCondition'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('readmission_letters.reference_no', 'like', "%{$search}%")
                        ->orWhere('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%");
                });
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('readmission_letters.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('readmission_letters.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('readmission_letters.id');
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
        return view('ddsdce.readmission.create', $this->formData());
    }

    public function store(StoreReadmissionLetterRequest $request, LetterNumberingService $numbering)
    {
        $data = $request->validated();
        $numbered = $numbering->generate('READMISSION');

        $letter = ReadmissionLetter::create([
            ...$data,
            'reference_no' => $numbered['reference_no'],
            'letter_type_id' => $numbered['letter_type_id'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.readmission.index')
            ->with('status', "Readmission letter {$letter->reference_no} created.");
    }

    public function show(ReadmissionLetter $readmissionLetter)
    {
        $readmissionLetter->load(['student.program', 'student.department', 'readmissionAcademicSession', 'readmissionCondition', 'signatory']);

        return view('ddsdce.readmission.show', compact('readmissionLetter'));
    }

    public function edit(ReadmissionLetter $readmissionLetter)
    {
        $readmissionLetter->load(['student.program', 'student.department', 'readmissionAcademicSession', 'readmissionCondition', 'signatory']);

        return view('ddsdce.readmission.edit', [
            'readmissionLetter' => $readmissionLetter,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateReadmissionLetterRequest $request, ReadmissionLetter $readmissionLetter)
    {
        $data = $request->validated();

        $readmissionLetter->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.readmission.index')
            ->with('status', "Readmission letter {$readmissionLetter->reference_no} updated.");
    }

    public function destroy(Request $request, ReadmissionLetter $readmissionLetter)
    {
        $referenceNo = $readmissionLetter->reference_no;

        $readmissionLetter->update(['updated_by' => $request->user()->id]);
        $readmissionLetter->delete();

        return redirect()->route('ddsdce.readmission.index')
            ->with('status', "Readmission letter {$referenceNo} deleted.");
    }

    public function viewPdf(ReadmissionLetter $readmissionLetter)
    {
        return $this->buildPdf($readmissionLetter)->stream($this->pdfFilename($readmissionLetter));
    }

    public function print(ReadmissionLetter $readmissionLetter)
    {
        return $this->buildPdf($readmissionLetter)->download($this->pdfFilename($readmissionLetter));
    }

    private function buildPdf(ReadmissionLetter $readmissionLetter)
    {
        $readmissionLetter->load(['student.program', 'student.department.kulliyyah', 'readmissionAcademicSession', 'readmissionCondition', 'signatory']);

        $pdf = Pdf::loadView('ddsdce.readmission.pdf', [
            'readmissionLetter' => $readmissionLetter,
            'formattedDate' => $readmissionLetter->date->format('j F Y'),
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(ReadmissionLetter $readmissionLetter): string
    {
        $reference = str_replace('/', '-', $readmissionLetter->reference_no);

        return "{$reference}-{$readmissionLetter->student->matric_no}.pdf";
    }

    private function formData(): array
    {
        return [
            'students' => Student::with(['program', 'department.kulliyyah'])->orderBy('name')->get(),
            'academicSessions' => AcademicSession::orderByDesc('academic_year')->orderByDesc('semester')->get(),
            'readmissionConditions' => ReadmissionCondition::where('is_active', true)->orderBy('name')->get(),
            'defaultSignatory' => Signatory::where('is_active', true)->orderBy('id')->first(),
        ];
    }
}
