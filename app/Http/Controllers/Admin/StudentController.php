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
}
