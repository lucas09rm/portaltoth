<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {

    }

    public function showLoginForm(){

        return view('auth.login');
    }

    public function login(Request $request){
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            return redirect()->back()->withInput()->withErrors(['Email informado inválido']);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            if(Auth::user()->funcao == "cid"){
                return redirect()->route('home');
            }
            else if(Auth::user()->funcao == "emp"){
                return redirect()->route('home');
            }
            else if(Auth::user()->funcao == "adm"){
                return redirect()->route('admin.painel');
            }
        }

        return redirect()->back()->withInput()->withErrors(['Entrada de valores inválidas!']);
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('admin.painel');
    }


}
