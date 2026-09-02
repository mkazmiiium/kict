<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Current Academic Session
    |--------------------------------------------------------------------------
    |
    | Used to calculate how many semesters a DSU student has completed since
    | joining. Update these two values at the start of each new semester —
    | via the ACADEMIC_CURRENT_YEAR / ACADEMIC_CURRENT_SEMESTER env vars, or
    | by editing the defaults below. Only semesters 1 and 2 are counted;
    | semester 3 (short semester) is excluded from the calculation.
    |
    */

    'current_year' => env('ACADEMIC_CURRENT_YEAR', '2026/2027'),

    'current_semester' => (int) env('ACADEMIC_CURRENT_SEMESTER', 1),

];
