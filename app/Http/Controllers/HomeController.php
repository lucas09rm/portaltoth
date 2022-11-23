<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Cidadao;
use App\Models\Informacao;
use App\Models\PerfilProfissional;
use App\Models\Empresa;
use App\Models\Postagem;
use App\Models\Vaga;


class HomeController extends Controller
{
    public function teste(){

        $denuncias = DB::table('denuncias')->where('postagem_id', 4)->get();
        
        dd($denuncias);
    }

    public function index(){
        $posts = DB::table('postagems')
            ->join('users', 'users.id', '=', 'postagems.user_id')
            ->join('tags', 'tags.id', '=', 'postagems.tag_id')
            ->select('postagems.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
            ->orderBy('postagems.created_at', 'asc')
            ->get();

        return view('home', compact('posts'));
    }

    public function infos(){
        $infos = DB::table('informacaos')
            ->join('users', 'users.id', '=', 'informacaos.user_id')
            ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
            ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
            ->orderBy('informacaos.created_at', 'asc')
            ->get();

        return view('informacoes', compact('infos'));
    }

    public function vagas(){
        $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->orderBy('vagas.created_at', 'asc')
                ->get();

        return view('vagas', compact('vagas'));
    }

    public function perfil()
    {
        if(Auth::user()->funcao == "emp"){
            $empresa = Empresa::find(Auth::user()->id);
            $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where('user_id', Auth::user()->id)
                ->orderBy('vagas.created_at', 'asc')
                ->get();

            return view('perfilEmpresa', compact('empresa', 'vagas'));
        }
        if(Auth::user()->funcao == "cid"){
            $cidadao = Cidadao::find(Auth::user()->id);
            $perfil = DB::table('perfil_profissionals')->where('user_id', Auth::user()->id)->first();;
            
            $posts = DB::table('postagems')
                ->join('users', 'users.id', '=', 'postagems.user_id')
                ->join('tags', 'tags.id', '=', 'postagems.tag_id')
                ->select('postagems.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where('user_id', Auth::user()->id)
                ->orderBy('postagems.created_at', 'asc')
                ->get();

            return view('perfilCidadao', compact('cidadao', 'perfil', 'posts'));
        }
    }

    //Editar Perfil
    public function edit()
    {
        if(Auth::user()->funcao == "emp"){
            $empresa = Empresa::find(Auth::user()->id);
            
            return view('alterarEmpresa', compact('empresa'));
        }
        if(Auth::user()->funcao == "cid"){
            $cidadao = Cidadao::find(Auth::user()->id);
            $perfil = DB::table('perfil_profissionals')->where('user_id', Auth::user()->id)->first();

            return view('alterarCidadao', compact('cidadao', 'perfil'));
        }
    }

    public function updateEmpresa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],           
            'telefone' => ['required', 'min:8'],
            'cep' => ['required', 'min:8'],            
            'resumo' => ['required'],
            'chegou-regiao' => ['required'],
            'data-inauguracao' => ['required'],

        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $user = User::find(Auth::user()->id);
            $empresa = Empresa::find(Auth::user()->id);
            
            if(isset($user) && isset($empresa)) {
                
                $user->name = $request->input('name');
                $user->telefone = $request->input('telefone');
                $user->cep = $request->input('cep');
                               
                $empresa->resumo = $request->input('resumo');
                $empresa->data_inauguracao = $request->input('data-inauguracao');
                $empresa->data_chegada = $request->input('chegou-regiao');

                DB::beginTransaction();
                $user->save();
                $empresa->save();
                DB::commit();
            }
            else{             
                return redirect("/perfil")->with('falha', "Perfil não encontrado")->withInput();
            }

            return redirect("/perfil")->with('mensagem', "Perfil alterado com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {

            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao alterar o perfil.")->withInput();
        }
    }

    public function updateCidadao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'telefone' => ['required', 'min:8'],
            'cep' => ['required', 'min:8'],

            'sexo' => ['required'],
            'data-nasc' => ['required'],
            'morador-desde' => ['required'],
            'estado-civil' => ['required'],

            'area' => ['required'],
            'escolaridade' => ['required'],
            'profissao' => ['required'],
            'resumo-cid' => ['required'],
            'status' => ['required'],
        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            
            $user = User::find(Auth::user()->id);
            $cidadao = Cidadao::find(Auth::user()->id);
            $perfil = DB::table('perfil_profissionals')->where('user_id', Auth::user()->id)->first();

            if(isset($user) && isset($cidadao) && isset($perfil)) {
               
                $user->name = $request->input('name');
                $user->telefone = $request->input('telefone');
                $user->cep = $request->input('cep');
                
                $cidadao->sexo = $request->input('sexo');
                $cidadao->data_nascimento = $request->input('data-nasc');
                $cidadao->data_moradia = $request->input('morador-desde');
                $cidadao->estado_civil = $request->input('estado-civil');

                $perfil->area = $request->input('area');
                $perfil->escolaridade = $request->input('escolaridade');
                $perfil->profissao = $request->input('profissao');
                $perfil->texto = $request->input('resumo-cid');
                $perfil->status = $request->input('status');
                $perfil->data_chegada = $request->input('chegou-regiao');

                DB::beginTransaction();

                $user->save();
                $cidadao->save();
                $perfil->save();
                
                DB::commit();
            }
            else{
                return redirect("/perfil")->with('falha', "Perfil não encontrado")->withInput();
            }

            return redirect("/perfil")->with('mensagem', "Perfil alterado com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {

            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao alterar o perfil.")->withInput();
        }

    }

    public function editSenha(){
        return view('alterarSenha');
    }

    public function updateSenha(Request $request){

        $validator = Validator::make($request->all(), [
            'senha-atual' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(Hash::check($request->input('senha-atual'), Auth::user()->password)){
            try{
                $user = User::find(Auth::user()->id);

                if(isset($user)){
                    DB::beginTransaction();

                    $user->password = Hash::make($request->input('password'));
                    $user->save();
                    
                    DB::commit();
                }                
                else{
                    return redirect("/perfil")->with('falha', "Usuário não encontrado")->withInput();
                }

                return redirect("/perfil")->with('mensagem', "Senha alterada com sucesso")->withInput();
    
            } catch(\Illuminate\Database\QueryException $e) {
                DB::rollBack();
                return redirect()->back()->with("falha", "Erro ao alterar a senha.")->withInput();
            }            
        }
        else{
            return redirect()->back()->with("falha", "Senha atual não é válida")->withInput();
        }
        
    }
    
}

