<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        sleep(1);
        //validation
        $fields = $request->validate([
            'avatar' => ['nullable', 'file', 'max:3000'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }
        //register
        $user = User::create($fields);
        //login
        Auth::login($user);
        //redirect
        return redirect()->route('dashboard')->with('greet', 'Account created successfully!');
    }
    public function login(Request $request)
    {
        sleep(1);
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Incorrect email or password.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        sleep(1);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()->route('login');
    }
}
