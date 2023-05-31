<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\CourseHasActivity;
use App\Models\Exam;
use App\Models\StudentActivityDelivery;
use App\Models\StudentHasCourse;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\CourseHasUnit;
use App\Models\UnitHasMaterial;
use App\Models\Material;
use Carbon\Carbon;

class UnitController extends Controller
{
    public function createPostMaterial(Request $request): \Illuminate\Http\JsonResponse
    {
        $material = new Material();
        $material->title = $request->get('title');

        $file = [];
        $tempFile = $request->file('file');
        if (isset($tempFile)) {
            if ($material->link != null) {
                UploadFiles::deleteFile($material->link);
            }
            array_push($file, $tempFile);
            $url = UploadFiles::storeFile($file[0], $material->id, 'colegio_material',);
            $material->link = $url;
        }

        if (!$material->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el aviso'
            ]);
        }

//        Primero buscar en la tabla course_has_unit y obtener el id para linkear
        $courseUnit = CourseHasUnit::where('fk_id_course', $request->get('fk_id_course'))
            ->where('fk_id_unit', $request->get('fk_id_unit'))
            ->first();

        $unitMaterial = new UnitHasMaterial();
        $unitMaterial->fk_id_material = $material->id;
        $unitMaterial->fk_id_course_has_unit = $courseUnit->id;

        if (!$unitMaterial->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo linkear el aviso'
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $request->all(),
            'message' => 'Guardado correctamente'
        ]);
    }

    public function createPostActivity(Request $request): \Illuminate\Http\JsonResponse
    {
        $activity = new Activity();
        $activity->title = $request->get('title');
        $activity->description = $request->get('description');
        $activity->limit_date = Carbon::createFromFormat('Y-m-d H:i', ($request->get('limit_date')));

        $file = [];
        $tempFile = $request->file('file');
        if (isset($tempFile)) {
            if ($activity->help_material != null) {
                UploadFiles::deleteFile($activity->help_material);
            }
            $file[] = $tempFile;
            $url = UploadFiles::storeFile($file[0], $activity->id, 'colegio_material_apoyo',);
            $activity->help_material = $url;
        }

        if (!$activity->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear la actividad'
            ]);
        }

        $courseActivity = new CourseHasActivity();
        $courseActivity->fk_id_course = $request->get('fk_id_course');
        $courseActivity->fk_id_activity = $activity->id;

        if (!$courseActivity->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo linkear la actividad'
            ]);
        }

        $students = StudentHasCourse::where('fk_id_course', $request->get('fk_id_course'))
            ->get();

        foreach ($students as $student) {
            $activityDelivery = new StudentActivityDelivery();
            $activityDelivery->fk_id_student = $student->fk_id_student;
            $activityDelivery->fk_id_course_has_activity = $courseActivity->id;
            if (!$activityDelivery->save()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo linkear la actividad'
                ]);
            }
        }


        return response()->json([
            'success' => true,
            'data' => $request->all(),
            'message' => 'Guardado correctamente'
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


}
