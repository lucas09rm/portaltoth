<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Administrador;
use App\Models\Informacao;
use App\Models\Denuncia;
use App\Models\Postagem;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {
        $infos = DB::table('informacaos')
            ->join('users', 'users.id', '=', 'informacaos.user_id')
            ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
            ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
            ->orderBy('informacaos.created_at', 'asc')
            ->get();

        return view('adm.painel', compact('infos'));
    }

    public function denuncias(){
        
        $denuncias = DB::table('postagems')
        ->join('users', 'users.id', '=', 'postagems.user_id')
        ->join('denuncias', 'denuncias.postagem_id', '=', 'postagems.id')
        ->join('tags', 'tags.id', '=', 'postagems.tag_id')
        ->select('postagems.*', 'denuncias.created_at as data_denuncia', 'users.name as usuario', 
                'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where('denuncias.ativo', 1)
        ->orderBy('denuncias.created_at', 'asc')
        ->get();

        return view('adm.denuncias', compact('denuncias'));
    }


    public function create()
    {
        return view('adm.registerAdm');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefone' => ['required', 'min:8'],
            'cep' => ['required', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'data-moradia' => ['required'],
            'data-nascimento' => ['required'],
        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            DB::beginTransaction();

            $usuario = User::create([
                'funcao' => "adm",
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'username' => $request->input('username'),
                'telefone' => $request->input('telefone'),
                'cep' => $request->input('cep'),
                'ativo' => true,
                'imagem' => "",
            ]);

            $admin = Administrador::create([
                'data_moradia' => $request->input('data-moradia'),
                'data_nascimento' => $request->input('data-nascimento'),
                'id' => $usuario->id,
            ]);

            DB::commit();

            return redirect("/admin")->with('mensagem', "Administrador cadastrado com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with("falha", "Erro no cadastro de administrador.")->withInput();
        }
    }

    
    public function edit()
    {
        $admin = Administrador::find(Auth::user()->id);

        return view('adm.alterarAdm', compact('admin'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],           
            'telefone' => ['required', 'min:8'],
            'cep' => ['required', 'min:8'],  
            'data-moradia' => ['required'],
            'data-nascimento' => ['required'],

        ], ['required' => "Preenchimento obrigatório"]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            DB::beginTransaction();

            $user = User::find(Auth::user()->id);
            $admin = Administrador::find(Auth::user()->id);
            
            if(isset($user) && isset($admin)) {
                $user->name = $request->input('name');
                $user->telefone = $request->input('telefone');
                $user->cep = $request->input('cep');
                               
                $admin->data_nascimento = $request->input('data-nascimento');
                $admin->data_moradia = $request->input('data-moradia');

                $user->save();
                $admin->save();
            }

            DB::commit();

            return redirect("/admin")->with('mensagem', "Perfil alterado com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {

            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao alterar o perfil.")->withInput();
        }
    }

    public function editSenha(){
        return view('adm.alterarSenhaAdm');
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
                DB::beginTransaction();

                $user = User::find(Auth::user()->id);

                if(isset($user)){
                    $user->password = Hash::make($request->input('password'));
                    $user->save();
                    DB::commit();
                }                
                else{
                    DB::commit();
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

    public function analiseDenuncia(Request $request)
    {
        if(isset($_POST["excluirPost"])){
            try{            
                $post = Postagem::find($request->input('postId'));
    
                if (isset($post)) {
                    DB::beginTransaction();
                    $denuncia = DB::table('denuncias')->where('postagem_id', $request->input('postId'))->get();
    
                    if(isset($denuncia))  DB::table('denuncias')->where('postagem_id', $request->input('postId'))->delete();
    
                    $post->delete();
    
                    DB::commit();
    
                    return redirect()->route('admin.denuncias')->with('mensagem', "Postagem excluida com sucesso")->withInput();
                }
                else{
                    return redirect()->route('admin.denuncias')->with("falha", "Postagem não encontrada")->withInput();
                }
            }
            catch(\Illuminate\Database\QueryException $e) { 
    
                DB::rollBack();
                return redirect()->route('admin.denuncias')->with("falha", "Erro ao excluir postagem.")->withInput();
            }
        }
        else if(isset($_POST["excluirDenuncia"])){
            try{
                DB::beginTransaction();
                  
                DB::table('denuncias')->where('postagem_id', $request->input('postId'))->delete();
                
                DB::commit();
    
                return redirect()->route('admin.denuncias')->with('mensagem', "Denúncia excluida com sucesso")->withInput();            
            }
            catch(\Illuminate\Database\QueryException $e) { 
    
                DB::rollBack();
                return redirect()->route('admin.denuncias')->with("falha", "Erro ao excluir denúncia.")->withInput();
            }
        }
    }
}
