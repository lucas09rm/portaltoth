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
            return redirect('/perfil')->with('mensagem', "Postagem cadastrada com sucesso")->withInput();

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
                Storage::delete('/storage/'+$post->imagem);
                $post->delete();

                return redirect("/perfil")->with('mensagem', "Postagem excluida com sucesso")->withInput();
            }
            else{
                return redirect("/perfil")->with("falha", "Postagem não encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return redirect("/perfil")->with("falha", "Erro ao excluir postagem.")->withInput();
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
            return redirect('/perfil')->with('mensagem', "Vaga cadastrada com sucesso")->withInput();

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
                Storage::delete('storage/'.$vaga->imagem);
                $vaga->delete();

                return redirect("/perfil")->with('mensagem', "Vaga excluida com sucesso")->withInput();
            }
            else{
                return redirect("/perfil")->with("falha", "Vaga não encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return redirect("/perfil")->with("falha", "Erro ao excluir vaga.")->withInput();
        }
        
    }

    //INFORMAÇÕES
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
        else if($request->input('tag') == "Infos da Região") $tag = 9;

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
            return redirect("/admin")->with('mensagem', "Informação cadastrada com sucesso")->withInput();

        } catch(\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return redirect()->back()->with("falha", "Erro ao cadastrar informação.")->withInput();
        }
    }

    public function destroyInfo(Request $request)
    {
        try{
            $info = Informacao::find($request->input('infoId'));

            if (isset($info)) {
                Storage::delete('storage/'.$info->imagem);
                $info->delete();

                return redirect("/admin")->with('mensagem', "Informação excluida com sucesso")->withInput();
            }
            else{
                return redirect("/admin")->with("falha", "Informação não encontrada")->withInput();
            }
        }
        catch(\Illuminate\Database\QueryException $e) {
            
            return redirect("/admin")->with("falha", "Erro ao excluir informação.")->withInput();
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
            ], ['required' => "Preenchimento obrigatório", 
                'image' => "Escolha uma uma imagem válida"
            ]);
        }

        if($tipo == "post"){
            return $validator = Validator::make($request->all(), [
                'tag' => ['required'],
                'titulo' => ['required'],
                'texto' => ['required'],
                'imagem' => ['required','image'],
            ], ['required' => "Preenchimento obrigatório", 
                'image' => "Escolha uma imagem válida"
            ]);
        }

        if($tipo == "vaga"){
            return $validator = Validator::make($request->all(), [
                'titulo' => ['required'],
                'profissao' => ['required'],
                'texto' => ['required'],
                'area' => ['required'],
                'imagem' => ['required','image', ],
            ], ['required' => "Preenchimento obrigatório", 
                'image' => "Escolha uma imagem válida"
            ]);
        }

    }
    
}
