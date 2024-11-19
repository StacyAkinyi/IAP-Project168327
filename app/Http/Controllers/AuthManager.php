<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;


class AuthManager extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    public function login(){
        if(Auth::check()){
            return redirect(route('welcome'));
        }
        return view('login');
    }
    public function signup(){
        if(Auth::check()){
            return redirect(route('welcome'));
        }
        return view('signup');
    }
    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }
        return redirect(route('login'))->with('error', 'Invalid credentials');
    }

    public function signupPost(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user){
            return redirect(route('signup'))->with('error', 'User not created');
        }
        return redirect(route('login'))->with('success', 'Registration successful. Login to continue');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('welcome'));
    }
}

