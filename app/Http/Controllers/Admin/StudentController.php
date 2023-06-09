<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function indexContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $filterName = $request->get('filter-name', null);
        $filterPhone = $request->get('filter-phone', null);
        $filterEmail = $request->get('filter-email', null);

        $query = Student::with('courses');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        $count = $query->count();
        $students = $query
            ->get();

        return response()->json([
            'count' => $count,
            'data' => $students,
        ]);
    }

    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new Student();
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
                'message' => 'No se pudo guardar el curso'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }

    public function updatePost(Request $request, $userId): \Illuminate\Http\JsonResponse
    {
        $user = Student::find($userId);

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

    public function status($userId)
    {

        $user = Student::find($userId);

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


}
