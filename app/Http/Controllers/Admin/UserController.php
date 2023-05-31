<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function indexContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $page = $request->get('page', 0);
        $size = $request->get('size', 10);
        $skip = $page * $size;

        $filterName = $request->get('filter-name', null);
        $filterPhone = $request->get('filter-phone', null);
        $filterEmail = $request->get('filter-email', null);

        $query = User::orderBy('id', 'asc');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        if ($filterPhone !== null) {
            $query->where('phone', "like", "%" . $filterPhone . "%");
        }

        if ($filterEmail !== null) {
            $query->where('email', "like", "%" . $filterEmail . "%");
        }

        $count = $query->count();
        $users = $query
            ->limit($size)
            ->skip($skip)
            ->get();

        return response()->json([
            'page' => $page,
            'size' => $size,
            'count' => $count,
            'data' => $users,
        ]);
    }

    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = new User();
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
        $user = User::find($userId);

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

        $user = User::find($userId);

        $user->active = !$user->active;

        if ($user->save()) {

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente'
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar curso'
            ]);
        }
    }


}
