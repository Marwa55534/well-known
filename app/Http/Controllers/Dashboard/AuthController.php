<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            
            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الدخول بنجاح'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'خطأ في تسجيل الدخول'
        ], 401); 
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
    
        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
