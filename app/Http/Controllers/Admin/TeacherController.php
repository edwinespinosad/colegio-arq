<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TeacherHasCourse;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function indexContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $filterName = $request->get('filter-name', null);
        $filterPhone = $request->get('filter-phone', null);
        $filterEmail = $request->get('filter-email', null);

        $query = Teacher::with('courses');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        $count = $query->count();
        $teachers = $query
            ->get();

        return response()->json([
            'count' => $count,
            'data' => $teachers,
        ]);
    }

    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new Teacher();
        $user->name = $request->get('name');
        $user->middle_name = $request->get('middle_name');
        $user->last_name = $request->get('last_name');
        $user->age = $request->get('age');
        $user->phone = $request->get('phone');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        if (!$user->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo guardar el profesor'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }

    public function updatePost(Request $request, $userId): \Illuminate\Http\JsonResponse
    {
        $user = Teacher::find($userId);

        $user->name = $request->get('name');
        $user->middle_name = $request->get('middle_name');
        $user->last_name = $request->get('last_name');

        if ($request->get('age') != 'null') {
            $user->age = $request->get('age');
        }
        $user->phone = $request->get('phone');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        if (!$user->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el usuario'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function status($userId): \Illuminate\Http\JsonResponse
    {

        $user = Teacher::find($userId);

        $user->active = !$user->active;

        if ($user->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Curso actualizado correctamente'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar curso'
            ]);
        }
    }

    public function getCourses(): \Illuminate\Http\JsonResponse
    {
        $courses = Course::where('active', '1')
            ->get();

        return response()->json([
            'data' => $courses
        ]);
    }

    public function assignCourse(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new TeacherHasCourse();
        $user->fk_id_course = $request->get('fk_id_course');
        $user->fk_id_teacher = $request->get('fk_id_teacher');

        if (!$user->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo asignar'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }
}
