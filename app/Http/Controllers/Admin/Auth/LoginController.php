<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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

        $user = User::where('email', $email)->get();

        if (\Auth::guard('admin')->attempt($loginData, false)) {
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
        \Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('admin.login');
    }
}
