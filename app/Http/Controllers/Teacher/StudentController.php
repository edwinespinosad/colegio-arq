<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\CourseHasActivity;
use App\Models\StudentActivityDelivery;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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

    public function updateQualificationActivity($studentId, $courseId, Request $request): \Illuminate\Http\JsonResponse
    {
        $activity = StudentActivityDelivery::where('fk_id_student', $studentId)
            ->where('fk_id_course_has_activity', $courseId)
            ->first();

        $activity->qualification = $request->get('qualification');

        if (!$activity->save()) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir calificacion'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $activity
        ]);
    }

    public function getStudent($studentId): \Illuminate\Http\JsonResponse
    {
        $student = Student::find($studentId);

        return response()->json([
            'success' => true,
            'data' => $student
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
