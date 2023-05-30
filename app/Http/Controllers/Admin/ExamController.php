<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;

class ExamController extends Controller
{
    public function indexContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $filterName = $request->get('filter-name', null);
        $filterPhone = $request->get('filter-phone', null);
        $filterEmail = $request->get('filter-email', null);

        $query = Exam::orderBy('id', 'asc');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        $count = $query->count();
        $users = $query
            ->get();

        return response()->json([
            'count' => $count,
            'data' => $users,
        ]);
    }

    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $exam = new Exam();
        $exam->name = $request->get('name');
        $exam->description = $request->get('description');
        $exam->link = $request->get('link');
        $exam->date_ini = $request->get('date_ini');
        $exam->date_fin = $request->get('date_fin');

        if (!$exam->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo guardar el examen'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }

    public function updatePost(Request $request,$examId): \Illuminate\Http\JsonResponse
    {
        $exam = Exam::find($examId);

        $exam->name = $request->get('name');
        $exam->description = $request->get('description');
        $exam->link = $request->get('link');
        $exam->date_ini = $request->get('date_ini');
        $exam->date_fin = $request->get('date_fin');

        if (!$exam->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el examen'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente'
        ]);
    }

}
