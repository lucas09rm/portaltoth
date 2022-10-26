<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function __construct()
    {

    }

    public function showLoginForm(){

        if((Auth::check()) && (Auth::user()->ativo)){
            if(Auth::user()->funcao == "adm"){
                return redirect()->route('admin.painel');
            } else {
                return redirect()->route('home');
            }
        }
        return view('auth.login');
    }

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],           
            'password' => ['required', 'string'],

        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials, $request->remember)){
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
        return redirect()->back()->with("falha", "Email ou senha inválidos.")->withInput();
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('home');
    }


}
