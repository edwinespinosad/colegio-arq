<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

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

        $user = Teacher::where('email', $email)->get();

        if (\Auth::guard('teacher')->attempt($loginData, false)) {
            return response()->json([
                "success" => true,
                "message" => "Ok",
                "user" => $user
            ]);
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
        \Auth::guard('teacher')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('teacher.login');
    }
}
