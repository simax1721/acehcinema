<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function get() {
        return 0;
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

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();

            $token = $user->createToken('user_token', ['user'])->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user
            ], 200);
        }
        
        // $user = w
        return response()->json(['success' => false, 'message' => 'Email atau password salah'], 401);
        
        // return response()->json(['success'=>true, 'token'=>$token, 'user'=>$user]);
    }

    public function google_redirect(Request $request)
    {
        $redirectAfter = $request->query('redirect_after', '/');

        $googleRedirect = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return redirect($googleRedirect . '&state=' . urlencode($redirectAfter));
    }

    public function google_callback(Request $request)
    {
        $redirectAfter = '/';
        if ($request->has('state')) {
            $redirectAfter = urldecode($request->query('state'));
        }

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->to($redirectAfter . '?error=google_login_failed');
        }

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(16)),
            ]
        );

        Auth::guard('web')->login($user);

        // 🔹 Buat Sanctum token juga
        $token = $user->createToken('google_token', ['user'])->plainTextToken;
        return redirect()->to(
            $redirectAfter . '?google_token=' . $token . '&user=' . urlencode(json_encode([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
            ]))
        );
        // return redirect()->to($redirectAfter . '?google_token=' . $token . '&user=' . urlencode(json_encode($user)));
    }

    function post_register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($user);
        $token = $user->createToken('user_token', ['user'])->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'user' => $user
        ], 200);


        return response()->json($user);

        

    }

    function logout() {
        Auth::guard('web')->logout();
        // Auth::guard('web')->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }

    function get_me() {
        return response()->json(['user' => Auth::guard('web')->user()]);
    }
}
