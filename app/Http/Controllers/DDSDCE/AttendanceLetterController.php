<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceLetter\StoreAttendanceLetterRequest;
use App\Http\Requests\AttendanceLetter\UpdateAttendanceLetterRequest;
use App\Models\AcademicSession;
use App\Models\AttendanceLetter;
use App\Models\Signatory;
use App\Models\Student;
use App\Services\LetterNumberingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceLetterController extends Controller
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

        return view('ddsdce.attendance.index', [
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

        $rows = $letters->map(fn (AttendanceLetter $letter) => [
            $letter->reference_no,
            $letter->student->name,
            $letter->student->matric_no,
            $letter->date->format('d M Y'),
            $letter->academicSessions->map(fn ($s) => $s->label())->implode(', ') ?: '—',
        ])->all();

        $filters = $this->filterSummary($search, $filterMonth, $filterYear);

        return $this->exportListPdf(
            'Attendance Letters',
            ['Reference No.', 'Student Name', 'Matric No.', 'Date Issued', 'Semester(s)'],
            $rows,
            $filters
        );
    }

    private function filteredQuery(string $sort, string $direction, ?string $search, $filterMonth, $filterYear)
    {
        $sortable = [
            'reference_no' => 'attendance_letters.reference_no',
            'student_name' => 'students.name',
            'matric_no' => 'students.matric_no',
            'date' => 'attendance_letters.date',
            'semesters' => DB::raw('(
                select min(cast(substring_index(acs.academic_year, "/", 1) as unsigned) * 10 + acs.semester)
                from attendance_letter_academic_session alas
                inner join academic_sessions acs on acs.id = alas.academic_session_id
                where alas.attendance_letter_id = attendance_letters.id
            )'),
        ];

        $sortColumn = $sortable[$sort] ?? $sortable['date'];

        return AttendanceLetter::query()
            ->select('attendance_letters.*')
            ->join('students', 'students.id', '=', 'attendance_letters.student_id')
            ->with(['student', 'academicSessions'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('attendance_letters.reference_no', 'like', "%{$search}%")
                        ->orWhere('students.name', 'like', "%{$search}%")
                        ->orWhere('students.matric_no', 'like', "%{$search}%")
                        ->orWhereHas('academicSessions', function ($sessionQuery) use ($search) {
                            $sessionQuery->where('academic_year', 'like', "%{$search}%");
                        });
                });
            })
            ->when($filterMonth, function ($query) use ($filterMonth) {
                $query->whereMonth('attendance_letters.date', $filterMonth);
            })
            ->when($filterYear, function ($query) use ($filterYear) {
                $query->whereYear('attendance_letters.date', $filterYear);
            })
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('attendance_letters.id');
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
        return view('ddsdce.attendance.create', $this->formData());
    }

    public function store(StoreAttendanceLetterRequest $request, LetterNumberingService $numbering)
    {
        $data = $request->validated();
        $numbered = $numbering->generate('ATTENDANCE');

        $letter = AttendanceLetter::create([
            'reference_no' => $numbered['reference_no'],
            'letter_type_id' => $numbered['letter_type_id'],
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'attendance_percentage' => $data['attendance_percentage'],
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        $letter->academicSessions()->sync($data['academic_session_ids']);

        return redirect()->route('ddsdce.attendance.index')
            ->with('status', "Attendance letter {$letter->reference_no} created.");
    }

    public function show(AttendanceLetter $attendanceLetter)
    {
        $attendanceLetter->load(['student.program', 'student.department', 'signatory', 'academicSessions']);

        return view('ddsdce.attendance.show', compact('attendanceLetter'));
    }

    public function edit(AttendanceLetter $attendanceLetter)
    {
        $attendanceLetter->load(['academicSessions', 'signatory', 'student']);

        return view('ddsdce.attendance.edit', [
            'attendanceLetter' => $attendanceLetter,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateAttendanceLetterRequest $request, AttendanceLetter $attendanceLetter)
    {
        $data = $request->validated();

        $attendanceLetter->update([
            'date' => $data['date'],
            'student_id' => $data['student_id'],
            'attendance_percentage' => $data['attendance_percentage'],
            'body_text' => $data['body_text'],
            'signatory_id' => $data['signatory_id'],
            'language' => $data['language'],
            'updated_by' => $request->user()->id,
        ]);

        $attendanceLetter->academicSessions()->sync($data['academic_session_ids']);

        return redirect()->route('ddsdce.attendance.index')
            ->with('status', "Attendance letter {$attendanceLetter->reference_no} updated.");
    }

    public function destroy(Request $request, AttendanceLetter $attendanceLetter)
    {
        $referenceNo = $attendanceLetter->reference_no;

        $attendanceLetter->update(['updated_by' => $request->user()->id]);
        $attendanceLetter->delete();

        return redirect()->route('ddsdce.attendance.index')
            ->with('status', "Attendance letter {$referenceNo} deleted.");
    }

    public function viewPdf(AttendanceLetter $attendanceLetter)
    {
        return $this->buildPdf($attendanceLetter)->stream($this->pdfFilename($attendanceLetter));
    }

    public function print(AttendanceLetter $attendanceLetter)
    {
        return $this->buildPdf($attendanceLetter)->download($this->pdfFilename($attendanceLetter));
    }

    private function buildPdf(AttendanceLetter $attendanceLetter)
    {
        $attendanceLetter->load(['student.program', 'student.department.kulliyyah', 'signatory', 'academicSessions']);

        $pdf = Pdf::loadView('ddsdce.attendance.pdf', [
            'attendanceLetter' => $attendanceLetter,
            'formattedDate' => $this->malayDate($attendanceLetter->date),
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(AttendanceLetter $attendanceLetter): string
    {
        $reference = str_replace('/', '-', $attendanceLetter->reference_no);

        return "{$reference}-{$attendanceLetter->student->matric_no}.pdf";
    }

    private function malayDate($date): string
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember',
        ];

        return $date->day.' '.$months[(int) $date->month].' '.$date->year;
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
