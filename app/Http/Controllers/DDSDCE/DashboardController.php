<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLetter;
use App\Models\DisciplinaryRecord;
use App\Models\DsuStudent;
use App\Models\ExpectedGraduationLetter;
use App\Models\LoaLetter;
use App\Models\ReadmissionLetter;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $attendanceCount = AttendanceLetter::count();
        $expectedGraduationCount = ExpectedGraduationLetter::count();
        $loaCount = LoaLetter::count();
        $readmissionCount = ReadmissionLetter::count();
        $totalCount = $attendanceCount + $expectedGraduationCount + $loaCount + $readmissionCount;

        $disciplinaryCount = DisciplinaryRecord::count();
        $disciplinaryOverdueCount = DisciplinaryRecord::where('status', 'pending')
            ->whereDate('due_date', '<', now())
            ->count();
        $grandTotal = $totalCount + $disciplinaryCount;

        $dsuCount = DsuStudent::count();
        $dsuByCategory = DsuStudent::query()
            ->selectRaw('disability_categories.name, disability_categories.code, count(*) as total')
            ->leftJoin('disability_categories', 'disability_categories.id', '=', 'dsu_students.disability_category_id')
            ->groupBy('disability_categories.id', 'disability_categories.name', 'disability_categories.code')
            ->orderByDesc('total')
            ->get();

        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i)->startOfMonth());

        $monthlyCounts = function (string $model) use ($months) {
            $counts = $model::selectRaw("DATE_FORMAT(date, '%Y-%m') as ym, count(*) as total")
                ->where('date', '>=', $months->first())
                ->groupBy('ym')
                ->pluck('total', 'ym');

            return $months->map(fn ($m) => (int) ($counts[$m->format('Y-m')] ?? 0));
        };

        $monthlyLabels = $months->map(fn ($m) => $m->format('M Y'));

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
            ->sortByDesc('date')
            ->take(8)
            ->values();

        return view('ddsdce.dashboard', [
            'attendanceCount' => $attendanceCount,
            'expectedGraduationCount' => $expectedGraduationCount,
            'loaCount' => $loaCount,
            'readmissionCount' => $readmissionCount,
            'disciplinaryCount' => $disciplinaryCount,
            'disciplinaryOverdueCount' => $disciplinaryOverdueCount,
            'dsuCount' => $dsuCount,
            'dsuByCategory' => $dsuByCategory,
            'totalCount' => $totalCount,
            'grandTotal' => $grandTotal,
            'monthlyLabels' => $monthlyLabels,
            'attendanceMonthly' => $monthlyCounts(AttendanceLetter::class),
            'expectedGraduationMonthly' => $monthlyCounts(ExpectedGraduationLetter::class),
            'loaMonthly' => $monthlyCounts(LoaLetter::class),
            'readmissionMonthly' => $monthlyCounts(ReadmissionLetter::class),
            'disciplinaryMonthly' => $monthlyCounts(DisciplinaryRecord::class),
            'recentActivity' => $recentActivity,
        ]);
    }
}
