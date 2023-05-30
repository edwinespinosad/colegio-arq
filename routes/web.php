<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController as LoginAdminController;
use App\Http\Controllers\Teacher\Auth\LoginController as LoginTeacherController;
use App\Http\Controllers\Student\Auth\LoginController as LoginStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('lp.main');
})
->name('lp.main');

// ADMIN
Route::get('/admin/login', function () {
    return view('/admin/auth/login');
})->name('admin.login');

Route::post('admin/auth',
    [LoginAdminController::class, 'auth'])
    ->name('admin.auth');

Route::get('/admin/logout',
    [LoginAdminController::class, 'logout'])
    ->name('admin.logout');

// TEACHER
Route::get('/teacher/login', function () {
    return view('/teacher/auth/login');
})->name('teacher.login');

Route::post('teacher/auth',
    [LoginTeacherController::class, 'auth'])
    ->name('teacher.auth');

Route::get('/teacher/logout',
    [LoginTeacherController::class, 'logout'])
    ->name('teacher.logout');

// CLIENT
Route::get('/student/login', function () {
    return view('/client/auth/login');
})->name('student.login');

Route::post('student/auth',
    [LoginStudentController::class, 'auth'])
    ->name('student.auth');

Route::get('/student/logout',
    [LoginStudentController::class, 'logout'])
    ->name('student.logout');
