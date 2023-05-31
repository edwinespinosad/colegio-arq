<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class LoginController extends Controller
{
    public function auth(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $loginData = [
            'email' => $email,
            'password' => $password,
        ];

        $user = Student::where('email', $email)
            ->get();

        if (\Auth::guard('student')->attempt($loginData, false)) {
            if (!$user[0]->active) {
                return response()->json([
                    "success" => false,
                    "message" => "Error",
                    "user" => $user,
                    "active" => false,
                ]);
            } else {
                return response()->json([
                    "success" => true,
                    "message" => "Ok",
                    "user" => $user
                ]);
            }
        } else {
            return response()->json([
                "success" => false,
                "message" => "Bad",
                'request' => $request->all(),
                'user' => $user
            ]);
        }
    }

    public function logout(Request $request)
    {
        \Auth::guard('student')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('student.login');
    }
}
