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

class PesquisaController extends Controller
{
     //PESQUISAS
     public function pesquisaPost(Request $request){
        $filtro = $request->input('filtro');

        if($filtro == "Noticias"){ $tag = [2]; $rota = "noticias";}
        else if($filtro == "Eventos"){ $tag = [3]; $rota = "eventos";}
        else if($filtro == "Promocões"){ $tag = [4]; $rota = "promocoes";}
        else if($filtro == "Inaugurações"){ $tag = [5]; $rota = "inauguracoes";}
        else{ $tag = [2,3,4,5]; $rota = "home";}

        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');

        $posts = DB::table('postagems')
            ->join('users', 'users.id', '=', 'postagems.user_id')
            ->join('tags', 'tags.id', '=', 'postagems.tag_id')
            ->select('postagems.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
            ->where( function($query) use ($pesquisa){ return $query 
                ->where('titulo', 'LIKE', '%'.$pesquisa.'%')
                ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%');})
            ->whereIn('tag_id', $tag)
            ->orderBy('postagems.created_at', 'asc')
            ->get();

        return view('home', compact('posts'), ['filtro'=> $filtro, 'pesquisa' => $pesquisa]);
    }

    public function pesquisaInfo(Request $request){
        $filtro = $request->input('filtro');
        
        if($filtro == "História"){$tag = [6]; $rota = "noticias";}
        else if($filtro == "Voluntariar-se") {$tag = [7]; $rota = "voluntariar";}
        else if($filtro == "Projetos") {$tag = [8]; $rota = "projetos";}
        else if($filtro == "Infos da Região") {$tag = [9]; $rota = "infosRegiao";}
        else { $tag = [6,7,8,9]; $rota = "infos";}

        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route($rota)->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');
        
        $infos = DB::table('informacaos')
        ->join('users', 'users.id', '=', 'informacaos.user_id')
        ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
        ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where( function($query) use ($pesquisa){ return $query 
            ->where('titulo', 'LIKE', '%'.$pesquisa.'%')
            ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%');})
        ->whereIn('tag_id', $tag)
        ->orderBy('informacaos.created_at', 'asc')
        ->get();

        return view('informacoes', compact('infos'), ['filtro'=> $filtro, 'pesquisa' => $pesquisa]);
    }

    public function pesquisaVaga(Request $request){
        $filtro = $request->input('filtro');

        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route($filtro == "Candidatos" ? 'candidatos' : 'vagas')->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');

        if($filtro == "Candidatos") {
            $vagas = DB::table('perfil_profissionals')
                ->join('users', 'users.id', '=', 'perfil_profissionals.user_id')
                ->select('perfil_profissionals.*', 'users.name as usuario', 'users.email as email', 'users.telefone as telefone', 'users.username as username')
                ->where( function($query) use ($pesquisa){ return $query 
                    ->where('profissao', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('area', 'LIKE', '%'.$pesquisa.'%');})
                ->get();
        }
        else {
            $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where( function($query) use ($pesquisa){return $query 
                    ->where('profissao', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('titulo', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('area', 'LIKE', '%'.$pesquisa.'%');})
                ->orderBy('vagas.created_at', 'asc')            
                ->get();
        }

        return view('vagas', compact('vagas'), ['filtro'=> $filtro, 'pesquisa' => $pesquisa]);
    }

    public function pesquisaPerfil(Request $request){

        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route('perfil')->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');

        if(Auth::user()->funcao == "emp"){
            $empresa = Empresa::find(Auth::user()->id);
            $vagas = DB::table('vagas')
                ->join('users', 'users.id', '=', 'vagas.user_id')
                ->join('tags', 'tags.id', '=', 'vagas.tag_id')
                ->select('vagas.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where( function($query) use ($pesquisa){return $query 
                    ->where('profissao', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('titulo', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('area', 'LIKE', '%'.$pesquisa.'%');})
                ->where('user_id', Auth::user()->id)
                ->orderBy('vagas.created_at', 'asc')
                ->get();

            return view('perfilEmpresa', compact('empresa', 'vagas', 'pesquisa' ));
        }
        if(Auth::user()->funcao == "cid"){
            $cidadao = Cidadao::find(Auth::user()->id);
            $perfil = DB::table('perfil_profissionals')->where('user_id', Auth::user()->id)->first();;
            
            $posts = DB::table('postagems')
                ->join('users', 'users.id', '=', 'postagems.user_id')
                ->join('tags', 'tags.id', '=', 'postagems.tag_id')
                ->select('postagems.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
                ->where( function($query) use ($pesquisa){ return $query 
                    ->where('titulo', 'LIKE', '%'.$pesquisa.'%')
                    ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%');})
                ->where('user_id', Auth::user()->id)
                ->orderBy('postagems.created_at', 'asc')
                ->get();

            return view('perfilCidadao', compact('cidadao', 'perfil', 'posts', 'pesquisa'));
        }
    }

    public function pesquisaAdmin(Request $request){
        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route('admin.painel')->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');

        $infos = DB::table('informacaos')
        ->join('users', 'users.id', '=', 'informacaos.user_id')
        ->join('tags', 'tags.id', '=', 'informacaos.tag_id')
        ->select('informacaos.*', 'users.name as usuario', 'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where( function($query) use ($pesquisa){ return $query 
            ->where('titulo', 'LIKE', '%'.$pesquisa.'%')
            ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%');})  
        ->orderBy('informacaos.created_at', 'asc')       
        ->get();
    
        return view('adm.painel', compact('infos'), ['pesquisa' => $pesquisa]);
    }

    public function pesquisaDenuncia(Request $request){
        $validator = Validator::make($request->all(), [ 'pesquisa' => ['required'],], ['required' => "Preenchimento obrigatório"]);
        
        if ($validator->fails()) return redirect()->route('admin.painel')->withErrors($validator)->withInput();

        $pesquisa = $request->input('pesquisa');

        $denuncias = DB::table('postagems')
        ->join('users', 'users.id', '=', 'postagems.user_id')
        ->join('denuncias', 'denuncias.postagem_id', '=', 'postagems.id')
        ->join('tags', 'tags.id', '=', 'postagems.tag_id')
        ->select('postagems.*', 'denuncias.created_at as data_denuncia', 'users.name as usuario', 
                'users.email as email', 'users.username as username', 'tags.nome as tag')
        ->where( function($query) use ($pesquisa){ return $query 
            ->where('titulo', 'LIKE', '%'.$pesquisa.'%')
            ->orWhere('texto', 'LIKE', '%'.$pesquisa.'%');}) 
        ->where('denuncias.ativo', 1)
        ->orderBy('postagems.created_at', 'asc')
        ->get();

        return view('adm.denuncias', compact('denuncias'));
    
    }
}
