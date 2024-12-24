<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;
    public function username(){
        return 'phone';
    }
    public function login(){
        return Inertia::render("Login",[]);
    }
    public function register(){
        return Inertia::render("Register",[]);

    }
    public function store(Request $request){
        $this->validate($request, [
            'phone'     => 'required',
            'password'  => 'required'
        ]);

        //get email and password from request
        $request->request->add(['phone' => '62'.$request->phone]);

        $credentials = $request->only('phone', 'password');
        
        //attempt to login
        if (Auth::attempt($credentials)) {

            //regenerate session
            $request->session()->regenerate();

            //redirect route dashboard
            return redirect('/');
        }

        //if login fails
        return back()->withErrors([
            'phone' => 'Maaf No hp / password salah lakukan lupa pasword juka lupa',
        ]);
    }
    public function registerstore(Request $request){
       
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'phone'     => 'required|unique:users',
            'alamat'     => 'required',
            'password'  => 'required|confirmed'
        ]);

        /**
         * create user
         */
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => "62".$request->phone,
            'alamat'     => $request->alamat,
            'foto'     => URL::to("profile/default.jpg"),
            'saldo'     => 0,
            'password'  => bcrypt($request->password)
        ]);

        //redirect
        return redirect('/login')->with('status', 'Register Berhasil!');
    }
}
