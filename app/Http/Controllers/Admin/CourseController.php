<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UploadFiles;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseHasUnit;

class CourseController extends Controller
{
    public function indexContent(Request $request): \Illuminate\Http\JsonResponse
    {
        $filterName = $request->get('filter-name', null);
        $filterPhone = $request->get('filter-phone', null);
        $filterEmail = $request->get('filter-email', null);

        $query = Course::orderBy('id', 'asc');

        if ($filterName !== null) {
            $query->where('name', "like", "%" . $filterName . "%");
        }

        $count = $query->count();
        $courses = $query
            ->get();

        return response()->json([
            'count' => $count,
            'data' => $courses,
        ]);
    }

    public function createPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $course = new Course();
        $course->name = $request->get('name');
        $course->duration = $request->get('duration');
        $course->description = $request->get('description');
        $course->requirements = $request->get('requirements');
        $course->price = $request->get('price');
        $course->type = $request->get('type');
        $course->date_ini = $request->get('date_ini');
        $course->date_fin = $request->get('date_fin');

        $image = [];
        $tempFile = $request->file('image');
        if (isset($tempFile)) {
            if ($course->image != null) {
                UploadFiles::deleteFile($course->image);
            }
            array_push($image, $tempFile);
            $url = UploadFiles::storeFile($image[0], $course->id, 'colegio_course_img',);
            $course->image = $url;
        }

        if (!$course->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo guardar el curso'
            ]);
        }

        for ($i = 1; $i < 4; $i++) {
            $courseUnit = new CourseHasUnit();
            $courseUnit->fk_id_course = $course->id;
            $courseUnit->fk_id_unit = $i;
            if (!$courseUnit->save()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo linkear la unidad al curso'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ]);
    }

    public function updatePost(Request $request, $courseId): \Illuminate\Http\JsonResponse
    {
        $course = Course::find($courseId);

        $course->name = $request->get('name');
        $course->duration = $request->get('duration');
        $course->description = $request->get('description');
        $course->requirements = $request->get('requirements');
        $course->price = $request->get('price');
        $course->type = $request->get('type');
        $course->date_ini = $request->get('date_ini');
        $course->date_fin = $request->get('date_fin');

        if ($course->image !== $request->get('image')) {
            $image = [];
            $tempFile = $request->file('image');
            UploadFiles::deleteFile($course->image);
            array_push($image, $tempFile);
            $url = UploadFiles::storeFile($image[0], $course->id, 'colegio_course_img',);
            $course->image = $url;
        }

        if (!$course->save()) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el curso'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function status($userId)
    {

        $course = Course::find($userId);

        $course->active = !$course->active;

        if ($course->save()) {

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
