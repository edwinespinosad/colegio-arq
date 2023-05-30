<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Teacher\NoticeController;
use App\Http\Controllers\Teacher\UnitController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\MaterialController;
/*************** AUTH TEACHER *********************/

Route::get('/teacher',
    [TeacherController::class, 'getTeacherAuth'])
    ->name('teacher.get.auth');

Route::get('/courses',
    [TeacherController::class, 'getTeacherCourses'])
    ->name('teacher.get.courses');

Route::get('/get-course/{courseId}',
    [TeacherController::class, 'getTeacherCourse'])
    ->name('teacher.get.course');

/*************** NOTICE *********************/
Route::post('/notice/create',
    [NoticeController::class, 'createPost'])
    ->name('teacher.notice.create');

/*************** UNIT *********************/
Route::get('/get-course-material/{courseId}/{unitId}',
    [UnitController::class, 'getCourseMaterial'])
    ->name('teacher.unit.course.material');

Route::get('/get-course-exam/{courseId}/{unitId}',
    [UnitController::class, 'getCourseExam'])
    ->name('teacher.unit.course.exam');

Route::post('/unit/create',
    [UnitController::class, 'createPostMaterial'])
    ->name('teacher.unit.material.create');

/*************** COURSE *********************/
Route::post('/course/create/activity',
    [UnitController::class, 'createPostActivity'])
    ->name('teacher.course.create.activity');

Route::post('/exam/create',
    [ExamController::class, 'createPost'])
    ->name('teacher.exam.create');

Route::get('/get-course-activities/{courseId}/{studentId}',
    [StudentController::class, 'getCourseActivities'])
    ->name('teacher.student.course.activities');

Route::post('/activity/qualification/{studentId}/{courseId}',
    [StudentController::class, 'updateQualificationActivity'])
    ->name('teacher.activity.student.update');

Route::get('/get-student/{studentId}',
    [StudentController::class, 'getStudent'])
    ->name('teacher.get.student');

Route::get('/get-average-activities/{courseId}/{studentId}',
    [StudentController::class, 'getAverageActivities'])
    ->name('teacher.average.student.activities');

Route::delete('/delete-unit-material/{materialId}',
    [MaterialController::class, 'deleteUnitMaterial'])
    ->name('teacher.delete.material');

/***************** VUE ROUTER **********************/
Route::get('/{any}', function () {
    return view('/teacher/main');
})->where('any', '.*');
