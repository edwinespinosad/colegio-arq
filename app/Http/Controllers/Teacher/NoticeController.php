<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\CourseHasNotice;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $notice = new Notice();
            $notice->title = $request->get('title');
            $notice->description = $request->get('description');

            if (!$notice->save()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo crear el aviso'
                ]);
            }

            $course_notice = new CourseHasNotice();
            $course_notice->fk_id_course = $request->get('fk_id_course');
            $course_notice->fk_id_notice = $notice->id;

            if (!$course_notice->save()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo linkear el aviso'
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Guardado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al crear el aviso: ' . $e->getMessage()
            ]);
        }
    }
}
