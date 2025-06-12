<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits:11|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
        return $this->formatResponse($validator->errors(),"حدث خطأ في التسجيل", false, 404);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        return $this->formatResponse(compact('user','token'), 'تم التسجيل بنجاح', 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
        return $this->formatResponse(null, 'خطأ في الرقم او الباسورد',false ,401);

            }

            // Get the authenticated user.
            $user = 
            Auth::user();
       // $user->image = url($user->image);
$user->image = !empty($user->image) ? url($user->image) : null;

            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

        return $this->formatResponse(['user'=>$user,'token' => $token,], 'Login success',true ,200);

        } catch (JWTException $e) {
        return $this->formatResponse(null, 'Could not create token',false ,500);

        }
    }

    public function getUser()
    {
        $user = Auth::user();
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
        return $this->formatResponse(null, 'User not found',false ,404);

            }
        } catch (JWTException $e) {
        return $this->formatResponse(null, 'Invalid token',false ,400);
        }
    $user->image = !empty($user->image) ? url($user->image) : null;

        return $this->formatResponse($user, 'بيانات المستخدم');

    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return $this->formatResponse(null, 'تم تسجيل الخروج بنجاح');

    }


    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'sometimes|numeric|digits:11|unique:users,phone,' . Auth::id(),
            'image' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return $this->formatResponse($validator->errors(), null, false, 400);
        }
    
        $user = Auth::user();
    
        $user->name = $request->get('name', $user->name);
        $user->email = $request->get('email', $user->email);
        $user->phone = $request->get('phone', $user->phone);
    
        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
    
            $user->image = $request->file('image')->store('user_images', 'public');
        }
    
        $user->save(); 
        $user->image = !empty($user->image) ? url($user->image) : null;

        return $this->formatResponse($user, 'تم التحديث بنجاح');
    }
    
    
public function changePassword(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'هذا المستخدم غير مسموح بالدخول يجب التسجيل اولاً','fail'], 401);
    }

    $validator = Validator::make($request->all(), [
        'current_password' => 'required|string|min:6',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return $this->formatResponse($validator->errors(), null,false,400);

    }

    if (!Hash::check($request->current_password, $user->password)) {
        return $this->formatResponse(null, 'الباسورد الحالي غير صحيح',false,400);

    }

    if ($request->current_password === $request->new_password) {
        return $this->formatResponse(null, 'لا يمكن تطابق الباسورد الجديد مع الباسورد الحالي',false,400);

    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return $this->formatResponse(null, 'تم تغيير الباسورد بنجاح');

}

public function allUsers(){
    $users = User::all();
    return $this->formatResponse($users, 'All users retrieved successfully');

}
public function delete_account(){
    $user = Auth::user();
    if($user){
        
    Auth::logout();
    
    // Delete the user after logging out
    $user->delete();

    return $this->formatResponse(null, 'تم الحذف بنجاح');
    }
    return redirect()->route('login-view');
    // Logout the user first
}

}