<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],
        [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'password.required' => 'كلمة المرور مطلوبة',
        ]
        );

        

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return redirect()->back()->with(['error' => 'هناك خطأ في البريد الإلكتروني أو كلمة المرور.']);
    }

    
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.min' => 'الاسم يجب أن يكون 3 حروف على الأقل',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'password_confirmation.required' => 'تأكيد كلمة المرور مطلوب',
            'password_confirmation.same' => 'تأكيد كلمة المرور يجب أن يتطابق مع كلمة المرور',
        ]);

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Log the user in
        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {   
        try {
            $socialUser = Socialite::driver('google')->user();
            // dd($socialUser->id);
            $user = User::where('google_id', $socialUser->id)->first();
            if ($user) {
                Auth::login($user);
                return redirect()->route('dashboard');
            }

            $newUser = User::create([
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'google_id' => $socialUser->id,
                'provider_name' => 'google',
                'password' => encrypt('password_dummy'), // كلمة مرور وهمية
            ]);

            Auth::login($newUser);
            return redirect()->route('dashboard');

        } catch (\Throwable $th) {
            // dd($th);
            return redirect('/login')->with('error', 'فشل تسجيل الدخول باستخدام Google.');
        }
    }
}