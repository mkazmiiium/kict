<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoaLetter\StoreLoaLetterRequest;
use App\Http\Requests\LoaLetter\UpdateLoaLetterRequest;
use App\Models\AcademicSession;
use App\Models\LoaLetter;
use App\Models\Signatory;
use App\Models\Student;
use App\Services\LetterNumberingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LoaLetterController extends Controller
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

        return view('ddsdce.loa.index', [
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

        $rows = $letters->map(fn (LoaLetter $letter) => [
            $letter->reference_no,
            $letter->student->name,
            $letter->student->matric_no,
            $letter->date->format('d M Y'),
            $letter->leaveAcademicSession->label(),
            ucfirst($letter->status),
        ])->all();

        $filters = $this->filterSummary($search, $filterMonth, $filterYear);

        return $this->exportListPdf(
            'Leave of Absence Letters',
            ['Reference No.', 'Student Name', 'Matric No.', 'Date Issued', 'Leave Semester', 'Status'],
            $rows,
            $filters
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, $filterMonth, $filterYear)
    {
        $sortable = [
            'reference_no' => 'loa_letters.reference_no',
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'loa_letters.date',
            'meeting_number' => 'loa_letters.meeting_number',
            'status' => 'loa_letters.status',
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return LoaLetter::query()
            ->select('loa_letters.*')
            ->join('students', 'students.id', '=', 'loa_letters.student_id')
            ->with(['student', 'leaveAcademicSession'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('loa_letters.reference_no', 'like', "%{$search}%")
                        ->orWhere('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%");
                });
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('loa_letters.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('loa_letters.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('loa_letters.id');
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
        return view('ddsdce.loa.create', $this->formData());
    }

    public function store(StoreLoaLetterRequest $request, LetterNumberingService $numbering)
    {
        $data = $request->validated();
        $numbered = $numbering->generate('LOA');

        $letter = LoaLetter::create([
            ...$data,
            'reference_no' => $numbered['reference_no'],
            'letter_type_id' => $numbered['letter_type_id'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.loa.index')
            ->with('status', "LOA letter {$letter->reference_no} created.");
    }

    public function show(LoaLetter $loaLetter)
    {
        $loaLetter->load(['student.program', 'student.department', 'leaveAcademicSession', 'signatory']);

        return view('ddsdce.loa.show', compact('loaLetter'));
    }

    public function edit(LoaLetter $loaLetter)
    {
        $loaLetter->load(['student.program', 'student.department', 'leaveAcademicSession', 'signatory']);

        return view('ddsdce.loa.edit', [
            'loaLetter' => $loaLetter,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateLoaLetterRequest $request, LoaLetter $loaLetter)
    {
        $data = $request->validated();

        $loaLetter->update([
            ...$data,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('ddsdce.loa.index')
            ->with('status', "LOA letter {$loaLetter->reference_no} updated.");
    }

    public function destroy(Request $request, LoaLetter $loaLetter)
    {
        $referenceNo = $loaLetter->reference_no;

        $loaLetter->update(['updated_by' => $request->user()->id]);
        $loaLetter->delete();

        return redirect()->route('ddsdce.loa.index')
            ->with('status', "LOA letter {$referenceNo} deleted.");
    }

    public function viewPdf(LoaLetter $loaLetter)
    {
        return $this->buildPdf($loaLetter)->stream($this->pdfFilename($loaLetter));
    }

    public function print(LoaLetter $loaLetter)
    {
        return $this->buildPdf($loaLetter)->download($this->pdfFilename($loaLetter));
    }

    private function buildPdf(LoaLetter $loaLetter)
    {
        $loaLetter->load(['student.program', 'student.department.kulliyyah', 'leaveAcademicSession', 'signatory']);

        $pdf = Pdf::loadView('ddsdce.loa.pdf', [
            'loaLetter' => $loaLetter,
            'formattedDate' => $loaLetter->date->format('j F Y'),
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(LoaLetter $loaLetter): string
    {
        $reference = str_replace('/', '-', $loaLetter->reference_no);

        return "{$reference}-{$loaLetter->student->matric_no}.pdf";
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
