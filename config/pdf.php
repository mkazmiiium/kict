<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Letter PDF Owner Password
    |--------------------------------------------------------------------------
    |
    | Downloaded letter PDFs (Attendance and Expected Graduation letters) can
    | always be opened/viewed without a password, but are locked against
    | editing and copying content. This owner password is what would be
    | required to remove those restrictions. Change it via the PDF_PASSWORD
    | environment variable, or by editing the default below.
    |
    */

    'password' => env('PDF_PASSWORD', '0000'),

];
