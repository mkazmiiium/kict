<?php

use App\Http\Controllers\Administration\StudentController;
use App\Http\Controllers\Administration\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Administration\OffenseController;
use App\Http\Controllers\DDSDCE\AttendanceLetterController;
use App\Http\Controllers\DDSDCE\CounsellingRecordController;
use App\Http\Controllers\DDSDCE\DashboardController;
use App\Http\Controllers\DDSDCE\DisciplinaryController;
use App\Http\Controllers\DDSDCE\DsuStudentController;
use App\Http\Controllers\DDSDCE\ExpectedGraduationLetterController;
use App\Http\Controllers\DDSDCE\LoaLetterController;
use App\Http\Controllers\DDSDCE\ProvisionalRecordController;
use App\Http\Controllers\DDSDCE\ReadmissionLetterController;
use App\Http\Controllers\DDSDCE\ReinstateRecordController;
use App\Http\Controllers\Administration\ReadmissionConditionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', function () {
    return view('auth-forgot-password-basic');
})->name('password.request');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::middleware('role:Superadmin|DDAI Office')->group(function () {
        Route::get('/ddai', function () {
            return view('ddai.coming-soon');
        })->name('ddai.index');
    });

    Route::middleware('role:Superadmin|DDSDCE Office')->group(function () {
        Route::prefix('ddsdce')->name('ddsdce.')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            Route::prefix('attendance-letters')->name('attendance.')->group(function () {
                Route::get('/', [AttendanceLetterController::class, 'index'])->name('index');
                Route::get('/export-pdf', [AttendanceLetterController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [AttendanceLetterController::class, 'create'])->name('create');
                Route::post('/', [AttendanceLetterController::class, 'store'])->name('store');
                Route::get('/{attendanceLetter}', [AttendanceLetterController::class, 'show'])->name('show');
                Route::get('/{attendanceLetter}/edit', [AttendanceLetterController::class, 'edit'])->name('edit');
                Route::put('/{attendanceLetter}', [AttendanceLetterController::class, 'update'])->name('update');
                Route::delete('/{attendanceLetter}', [AttendanceLetterController::class, 'destroy'])->name('destroy');
                Route::get('/{attendanceLetter}/view-pdf', [AttendanceLetterController::class, 'viewPdf'])->name('view-pdf');
                Route::get('/{attendanceLetter}/print', [AttendanceLetterController::class, 'print'])->name('print');
            });

            Route::prefix('expected-graduation-letters')->name('expected-graduation.')->group(function () {
                Route::get('/', [ExpectedGraduationLetterController::class, 'index'])->name('index');
                Route::get('/export-pdf', [ExpectedGraduationLetterController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [ExpectedGraduationLetterController::class, 'create'])->name('create');
                Route::post('/', [ExpectedGraduationLetterController::class, 'store'])->name('store');
                Route::get('/{expectedGraduationLetter}', [ExpectedGraduationLetterController::class, 'show'])->name('show');
                Route::get('/{expectedGraduationLetter}/edit', [ExpectedGraduationLetterController::class, 'edit'])->name('edit');
                Route::put('/{expectedGraduationLetter}', [ExpectedGraduationLetterController::class, 'update'])->name('update');
                Route::delete('/{expectedGraduationLetter}', [ExpectedGraduationLetterController::class, 'destroy'])->name('destroy');
                Route::get('/{expectedGraduationLetter}/view-pdf', [ExpectedGraduationLetterController::class, 'viewPdf'])->name('view-pdf');
                Route::get('/{expectedGraduationLetter}/print', [ExpectedGraduationLetterController::class, 'print'])->name('print');
            });

            Route::prefix('loa')->name('loa.')->group(function () {
                Route::get('/', [LoaLetterController::class, 'index'])->name('index');
                Route::get('/export-pdf', [LoaLetterController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [LoaLetterController::class, 'create'])->name('create');
                Route::post('/', [LoaLetterController::class, 'store'])->name('store');
                Route::get('/{loaLetter}', [LoaLetterController::class, 'show'])->name('show');
                Route::get('/{loaLetter}/edit', [LoaLetterController::class, 'edit'])->name('edit');
                Route::put('/{loaLetter}', [LoaLetterController::class, 'update'])->name('update');
                Route::delete('/{loaLetter}', [LoaLetterController::class, 'destroy'])->name('destroy');
                Route::get('/{loaLetter}/view-pdf', [LoaLetterController::class, 'viewPdf'])->name('view-pdf');
                Route::get('/{loaLetter}/print', [LoaLetterController::class, 'print'])->name('print');
            });

            Route::prefix('readmission')->name('readmission.')->group(function () {
                Route::get('/', [ReadmissionLetterController::class, 'index'])->name('index');
                Route::get('/export-pdf', [ReadmissionLetterController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [ReadmissionLetterController::class, 'create'])->name('create');
                Route::post('/', [ReadmissionLetterController::class, 'store'])->name('store');
                Route::get('/{readmissionLetter}', [ReadmissionLetterController::class, 'show'])->name('show');
                Route::get('/{readmissionLetter}/edit', [ReadmissionLetterController::class, 'edit'])->name('edit');
                Route::put('/{readmissionLetter}', [ReadmissionLetterController::class, 'update'])->name('update');
                Route::delete('/{readmissionLetter}', [ReadmissionLetterController::class, 'destroy'])->name('destroy');
                Route::get('/{readmissionLetter}/view-pdf', [ReadmissionLetterController::class, 'viewPdf'])->name('view-pdf');
                Route::get('/{readmissionLetter}/print', [ReadmissionLetterController::class, 'print'])->name('print');
            });

            Route::prefix('dsu')->name('dsu.')->group(function () {
                Route::get('/', [DsuStudentController::class, 'index'])->name('index');
                Route::get('/export-pdf', [DsuStudentController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [DsuStudentController::class, 'create'])->name('create');
                Route::post('/', [DsuStudentController::class, 'store'])->name('store');
                Route::get('/{dsuStudent}', [DsuStudentController::class, 'show'])->name('show');
                Route::get('/{dsuStudent}/edit', [DsuStudentController::class, 'edit'])->name('edit');
                Route::put('/{dsuStudent}', [DsuStudentController::class, 'update'])->name('update');
                Route::delete('/{dsuStudent}', [DsuStudentController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('disciplinary')->name('disciplinary.')->group(function () {
                Route::get('/', [DisciplinaryController::class, 'index'])->name('index');
                Route::get('/export-pdf', [DisciplinaryController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [DisciplinaryController::class, 'create'])->name('create');
                Route::post('/', [DisciplinaryController::class, 'store'])->name('store');
                Route::get('/{disciplinaryRecord}', [DisciplinaryController::class, 'show'])->name('show');
                Route::get('/{disciplinaryRecord}/edit', [DisciplinaryController::class, 'edit'])->name('edit');
                Route::put('/{disciplinaryRecord}', [DisciplinaryController::class, 'update'])->name('update');
                Route::delete('/{disciplinaryRecord}', [DisciplinaryController::class, 'destroy'])->name('destroy');
                Route::post('/{disciplinaryRecord}/cancel', [DisciplinaryController::class, 'cancel'])->name('cancel');
                Route::post('/{disciplinaryRecord}/escalate', [DisciplinaryController::class, 'escalate'])->name('escalate');
                Route::delete('/{disciplinaryRecord}/photos/{photo}', [DisciplinaryController::class, 'destroyPhoto'])->name('photos.destroy');
            });

            Route::prefix('provisional')->name('provisional.')->group(function () {
                Route::get('/', [ProvisionalRecordController::class, 'index'])->name('index');
                Route::get('/export-pdf', [ProvisionalRecordController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [ProvisionalRecordController::class, 'create'])->name('create');
                Route::post('/', [ProvisionalRecordController::class, 'store'])->name('store');
                Route::get('/{provisionalRecord}/edit', [ProvisionalRecordController::class, 'edit'])->name('edit');
                Route::put('/{provisionalRecord}', [ProvisionalRecordController::class, 'update'])->name('update');
                Route::delete('/{provisionalRecord}', [ProvisionalRecordController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('reinstate')->name('reinstate.')->group(function () {
                Route::get('/', [ReinstateRecordController::class, 'index'])->name('index');
                Route::get('/export-pdf', [ReinstateRecordController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [ReinstateRecordController::class, 'create'])->name('create');
                Route::post('/', [ReinstateRecordController::class, 'store'])->name('store');
                Route::get('/{reinstateRecord}/edit', [ReinstateRecordController::class, 'edit'])->name('edit');
                Route::put('/{reinstateRecord}', [ReinstateRecordController::class, 'update'])->name('update');
                Route::delete('/{reinstateRecord}', [ReinstateRecordController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('counselling')->name('counselling.')->group(function () {
                Route::get('/', [CounsellingRecordController::class, 'index'])->name('index');
                Route::get('/export-pdf', [CounsellingRecordController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [CounsellingRecordController::class, 'create'])->name('create');
                Route::post('/', [CounsellingRecordController::class, 'store'])->name('store');
                Route::get('/{counsellingRecord}', [CounsellingRecordController::class, 'show'])->name('show');
                Route::get('/{counsellingRecord}/edit', [CounsellingRecordController::class, 'edit'])->name('edit');
                Route::put('/{counsellingRecord}', [CounsellingRecordController::class, 'update'])->name('update');
                Route::delete('/{counsellingRecord}', [CounsellingRecordController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('administration')->name('administration.')->group(function () {
            Route::prefix('students')->name('students.')->group(function () {
                Route::get('/', [StudentController::class, 'index'])->name('index');
                Route::get('/export-pdf', [StudentController::class, 'exportPdf'])->name('export-pdf');
                Route::get('/create', [StudentController::class, 'create'])->name('create');
                Route::post('/', [StudentController::class, 'store'])->name('store');
                Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
                Route::put('/{student}', [StudentController::class, 'update'])->name('update');
                Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
            });
        });
    });

    Route::middleware('role:Superadmin')->prefix('administration')->name('administration.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/export-pdf', [UserController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('offenses')->name('offenses.')->group(function () {
            Route::get('/', [OffenseController::class, 'index'])->name('index');
            Route::get('/export-pdf', [OffenseController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/create', [OffenseController::class, 'create'])->name('create');
            Route::post('/', [OffenseController::class, 'store'])->name('store');
            Route::get('/{offense}/edit', [OffenseController::class, 'edit'])->name('edit');
            Route::put('/{offense}', [OffenseController::class, 'update'])->name('update');
            Route::delete('/{offense}', [OffenseController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('readmission-conditions')->name('readmission-conditions.')->group(function () {
            Route::get('/', [ReadmissionConditionController::class, 'index'])->name('index');
            Route::get('/export-pdf', [ReadmissionConditionController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/create', [ReadmissionConditionController::class, 'create'])->name('create');
            Route::post('/', [ReadmissionConditionController::class, 'store'])->name('store');
            Route::get('/{readmissionCondition}/edit', [ReadmissionConditionController::class, 'edit'])->name('edit');
            Route::put('/{readmissionCondition}', [ReadmissionConditionController::class, 'update'])->name('update');
            Route::delete('/{readmissionCondition}', [ReadmissionConditionController::class, 'destroy'])->name('destroy');
        });
    });
});
