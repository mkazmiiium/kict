<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLetter;
use App\Models\CompletionLetter;
use App\Models\CounsellingRecord;
use App\Models\DisciplinaryRecord;
use App\Models\DsuStudent;
use App\Models\ExpectedGraduationLetter;
use App\Models\LoaLetter;
use App\Models\ProvisionalRecord;
use App\Models\ReadmissionLetter;
use App\Models\ReinstateRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filterYear = $request->filled('year') ? (int) $request->year : null;
        $filterMonth = $request->filled('month') ? (int) $request->month : null;
        $filterDateFrom = $request->filled('date_from') ? $request->date_from : null;
        $filterDateTo = $request->filled('date_to') ? $request->date_to : null;
        $filterActive = (bool) ($filterYear || $filterMonth || $filterDateFrom || $filterDateTo);

        $attendanceCount = $this->filteredCount(AttendanceLetter::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $expectedGraduationCount = $this->filteredCount(ExpectedGraduationLetter::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $completionCount = $this->filteredCount(CompletionLetter::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $loaCount = $this->filteredCount(LoaLetter::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $readmissionCount = $this->filteredCount(ReadmissionLetter::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $lettersCount = $attendanceCount + $expectedGraduationCount + $completionCount + $loaCount + $readmissionCount;

        $disciplinaryCount = $this->filteredCount(DisciplinaryRecord::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $disciplinaryOverdueCount = $this->applyFilters(
            DisciplinaryRecord::where('status', 'pending')->whereDate('due_date', '<', now()),
            'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo
        )->count();

        $dsuCount = $this->filteredCount(DsuStudent::class, 'created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $dsuByCategory = $this->applyFilters(DsuStudent::query(), 'dsu_students.created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)
            ->selectRaw('disability_categories.name, disability_categories.code, count(*) as total')
            ->leftJoin('disability_categories', 'disability_categories.id', '=', 'dsu_students.disability_category_id')
            ->groupBy('disability_categories.id', 'disability_categories.name', 'disability_categories.code')
            ->orderByDesc('total')
            ->get();

        $disciplinaryByOffense = $this->applyFilters(DisciplinaryRecord::query(), 'disciplinary_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)
            ->selectRaw('offenses.name, count(*) as total')
            ->leftJoin('offenses', 'offenses.id', '=', 'disciplinary_records.offense_id')
            ->groupBy('offenses.id', 'offenses.name')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $provisionalCount = $this->filteredCount(ProvisionalRecord::class, 'created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $reinstateCount = $this->filteredCount(ReinstateRecord::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $academicStandingCount = $provisionalCount + $reinstateCount;

        $counsellingCount = $this->filteredCount(CounsellingRecord::class, 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        $counsellingPendingEmailCount = $this->applyFilters(
            CounsellingRecord::whereNull('emailed_to_ccsc_date'),
            'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo
        )->count();

        $grandTotal = $lettersCount + $disciplinaryCount + $dsuCount + $academicStandingCount + $counsellingCount;

        // Trend chart window: an explicit date range or year picks a matching set of
        // months; otherwise fall back to the default rolling last-6-months view. A
        // lone "month" filter (recurring, any year — matching the rest of the app's
        // month/year filters) has no single contiguous window, so the trend keeps
        // showing the rolling 6 months in that case.
        if ($filterDateFrom || $filterDateTo) {
            $start = $filterDateFrom ? Carbon::parse($filterDateFrom)->startOfMonth() : Carbon::parse($filterDateTo)->copy()->subMonths(5)->startOfMonth();
            $end = $filterDateTo ? Carbon::parse($filterDateTo)->startOfMonth() : Carbon::now()->startOfMonth();
            if ($start->gt($end)) {
                [$start, $end] = [$end, $start];
            }
            $months = collect();
            $cursor = $start->copy();
            while ($cursor->lte($end) && $months->count() < 24) {
                $months->push($cursor->copy());
                $cursor->addMonth();
            }
        } elseif ($filterYear) {
            $months = collect(range(0, 11))->map(fn ($m) => Carbon::create($filterYear, $m + 1, 1));
        } else {
            $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i)->startOfMonth());
        }
        $monthlyLabels = $months->map(fn ($m) => $m->format('M Y'));

        $monthlyCountsBy = function (string $model, string $column) use ($months) {
            $counts = $model::selectRaw("DATE_FORMAT({$column}, '%Y-%m') as ym, count(*) as total")
                ->where($column, '>=', $months->first())
                ->where($column, '<=', $months->last()->copy()->endOfMonth())
                ->groupBy('ym')
                ->pluck('total', 'ym');

            return $months->map(fn ($m) => (int) ($counts[$m->format('Y-m')] ?? 0));
        };

        $attendanceMonthly = $monthlyCountsBy(AttendanceLetter::class, 'date');
        $expectedGraduationMonthly = $monthlyCountsBy(ExpectedGraduationLetter::class, 'date');
        $completionMonthly = $monthlyCountsBy(CompletionLetter::class, 'date');
        $loaMonthly = $monthlyCountsBy(LoaLetter::class, 'date');
        $readmissionMonthly = $monthlyCountsBy(ReadmissionLetter::class, 'date');
        $disciplinaryMonthly = $monthlyCountsBy(DisciplinaryRecord::class, 'date');
        $dsuMonthly = $monthlyCountsBy(DsuStudent::class, 'created_at');
        $provisionalMonthly = $monthlyCountsBy(ProvisionalRecord::class, 'created_at');
        $reinstateMonthly = $monthlyCountsBy(ReinstateRecord::class, 'date');
        $counsellingMonthly = $monthlyCountsBy(CounsellingRecord::class, 'date');

        $indexes = range(0, $months->count() - 1);
        $lettersMonthly = collect($indexes)->map(fn ($i) => $attendanceMonthly[$i] + $expectedGraduationMonthly[$i] + $completionMonthly[$i] + $loaMonthly[$i] + $readmissionMonthly[$i]);
        $academicStandingMonthly = collect($indexes)->map(fn ($i) => $provisionalMonthly[$i] + $reinstateMonthly[$i]);

        $recentActivity = collect()
            ->concat($this->applyFilters(AttendanceLetter::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Attendance',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.attendance.show', $l),
            ]))
            ->concat($this->applyFilters(ExpectedGraduationLetter::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Expected Graduation',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.expected-graduation.show', $l),
            ]))
            ->concat($this->applyFilters(CompletionLetter::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Completion',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.completion.show', $l),
            ]))
            ->concat($this->applyFilters(LoaLetter::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'LOA',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.loa.show', $l),
            ]))
            ->concat($this->applyFilters(ReadmissionLetter::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Readmission',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.readmission.show', $l),
            ]))
            ->concat($this->applyFilters(DisciplinaryRecord::with(['student', 'offense']), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($r) => [
                'reference_no' => $r->offense->name ?? 'Disciplinary Case',
                'type' => 'Disciplinary',
                'student' => $r->student->name,
                'date' => $r->date,
                'url' => route('ddsdce.disciplinary.show', $r),
            ]))
            ->concat($this->applyFilters(DsuStudent::with(['student', 'disabilityCategory']), 'created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($d) => [
                'reference_no' => $d->disabilityCategory->name ?? 'DSU Registration',
                'type' => 'DSU',
                'student' => $d->student->name,
                'date' => $d->created_at,
                'url' => route('ddsdce.dsu.show', $d),
            ]))
            ->concat($this->applyFilters(ProvisionalRecord::with(['student', 'academicSession']), 'created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($p) => [
                'reference_no' => $p->academicSession->label(),
                'type' => 'Provisional',
                'student' => $p->student->name,
                'date' => $p->created_at,
                'url' => route('ddsdce.provisional.edit', $p),
            ]))
            ->concat($this->applyFilters(ReinstateRecord::with(['student', 'academicSession']), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($r) => [
                'reference_no' => $r->academicSession->label(),
                'type' => 'Reinstatement',
                'student' => $r->student->name,
                'date' => $r->created_at,
                'url' => route('ddsdce.reinstate.edit', $r),
            ]))
            ->concat($this->applyFilters(CounsellingRecord::with('student'), 'date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo)->latest('id')->take(5)->get()->map(fn ($c) => [
                'reference_no' => $c->referred_by ? "Referred by {$c->referred_by}" : 'Counselling Record',
                'type' => 'Counselling',
                'student' => $c->student->name,
                'date' => $c->date,
                'url' => route('ddsdce.counselling.show', $c),
            ]))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        $attendanceByProgram = $this->programBreakdown(AttendanceLetter::class, $this->filterConstraint('attendance_letters.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $expectedGraduationByProgram = $this->programBreakdown(ExpectedGraduationLetter::class, $this->filterConstraint('expected_graduation_letters.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $completionByProgram = $this->programBreakdown(CompletionLetter::class, $this->filterConstraint('completion_letters.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $loaByProgram = $this->programBreakdown(LoaLetter::class, $this->filterConstraint('loa_letters.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $readmissionByProgram = $this->programBreakdown(ReadmissionLetter::class, $this->filterConstraint('readmission_letters.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $disciplinaryByProgram = $this->programBreakdown(DisciplinaryRecord::class, $this->filterConstraint('disciplinary_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $dsuByProgram = $this->programBreakdown(DsuStudent::class, $this->filterConstraint('dsu_students.created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $provisionalByProgram = $this->programBreakdown(ProvisionalRecord::class, $this->filterConstraint('provisional_records.created_at', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $reinstateByProgram = $this->programBreakdown(ReinstateRecord::class, $this->filterConstraint('reinstate_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));
        $counsellingByProgram = $this->programBreakdown(CounsellingRecord::class, $this->filterConstraint('counselling_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo));

        $grandTotalByProgram = $this->mergeBreakdowns(
            $attendanceByProgram, $expectedGraduationByProgram, $completionByProgram, $loaByProgram, $readmissionByProgram,
            $disciplinaryByProgram, $dsuByProgram, $provisionalByProgram, $reinstateByProgram, $counsellingByProgram,
        );

        // When a filter is active, this card tracks that same filtered period (so
        // every number on the page agrees with the filter bar); with no filter, it
        // falls back to the real current calendar month.
        if ($filterActive) {
            $newRecordsThisMonthCount = $grandTotal;
            $newThisMonthByProgram = $grandTotalByProgram;
        } else {
            $startOfMonth = now()->startOfMonth();
            $newRecordsThisMonthCount = AttendanceLetter::where('date', '>=', $startOfMonth)->count()
                + ExpectedGraduationLetter::where('date', '>=', $startOfMonth)->count()
                + CompletionLetter::where('date', '>=', $startOfMonth)->count()
                + LoaLetter::where('date', '>=', $startOfMonth)->count()
                + ReadmissionLetter::where('date', '>=', $startOfMonth)->count()
                + DisciplinaryRecord::where('date', '>=', $startOfMonth)->count()
                + DsuStudent::where('created_at', '>=', $startOfMonth)->count()
                + ProvisionalRecord::where('created_at', '>=', $startOfMonth)->count()
                + ReinstateRecord::where('date', '>=', $startOfMonth)->count()
                + CounsellingRecord::where('date', '>=', $startOfMonth)->count();

            $newThisMonthByProgram = $this->mergeBreakdowns(
                $this->programBreakdown(AttendanceLetter::class, fn ($q) => $q->where('attendance_letters.date', '>=', $startOfMonth)),
                $this->programBreakdown(ExpectedGraduationLetter::class, fn ($q) => $q->where('expected_graduation_letters.date', '>=', $startOfMonth)),
                $this->programBreakdown(CompletionLetter::class, fn ($q) => $q->where('completion_letters.date', '>=', $startOfMonth)),
                $this->programBreakdown(LoaLetter::class, fn ($q) => $q->where('loa_letters.date', '>=', $startOfMonth)),
                $this->programBreakdown(ReadmissionLetter::class, fn ($q) => $q->where('readmission_letters.date', '>=', $startOfMonth)),
                $this->programBreakdown(DisciplinaryRecord::class, fn ($q) => $q->where('disciplinary_records.date', '>=', $startOfMonth)),
                $this->programBreakdown(DsuStudent::class, fn ($q) => $q->where('dsu_students.created_at', '>=', $startOfMonth)),
                $this->programBreakdown(ProvisionalRecord::class, fn ($q) => $q->where('provisional_records.created_at', '>=', $startOfMonth)),
                $this->programBreakdown(ReinstateRecord::class, fn ($q) => $q->where('reinstate_records.date', '>=', $startOfMonth)),
                $this->programBreakdown(CounsellingRecord::class, fn ($q) => $q->where('counselling_records.date', '>=', $startOfMonth)),
            );
        }

        $disciplinaryOverdueByProgram = $this->programBreakdown(DisciplinaryRecord::class, function ($q) use ($filterYear, $filterMonth, $filterDateFrom, $filterDateTo) {
            $q->where('disciplinary_records.status', 'pending')
                ->whereDate('disciplinary_records.due_date', '<', now());
            $this->applyFilters($q, 'disciplinary_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        });

        $counsellingPendingByProgram = $this->programBreakdown(CounsellingRecord::class, function ($q) use ($filterYear, $filterMonth, $filterDateFrom, $filterDateTo) {
            $q->whereNull('counselling_records.emailed_to_ccsc_date');
            $this->applyFilters($q, 'counselling_records.date', $filterYear, $filterMonth, $filterDateFrom, $filterDateTo);
        });

        $yearOptions = range(now()->year + 1, 2019);
        $monthOptions = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $filterSummaryParts = array_filter([
            $filterYear ? "Year: {$filterYear}" : null,
            $filterMonth ? 'Month: '.($monthOptions[$filterMonth] ?? $filterMonth) : null,
            $filterDateFrom ? 'From: '.Carbon::parse($filterDateFrom)->format('d M Y') : null,
            $filterDateTo ? 'To: '.Carbon::parse($filterDateTo)->format('d M Y') : null,
        ]);

        return view('ddsdce.dashboard', [
            'attendanceCount' => $attendanceCount,
            'expectedGraduationCount' => $expectedGraduationCount,
            'completionCount' => $completionCount,
            'loaCount' => $loaCount,
            'readmissionCount' => $readmissionCount,
            'lettersCount' => $lettersCount,
            'disciplinaryCount' => $disciplinaryCount,
            'disciplinaryOverdueCount' => $disciplinaryOverdueCount,
            'dsuCount' => $dsuCount,
            'dsuByCategory' => $dsuByCategory,
            'disciplinaryByOffense' => $disciplinaryByOffense,
            'provisionalCount' => $provisionalCount,
            'reinstateCount' => $reinstateCount,
            'academicStandingCount' => $academicStandingCount,
            'counsellingCount' => $counsellingCount,
            'counsellingPendingEmailCount' => $counsellingPendingEmailCount,
            'grandTotal' => $grandTotal,
            'monthlyLabels' => $monthlyLabels,
            'lettersMonthly' => $lettersMonthly,
            'disciplinaryMonthly' => $disciplinaryMonthly,
            'dsuMonthly' => $dsuMonthly,
            'academicStandingMonthly' => $academicStandingMonthly,
            'counsellingMonthly' => $counsellingMonthly,
            'recentActivity' => $recentActivity,
            'attendanceByProgram' => $attendanceByProgram,
            'expectedGraduationByProgram' => $expectedGraduationByProgram,
            'completionByProgram' => $completionByProgram,
            'loaByProgram' => $loaByProgram,
            'readmissionByProgram' => $readmissionByProgram,
            'disciplinaryByProgram' => $disciplinaryByProgram,
            'dsuByProgram' => $dsuByProgram,
            'provisionalByProgram' => $provisionalByProgram,
            'reinstateByProgram' => $reinstateByProgram,
            'counsellingByProgram' => $counsellingByProgram,
            'grandTotalByProgram' => $grandTotalByProgram,
            'newRecordsThisMonthCount' => $newRecordsThisMonthCount,
            'newThisMonthByProgram' => $newThisMonthByProgram,
            'disciplinaryOverdueByProgram' => $disciplinaryOverdueByProgram,
            'counsellingPendingByProgram' => $counsellingPendingByProgram,
            'filterYear' => $filterYear,
            'filterMonth' => $filterMonth,
            'filterDateFrom' => $filterDateFrom,
            'filterDateTo' => $filterDateTo,
            'filterActive' => $filterActive,
            'filterSummary' => implode(', ', $filterSummaryParts),
            'yearOptions' => $yearOptions,
            'monthOptions' => $monthOptions,
        ]);
    }

    /**
     * Apply the dashboard's Year / Month / custom date-range filters to a query.
     * Year and month follow the same whereYear()/whereMonth() semantics used by
     * every module's own list-page filter (independently recurring unless both
     * are given together); the date range is an additive, exact-bounds clamp.
     */
    private function applyFilters($query, string $column, ?int $year, ?int $month, ?string $dateFrom, ?string $dateTo)
    {
        return $query
            ->when($year, fn ($q) => $q->whereYear($column, $year))
            ->when($month, fn ($q) => $q->whereMonth($column, $month))
            ->when($dateFrom, fn ($q) => $q->whereDate($column, '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->whereDate($column, '<=', $dateTo));
    }

    private function filteredCount(string $modelClass, string $column, ?int $year, ?int $month, ?string $dateFrom, ?string $dateTo): int
    {
        return $this->applyFilters($modelClass::query(), $column, $year, $month, $dateFrom, $dateTo)->count();
    }

    private function filterConstraint(string $column, ?int $year, ?int $month, ?string $dateFrom, ?string $dateTo): ?Closure
    {
        if (! $year && ! $month && ! $dateFrom && ! $dateTo) {
            return null;
        }

        return fn ($q) => $this->applyFilters($q, $column, $year, $month, $dateFrom, $dateTo);
    }

    /**
     * Count records of the given model grouped by the related student's program (BIT/BCS).
     */
    private function programBreakdown(string $modelClass, ?Closure $constraint = null): array
    {
        $table = (new $modelClass)->getTable();

        $query = $modelClass::query()
            ->join('students', 'students.id', '=', "{$table}.student_id")
            ->join('programs', 'programs.id', '=', 'students.program_id');

        if ($constraint) {
            $constraint($query);
        }

        $counts = $query->selectRaw('programs.code, count(*) as total')
            ->groupBy('programs.code')
            ->pluck('total', 'programs.code');

        return [
            'BIT' => (int) ($counts['BIT'] ?? 0),
            'BCS' => (int) ($counts['BCS'] ?? 0),
        ];
    }

    private function mergeBreakdowns(array ...$breakdowns): array
    {
        return [
            'BIT' => array_sum(array_column($breakdowns, 'BIT')),
            'BCS' => array_sum(array_column($breakdowns, 'BCS')),
        ];
    }
}
