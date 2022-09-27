<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data.funcao == "emp"){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'funcao' => ['required'],
                'telefone' => ['required', 'min:8'],
                'cep' => ['required', 'min:8'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'resumo' => ['required'],
                'chegou-regiao' => ['required'],
                'data-inauguracao' => ['required'],
            ]);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'funcao' => ['required'],
            'telefone' => ['required', 'min:8'],
            'cep' => ['required', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sexo' => ['required'],
            'data-nasc' => ['required'],
            'morador-desde' => ['required'],
            'estado-civil' => ['required'],
            'profissao' => ['required'],
            'resumo-cid' => ['required'],
            'status' => ['required'],
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'funcao' => $data['funcao'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'telefone' => $data['telefone'],
            'cep' => $data['cep'],
            'ativo' => true,
        ]);



    }
}
