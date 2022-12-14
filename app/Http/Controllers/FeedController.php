<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Informacao;
use App\Models\Postagem;
use App\Models\Vaga;
use App\Models\Denuncia;

class FeedController extends Controller
{
    //POSTAGEM
    public function createPost()
    {
        return view('cadastrarPostagem');
    }

    public function storePost(Request $request)
    {
        $validator = $this->validacao("post", $request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $tag = 0;

        if($request->input('tag') == "Noticias") $tag = 2;
        else if($request->input('tag') == "Eventos") $tag = 3;
        else if($request->input('tag') == "Promocoes") $tag = 4;
        else if($request->input('tag') == "Inauguracoes") $tag = 5;

        $retorno = false;

        try{
            DB::beginTransaction();

            $path = $request->file('imagem')->store('imagens','public');

            $post = new Postagem();
            $post->titulo = $request->input('titulo');
            $post->texto = $request->input('texto');
            $post->ativo = true;
            $post->tag_id = $tag;
            $post->user_id = Auth::user()->id;
            $post->imagem = $path;

            $retorno = $post->save();

            DB::commit();
            return redirect()->back()->with('mensagem', "Postagem cadastrada com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {
            
            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao cadastrar postagem.")->withInput();
        }
    }

    public function destroyPost(Request $request)
    {
        try{
            $post = Postagem::find($request->input('postId'));

            if (isset($post)) {

                DB::beginTransaction();

                $denuncia = DB::table('denuncias')->where('postagem_id', $request->input('postId'))->get();

                if (isset($denuncia)) DB::table('denuncias')->where('postagem_id', $request->input('postId'))->delete();

                $post->delete(); 
                
                DB::commit();
                
                return redirect()->route('perfil')->with('mensagem', "Postagem excluida com sucesso")->withInput();
            }
            else{
                return redirect()->route('perfil')->with("falha", "Postagem n??o encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->route('perfil')->with("falha", "Erro ao excluir postagem.")->withInput();
        }
        
    }

    public function denunciarPost(Request $request){
        try{
            $denuncia = DB::table('denuncias')->where('postagem_id', $request->input('postId'))->first();
           
            if(!isset($denuncia)){
                $post = Postagem::find($request->input('postId'));
                
                if (isset($post)) {

                    DB::beginTransaction();

                    $denuncia = new Denuncia();
                    $denuncia->ativo = true;
                    $denuncia->analise = "Nao-avaliada";
                    $denuncia->postagem_id = $request->input('postId');
                    $denuncia->user_id = Auth::user()->id;
        
                    $retorno = $denuncia->save();

                    DB::commit();

                    return redirect()->back()->with('mensagem', "Postagem denunciada com sucesso")->withInput();
                }
                else{
                    return redirect()->back()->with("falha", "Postagem n??o encontrada")->withInput();
                }
                
            }else{
                return redirect()->back()->with("mensagem", "Postagem j?? possui den??ncia em an??lise")->withInput();
            }
                                
        }
        catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao denunciar postagem.")->withInput();
        }
    }

    //VAGAS
    public function createVaga()
    {
        return view('cadastrarVaga');
    }

    public function storeVaga(Request $request)
    {
        $validator = $this->validacao("vaga", $request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $retorno = false;

        try{
            DB::beginTransaction();

            $path = $request->file('imagem')->store('imagens','public');

            $vaga = new Vaga();
            $vaga->titulo = $request->input('titulo');            
            $vaga->profissao = $request->input('profissao');            
            $vaga->area = $request->input('area');
            $vaga->texto = $request->input('texto');
            $vaga->tag_id = 1;
            $vaga->user_id = Auth::user()->id;
            $vaga = $request->file('imagem')->store('imagens','public');

            $retorno = $vaga->save();

            DB::commit();
            return redirect()->route('perfil')->with('mensagem', "Vaga cadastrada com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {

            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao cadastrar da vaga.". $e->getMessage())->withInput();
        }
    }

    public function destroyVaga(Request $request)
    {
        try{
            $vaga = Vaga::find($request->input('vagaId'));

            if (isset($vaga)) {
                DB::beginTransaction();

                Storage::delete('storage/'.$vaga->imagem);
                $vaga->delete();

                DB::commit();

                return redirect()->route('perfil')->with('mensagem', "Vaga excluida com sucesso")->withInput();
            }
            else{
                return redirect()->route('perfil')->with("falha", "Vaga n??o encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->route('perfil')->with("falha", "Erro ao excluir vaga.")->withInput();
        }
        
    }

    //INFORMA????ES
    public function createInfo()
    {
        return view('adm.cadastrarInformacao');
    }

    public function storeInfo(Request $request)
    {
        $validator = $this->validacao("info", $request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $tag = 0;

        if($request->input('tag') == "Historia") $tag = 6;
        else if($request->input('tag') == "Voluntariar-se") $tag = 7;
        else if($request->input('tag') == "Projetos") $tag = 8;
        else if($request->input('tag') == "Infos da Regi??o") $tag = 9;

        $retorno = false;

        try{
            DB::beginTransaction();

            $path = $request->file('imagem')->store('imagens','public');

            $info = new Informacao();
            $info->titulo = $request->input('titulo');
            $info->texto = $request->input('texto');
            $info->tag_id = $tag;
            $info->user_id = Auth::user()->id;
            $info->imagem = $path;

            $retorno = $info->save();

            DB::commit();
           
            return redirect()->route('admin.painel')->with('mensagem', "Informa????o cadastrada com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao cadastrar informa????o.")->withInput();
        }
    }

    public function destroyInfo(Request $request)
    {
        try{
            $info = Informacao::find($request->input('infoId'));

            if (isset($info)) {

                DB::beginTransaction();

                Storage::delete('storage/'.$info->imagem);
                $info->delete();

                DB::commit();

                return redirect()->route('admin.painel')->with('mensagem', "Informa????o excluida com sucesso")->withInput();
            }
            else{
                return redirect()->route('admin.painel')->with("falha", "Informa????o n??o encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->route('admin.painel')->with("falha", "Erro ao excluir informa????o.")->withInput();
        }
        
    }

    public function validacao($tipo, Request $request)
    {

        if($tipo == "info"){
            return $validator = Validator::make($request->all(), [
                'tag' => ['required'],
                'titulo' => ['required'],
                'texto' => ['required'],
                'imagem' => ['required','image', ],
            ], ['required' => "Preenchimento obrigat??rio", 
                'image' => "Escolha uma uma imagem v??lida"
            ]);
        }

        if($tipo == "post"){
            return $validator = Validator::make($request->all(), [
                'tag' => ['required'],
                'titulo' => ['required'],
                'texto' => ['required'],
                'imagem' => ['required','image'],
            ], ['required' => "Preenchimento obrigat??rio", 
                'image' => "Escolha uma imagem v??lida"
            ]);
        }

        if($tipo == "vaga"){
            return $validator = Validator::make($request->all(), [
                'titulo' => ['required'],
                'profissao' => ['required'],
                'texto' => ['required'],
                'area' => ['required'],
                'imagem' => ['required','image', ],
            ], ['required' => "Preenchimento obrigat??rio", 
                'image' => "Escolha uma imagem v??lida"
            ]);
        }

    }
    
}
