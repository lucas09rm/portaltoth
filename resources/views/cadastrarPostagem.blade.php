@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if (session('mensagem'))
                <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                    <strong>Alerta:</strong> {{ session('mensagem') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('falha'))
                <div class="alert alert-danger alert-dismissible fade show my-3" role="alert">
                    <strong>Alerta:</strong> {{ session('falha') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header text-center">Nova Postagem</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('feed.storePost') }}"  enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="titulo" class="col-md-4 col-form-label text-md-end">Titulo</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ old('titulo') }}" autocomplete="titulo">

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" >
                            <label for="texto" class="col-md-4 col-form-label text-md-end">O que voce quer compartilhar?</label>

                            <div class="col-md-6">
                                <textarea id="texto" class="form-control @error('texto') is-invalid @enderror" name="texto" autocomplete="texto"
                                    rows="12" maxlength="800">{{ old('texto') }}</textarea>

                                @error('texto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tag" class="col-md-4 col-form-label text-md-end">Tag</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select mr-sm-2 @error('tag') is-invalid @enderror" id="tag" name="tag" value="{{ old('tag') }}">
                                    <option value="Noticias" selected>Noticias</option>
                                    <option value="Eventos">Eventos</option>
                                    <option value="Promocoes">Promoções</option>
                                    <option value="Inauguracoes">Inaugurações</option>
                                </select>

                                @error('tag')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" >
                            <label for="texto" class="col-md-4 col-form-label text-md-end">Imagem da postagem</label>

                            <div class="col-md-6">
                                <input class="form-control @error('imagem') is-invalid @enderror" type="file" id="imagem" name="imagem">

                                @error('imagem')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>                            
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Postar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
