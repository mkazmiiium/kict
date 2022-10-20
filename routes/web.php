<?php

use App\Http\Controllers\DecentController;
use App\Http\Controllers\CentralisedController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [HomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
});

Route::get('/Decentralised-booking', [DecentController::class, 'index']);
Route::get('/viewsearch', [DecentController::class, 'viewsearch']);
Route::get('add_booking', [DecentController::class, 'dropmenuprogram']);
Route::post('api/fetch-course', [DecentController::class, 'fetchCourse']);
Route::resource('addbooking', DecentController::class);


Route::get('/Centralised-booking', [CentralisedController::class, 'index']);
Route::get('add_booking_centralise_exam', [CentralisedController::class, 'dropmenuprogram']);
Route::resource('addbooking_centralise_exam', CentralisedController::class);


