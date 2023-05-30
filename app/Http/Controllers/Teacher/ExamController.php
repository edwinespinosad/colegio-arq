<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\CourseHasUnit;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
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

        $courseUnit = CourseHasUnit::where('fk_id_course', $request->get('fk_id_course'))
            ->where('fk_id_unit', $request->get('fk_id_unit'))
            ->first();

        $courseUnit->fk_id_exam = $exam->id;

        if (!$courseUnit->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo linkear'
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }
}
