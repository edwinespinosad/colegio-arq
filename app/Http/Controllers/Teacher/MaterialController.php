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

class MaterialController extends Controller
{

    public function deleteUnitMaterial($materialId): \Illuminate\Http\JsonResponse
    {
        try {
            UnitHasMaterial::where('fk_id_material', $materialId)->delete();

            Material::find($materialId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'El material ha sido eliminado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al eliminar el material.'
            ]);
        }
    }

}
