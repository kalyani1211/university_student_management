<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // Updated to use StudentController@index

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::get('/',[StudentController::class,'add_student']);
Route::get('/edit_student',[StudentController::class,'edit_student']);
Route::get('/show_student',[StudentController::class,'show_student']);

Route::post('/add_edit',[StudentController::class,'add_student_data']);
Route::get('/show-details',[StudentController::class,'show_details']);
Route::get('/fetch',[StudentController::class,'fetch_details']);
Route::get('/delete',[StudentController::class,'delete']);
Route::get("/fetchteacher",[StudentController::class,'fetch_teachers']);
//Auth::routes();
});
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
