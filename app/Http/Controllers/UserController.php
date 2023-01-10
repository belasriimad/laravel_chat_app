<?php

namespace App\Http\Controllers;

use App\Events\LoginoutEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function registerForm() {
        if(auth()->check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function loginForm() {
        if(auth()->check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function store(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        auth()->login($user);
        return redirect('/');
    }

    public function auth(Request $request){
        if(auth()->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = User::whereEmail($request->email)->first();
            broadcast(new LoginoutEvent("$user->name has logged in", "alert-success"));
            return redirect('/');
        }else {
            return redirect()->route('login')->with([
                'error' => 'These credentials do not match any of our records'
            ]);
        }
    }

    public function logout() {
        $username = auth()->user()->name;
        auth()->logout();
        broadcast(new LoginoutEvent("$username has logged out", "alert-danger"));
        return redirect('/');
    }
}
