<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLetter;
use App\Models\CounsellingRecord;
use App\Models\DisciplinaryRecord;
use App\Models\DsuStudent;
use App\Models\ExpectedGraduationLetter;
use App\Models\LoaLetter;
use App\Models\ProvisionalRecord;
use App\Models\ReadmissionLetter;
use App\Models\ReinstateRecord;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $attendanceCount = AttendanceLetter::count();
        $expectedGraduationCount = ExpectedGraduationLetter::count();
        $loaCount = LoaLetter::count();
        $readmissionCount = ReadmissionLetter::count();
        $lettersCount = $attendanceCount + $expectedGraduationCount + $loaCount + $readmissionCount;

        $disciplinaryCount = DisciplinaryRecord::count();
        $disciplinaryOverdueCount = DisciplinaryRecord::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->count();

        $dsuCount = DsuStudent::count();
        $dsuByCategory = DsuStudent::query()
            ->selectRaw('disability_categories.name, disability_categories.code, count(*) as total')
            ->leftJoin('disability_categories', 'disability_categories.id', '=', 'dsu_students.disability_category_id')
            ->groupBy('disability_categories.id', 'disability_categories.name', 'disability_categories.code')
            ->orderByDesc('total')
            ->get();

        $disciplinaryByOffense = DisciplinaryRecord::query()
            ->selectRaw('offenses.name, count(*) as total')
            ->leftJoin('offenses', 'offenses.id', '=', 'disciplinary_records.offense_id')
            ->groupBy('offenses.id', 'offenses.name')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $provisionalCount = ProvisionalRecord::count();
        $reinstateCount = ReinstateRecord::count();
        $academicStandingCount = $provisionalCount + $reinstateCount;

        $counsellingCount = CounsellingRecord::count();
        $counsellingPendingEmailCount = CounsellingRecord::whereNull('emailed_to_ccsc_date')->count();

        $grandTotal = $lettersCount + $disciplinaryCount + $dsuCount + $academicStandingCount + $counsellingCount;

        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i)->startOfMonth());
        $monthlyLabels = $months->map(fn ($m) => $m->format('M Y'));

        $monthlyCountsBy = function (string $model, string $column) use ($months) {
            $counts = $model::selectRaw("DATE_FORMAT({$column}, '%Y-%m') as ym, count(*) as total")
                ->where($column, '>=', $months->first())
                ->groupBy('ym')
                ->pluck('total', 'ym');

            return $months->map(fn ($m) => (int) ($counts[$m->format('Y-m')] ?? 0));
        };

        $attendanceMonthly = $monthlyCountsBy(AttendanceLetter::class, 'date');
        $expectedGraduationMonthly = $monthlyCountsBy(ExpectedGraduationLetter::class, 'date');
        $loaMonthly = $monthlyCountsBy(LoaLetter::class, 'date');
        $readmissionMonthly = $monthlyCountsBy(ReadmissionLetter::class, 'date');
        $disciplinaryMonthly = $monthlyCountsBy(DisciplinaryRecord::class, 'date');
        $dsuMonthly = $monthlyCountsBy(DsuStudent::class, 'created_at');
        $provisionalMonthly = $monthlyCountsBy(ProvisionalRecord::class, 'created_at');
        $reinstateMonthly = $monthlyCountsBy(ReinstateRecord::class, 'date');
        $counsellingMonthly = $monthlyCountsBy(CounsellingRecord::class, 'date');

        $indexes = range(0, $months->count() - 1);
        $lettersMonthly = collect($indexes)->map(fn ($i) => $attendanceMonthly[$i] + $expectedGraduationMonthly[$i] + $loaMonthly[$i] + $readmissionMonthly[$i]);
        $academicStandingMonthly = collect($indexes)->map(fn ($i) => $provisionalMonthly[$i] + $reinstateMonthly[$i]);

        $recentActivity = collect()
            ->concat(AttendanceLetter::with('student')->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Attendance',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.attendance.show', $l),
            ]))
            ->concat(ExpectedGraduationLetter::with('student')->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Expected Graduation',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.expected-graduation.show', $l),
            ]))
            ->concat(LoaLetter::with('student')->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'LOA',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.loa.show', $l),
            ]))
            ->concat(ReadmissionLetter::with('student')->latest('id')->take(5)->get()->map(fn ($l) => [
                'reference_no' => $l->reference_no,
                'type' => 'Readmission',
                'student' => $l->student->name,
                'date' => $l->date,
                'url' => route('ddsdce.readmission.show', $l),
            ]))
            ->concat(DisciplinaryRecord::with(['student', 'offense'])->latest('id')->take(5)->get()->map(fn ($r) => [
                'reference_no' => $r->offense->name ?? 'Disciplinary Case',
                'type' => 'Disciplinary',
                'student' => $r->student->name,
                'date' => $r->date,
                'url' => route('ddsdce.disciplinary.show', $r),
            ]))
            ->concat(DsuStudent::with(['student', 'disabilityCategory'])->latest('id')->take(5)->get()->map(fn ($d) => [
                'reference_no' => $d->disabilityCategory->name ?? 'DSU Registration',
                'type' => 'DSU',
                'student' => $d->student->name,
                'date' => $d->created_at,
                'url' => route('ddsdce.dsu.show', $d),
            ]))
            ->concat(ProvisionalRecord::with(['student', 'academicSession'])->latest('id')->take(5)->get()->map(fn ($p) => [
                'reference_no' => $p->academicSession->label(),
                'type' => 'Provisional',
                'student' => $p->student->name,
                'date' => $p->created_at,
                'url' => route('ddsdce.provisional.edit', $p),
            ]))
            ->concat(ReinstateRecord::with(['student', 'academicSession'])->latest('id')->take(5)->get()->map(fn ($r) => [
                'reference_no' => $r->academicSession->label(),
                'type' => 'Reinstatement',
                'student' => $r->student->name,
                'date' => $r->created_at,
                'url' => route('ddsdce.reinstate.edit', $r),
            ]))
            ->concat(CounsellingRecord::with('student')->latest('id')->take(5)->get()->map(fn ($c) => [
                'reference_no' => $c->referred_by ? "Referred by {$c->referred_by}" : 'Counselling Record',
                'type' => 'Counselling',
                'student' => $c->student->name,
                'date' => $c->date,
                'url' => route('ddsdce.counselling.show', $c),
            ]))
            ->sortByDesc('date')
            ->take(10)
            ->values();

        return view('ddsdce.dashboard', [
            'attendanceCount' => $attendanceCount,
            'expectedGraduationCount' => $expectedGraduationCount,
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
        ]);
    }
}
