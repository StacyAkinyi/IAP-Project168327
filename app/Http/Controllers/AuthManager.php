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
        
        $request->validate(['email'=>'required|email|exists:users,email','password'=>'required']);

        if(auth()->attempt($request->only('email', 'password'),true)){
            
            $google2fa = new Google2FA();
    
            $user = auth()->user();
            if($user->google2fa_secret){
    
                $request->session()->put('two_factor:user:id', $user->id);
                $request->session()->put('two_factor:user:credentials', $request->only('email', 'password'));
                $request->session()->put('two_factor:auth:attempt', true);
                $otp_secret = $user->Two_factor_code;
                $google2fa->getCurrentOtp($otp_secret);
    
                auth()->logout();
                return redirect()->route('two_factor');
            }else{
                return redirect()->route('login');
            }
        }
        return redirect()->back()->withErrors(['email' => 'Invalid Credentials']);
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
    public function two_factor(){
        return view('two_factor');
    }
    public function two_factorPost(Request $request){
        $request->validate([
            'two_factor_code' => 'required',
        ]);
        $request->validate([
            'one_time_password' => 'required|string',
        ]);
    
        $user_id = $request->session()->get('2fa:user:id');
        $credentials = $request->session()->get('2fa:user:credentials');
        $attempt = $request->session()->get('2fa:auth:attempt', false);
    
        if (!$user_id || !$attempt) {
            return redirect()->route('login');
        }
    
        $user = User::find($user_id);
    
        if (!$user) {
            return redirect()->route('login');
        }
    
        $google2fa = new Google2FA();
        $otp_secret = $user->google2fa_secret;
    
        if (!$google2fa->verifyKey($otp_secret, $request->one_time_password)) {
            throw ValidationException::withMessages([
                'one_time_password' => [__('The one time password is invalid.')],
            ]);
        }
    
        $guard = config('auth.web.guard');        
        if ($attempt) {
            $guard = config('auth.web.attempt_guard', $guard);
        }
        
        if (auth()->attempt($credentials, true)) {
            $request->session()->remove('two_factor:user:id');
            $request->session()->remove('two_factor:user:credentials');
            $request->session()->remove('two_factor:auth:attempt');
        
            return redirect()->route('dashboard');
        }
        
        return redirect()->route('login')->withErrors([
            'password' => __('The provided credentials are incorrect.'),
        ]);
    }
    }

