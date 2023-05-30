<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function getTeacherAuth(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'data' => $user,
        ]);
    }

    public function getTeacherCourses(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $teacher = Teacher::find($user->id);
        $courses = $teacher->courses()->with('students')->get();
        return response()->json([
            'data' => $courses,
        ]);
    }

    public function getTeacherCourse($courseId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $teacher = Teacher::find($user->id);
        $courses = $teacher->courses()->with('students')->find($courseId);
        return response()->json([
            'data' => $courses,
        ]);
    }
}
