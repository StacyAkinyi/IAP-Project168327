<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthManager extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    public function login(){
        return view('login');
    }
    public function signup(){
        return view('signup');
    }
}
