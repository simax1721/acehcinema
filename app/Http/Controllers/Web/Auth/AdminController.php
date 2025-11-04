<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    function get_index() {
        return view('web.admin.login');
    }

    function post_login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email','password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            $token = $admin->createToken('admin_token', ['admin'])->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'admin' => $admin
            ], 200);
        }
        
        // $user = w
        return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
    }

    function logout() {
        Auth::guard('admin')->logout();
        // Auth::guard('web')->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }

    function get_me() {
        return response()->json(['admin' => Auth::guard('admin')->user()]);
    }
}
