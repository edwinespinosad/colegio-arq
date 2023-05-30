<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\StudentController;
//use App\Http\Controllers\Admin\NoticeController;
/*************** USER *********************/

Route::get('/user/index/content',
    [UserController::class, 'indexContent'])
    ->name('admin.user.index.content');

Route::post('/user/create',
    [UserController::class, 'createPost'])
    ->name('admin.user.create');

Route::post('/user/update/{userId}',
    [UserController::class, 'updatePost'])
    ->name('admin.user.update');
/*************** EXAM *********************/
Route::get('/exam/index/content',
    [ExamController::class, 'indexContent'])
    ->name('admin.exam.index.content');

Route::post('/exam/create',
    [ExamController::class, 'createPost'])
    ->name('admin.exam.create');

Route::post('/exam/update/{examId}',
    [ExamController::class, 'updatePost'])
    ->name('admin.exam.update');

/*************** COURSE *********************/
Route::get('/course/index/content',
    [CourseController::class, 'indexContent'])
    ->name('admin.course.index.content');

Route::post('/course/create',
    [CourseController::class, 'createPost'])
    ->name('admin.course.create');

Route::post('/course/update/{courseId}',
    [CourseController::class, 'updatePost'])
    ->name('admin.course.update');

Route::get('/course/status/{courseId}',
    [CourseController::class, 'status'])
    ->name('admin.course.status');


/*************** STUDENT *********************/
Route::get('/student/index/content',
    [StudentController::class, 'indexContent'])
    ->name('admin.student.index.content');

/***************** VUE ROUTER **********************/
Route::get('/{any}', function () {
    return view('/admin/main');
})->where('any', '.*');
