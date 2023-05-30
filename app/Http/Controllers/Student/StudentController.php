<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\CourseHasActivity;
use App\Models\CourseHasNotice;
use App\Models\CourseHasUnit;
use App\Models\Exam;
use App\Models\Material;
use App\Models\StudentActivityDelivery;
use App\Models\UnitHasMaterial;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function getStudentAuth(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'data' => $user,
        ]);
    }

    public function getStudentCourses(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $student = Student::find($user->id);
        $courses = $student->courses()->get();
        return response()->json([
            'data' => $courses,
        ]);
    }

    public function getStudentCourse($courseId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $student = Student::find($user->id);
        $courses = $student->courses()->find($courseId);
        return response()->json([
            'data' => $courses,
        ]);
    }

    public function getCourseMaterial($courseId, $unitId): \Illuminate\Http\JsonResponse
    {

        $courseUnit = CourseHasUnit::where('fk_id_course', $courseId)
            ->where('fk_id_unit', $unitId)
            ->first();

        $unitMaterial = UnitHasMaterial::where('fk_id_course_has_unit', $courseUnit->id)
            ->with('material')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $unitMaterial
        ]);
    }

    public function getCourseExam($courseId, $unitId): \Illuminate\Http\JsonResponse
    {

        $courseUnit = CourseHasUnit::where('fk_id_course', $courseId)
            ->where('fk_id_unit', $unitId)
            ->first();

        $exam = Exam::where('id', $courseUnit->fk_id_exam)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $exam
        ]);
    }

    public function getCourseActivities($courseId, $studentId): \Illuminate\Http\JsonResponse
    {

        $courseUnit = CourseHasActivity::where('fk_id_course', $courseId)
            ->with('activity')
            ->get();

        $courseUnitIds = $courseUnit->pluck('id')->toArray();

        $studentActivityDeliveries = StudentActivityDelivery::where('fk_id_student', $studentId)
            ->whereIn('fk_id_course_has_activity', $courseUnitIds)
            ->join('course_has_activity', 'student_activity_delivery.fk_id_course_has_activity', '=', 'course_has_activity.id')
            ->join('activity', 'course_has_activity.fk_id_activity', '=', 'activity.id')
            ->orderBy('activity.limit_date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $studentActivityDeliveries
        ]);
    }

    public function getCourseNotices($courseId): \Illuminate\Http\JsonResponse
    {

        $notices = CourseHasNotice::join('notice', 'course_has_notices.fk_id_notice', '=', 'notice.id')
            ->where('course_has_notices.fk_id_course', $courseId)
            ->orderBy('notice.updated_at', 'desc')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $notices
        ]);
    }

    public function getCourseActivity($courseActivityId, $studentId): \Illuminate\Http\JsonResponse
    {
        $studentActivityDeliveries = StudentActivityDelivery::where('fk_id_student', $studentId)
            ->where('fk_id_course_has_activity', $courseActivityId)
            ->join('course_has_activity', 'student_activity_delivery.fk_id_course_has_activity', '=', 'course_has_activity.id')
            ->join('activity', 'course_has_activity.fk_id_activity', '=', 'activity.id')
            ->orderBy('activity.limit_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $studentActivityDeliveries
        ]);
    }

    public function uploadCourseActivity(Request $request): \Illuminate\Http\JsonResponse
    {
        $activity = StudentActivityDelivery::where('fk_id_student', $request->get('fk_id_student'))
            ->where('fk_id_course_has_activity', $request->get('fk_id_course_has_activity'))
            ->first();

        $limitDate = $activity->course_has_activity->activity->limit_date;

        if ($limitDate && now() > $limitDate) {
            return response()->json([
                'limit_date'=>true,
                'success' => false,
                'message' => 'La fecha límite ha sido superada. No se puede entregar la actividad.'
            ]);
        }

        $file = [];
        $tempFile = $request->file('file');
        if (isset($tempFile)) {
            if ($activity->link != null) {
                UploadFiles::deleteFile($activity->link);
            }
            $file[] = $tempFile;
            $url = UploadFiles::storeFile($file[0], $activity->id, 'colegio_entregas',);
            $activity->link = $url;
        }

        $activity->delivered = 1;

        if (!$activity->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo subir la actividad'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $request->all(),
            'message' => 'Guardado correctamente'
        ]);
    }

    public function getAverageActivities($courseId, $studentId): \Illuminate\Http\JsonResponse
    {
        $courseUnit = CourseHasActivity::where('fk_id_course', $courseId)
            ->with('activity')
            ->get();

        $courseUnitIds = $courseUnit->pluck('id')->toArray();

        $averageQualification = StudentActivityDelivery::where('fk_id_student', $studentId)
            ->whereIn('fk_id_course_has_activity', $courseUnitIds)
            ->join('course_has_activity', 'student_activity_delivery.fk_id_course_has_activity', '=', 'course_has_activity.id')
            ->join('activity', 'course_has_activity.fk_id_activity', '=', 'activity.id')
            ->selectRaw('ROUND(AVG(COALESCE(student_activity_delivery.qualification, 0)), 2) as average')
            ->first();

        $average = $averageQualification->average;

        return response()->json([
            'success' => true,
            'data' => $average
        ]);
    }

}
