<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;

/*************** COURSES *********************/

Route::get('/courses',
    [StudentController::class, 'getStudentCourses'])
    ->name('student.get.courses');

Route::get('/get-course/{courseId}',
    [StudentController::class, 'getStudentCourse'])
    ->name('student.get.course');

/*************** UNIT *********************/
Route::get('/get-course-material/{courseId}/{unitId}',
    [StudentController::class, 'getCourseMaterial'])
    ->name('student.unit.course.material');

Route::get('/get-course-exam/{courseId}/{unitId}',
    [StudentController::class, 'getCourseExam'])
    ->name('student.unit.course.exam');

Route::get('/get-course-activities/{courseId}/{studentId}',
    [StudentController::class, 'getCourseActivities'])
    ->name('student.course.activities');

Route::get('/get-course-activity/{courseActivityId}/{studentId}',
    [StudentController::class, 'getCourseActivity'])
    ->name('student.course.activity');

Route::post('/course-activity',
    [StudentController::class, 'uploadCourseActivity'])
    ->name('student.course.upload.activity');

Route::get('/get-course-notices/{courseId}',
    [StudentController::class, 'getCourseNotices'])
    ->name('student.course.notices');

Route::get('/get-average-activities/{courseId}/{studentId}',
    [StudentController::class, 'getAverageActivities'])
    ->name('student.average.activities');
/***************** VUE ROUTER **********************/
Route::get('/{any}', function () {
    return view('/client/main');
})->where('any', '.*');
