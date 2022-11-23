<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Informacao;
use App\Models\Postagem;
use App\Models\Empresa;
use App\Models\Cidadao;
use App\Models\Vaga;

class DataController extends Controller
{
    //Filtros
    public function dataPost(Request $request){
        $filtro = $request->input('filtro');
        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($filtro == "Noticias"){ $tag = [2]; $rota = "noticias";}
        else if($filtro == "Eventos"){ $tag = [3]; $rota = "eventos";}
        else if($filtro == "Promocões"){ $tag = [4]; $rota = "promocoes";}
        else if($filtro == "Inaugurações"){ $tag = [5]; $rota = "inauguracoes";}
        else{ $tag = [2,3,4,5]; $rota = "home";}

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');

        $posts = DB::table('postagems')
            ->join('users', 'users.id', '=', 'postagems.user_id')
            ->join('tags', 'tags.id', '=', 'postagems.tag_id')
            ->select('postagems.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
            ->where('postagems.created_at', 'LIKE', '%'.$data.'%' )
            ->whereIn('tag_id', $tag)
            ->orderBy('postagems.created_at', 'asc')
            ->get();

        return view('home', compact('posts'), ['filtro'=> $filtro]);
    }

    public function dataInfo(Request $request){
        $filtro = $request->input('filtro');
        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($filtro == "História"){$tag = [6]; $rota = "noticias";}
        else if($filtro == "Voluntariar-se") {$tag = [7]; $rota = "voluntariar";}
        else if($filtro == "Projetos") {$tag = [8]; $rota = "projetos";}
        else if($filtro == "Infos da Região") {$tag = [9]; $rota = "infosRegiao";}
        else { $tag = [6,7,8,9]; $rota = "infos";}

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');
        
        $infos = DB::table('informacaos')
        ->join('users', 'users.id', '=', 'informacaos.user_id')
        ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
        ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where('informacaos.created_at', 'LIKE', '%'.$data.'%' )
        ->whereIn('tag_id', $tag)
        ->orderBy('informacaos.created_at', 'asc')
        ->get();

        return view('informacoes', compact('infos'), ['filtro'=> $filtro]);
    }

    public function dataVaga(Request $request){
        $filtro = $request->input('filtro');
        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');

        if($filtro == "Candidatos") {
            $vagas = DB::table('perfil_profissionals')
                ->join('users', 'users.id', '=', 'perfil_profissionals.user_id')
                ->select('perfil_profissionals.*', 'users.name as usuario', 'users.email as email', 'users.telefone as telefone', 'users.username as username')
                ->where('perfil_profissionals.created_at', 'LIKE', '%'.$data.'%' )
                ->get();
        }
        else {
            $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where('vagas.created_at', 'LIKE', '%'.$data.'%' )
                ->orderBy('vagas.created_at', 'asc')
                ->get();
        }

        return view('vagas', compact('vagas'), ['filtro'=> $filtro]);
    }

    public function dataPerfil(Request $request){

        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');

        if(Auth::user()->funcao == "emp"){
            $empresa = Empresa::find(Auth::user()->id);
            $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where('vagas.created_at', 'LIKE', '%'.$data.'%' )
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
                ->where('postagems.created_at', 'LIKE', '%'.$data.'%' )
                ->where('user_id', Auth::user()->id)
                ->orderBy('postagems.created_at', 'asc')
                ->get();

            return view('perfilCidadao', compact('cidadao', 'perfil', 'posts'));
        }
    }

    public function dataAdmin(Request $request){
        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');

        $infos = DB::table('informacaos')
        ->join('users', 'users.id', '=', 'informacaos.user_id')
        ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
        ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where('informacaos.created_at', 'LIKE', '%'.$data.'%' )   
        ->orderBy('informacaos.created_at', 'asc')  
        ->get();
    
        return view('adm.painel', compact('infos'));
    }

    public function dataDenuncia(Request $request){
        $tipo = $request->input('tipo');    //hoje ou data especifica

        if($tipo != "hoje"){
            $validator = Validator::make($request->all(), [ 'data' => ['required'],], ['required' => "Preenchimento obrigatório"]);
            if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();    
        }
            
        $data = $tipo == "hoje" ? date('Y-m-d') : $request->input('data');

        $denuncias = DB::table('postagems')
        ->join('users', 'users.id', '=', 'postagems.user_id')
        ->join('denuncias', 'denuncias.postagem_id', '=', 'postagems.id')
        ->join('tags', 'tags.id', '=', 'postagems.tag_id')
        ->select('postagems.*', 'denuncias.created_at as data_denuncia', 'users.name as usuario', 
                'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where('denuncias.created_at', 'LIKE', '%'.$data.'%' )
        ->where('denuncias.ativo', 1)
        ->orderBy('postagems.created_at', 'asc')
        ->get();

        return view('adm.denuncias', compact('denuncias'));
    
    }
}
