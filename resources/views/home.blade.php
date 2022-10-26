@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 mb-3">  
            <div class="list-group">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action list-group-item-secondary">Postagens</a>
                <a href="{{ route('noticias') }}" class="list-group-item list-group-item-action">Noticias</a>
                <a href="{{ route('eventos') }}" class="list-group-item list-group-item-action">Eventos</a>
                <a href="{{ route('promocoes') }}" class="list-group-item list-group-item-action">Promoções</a>
                <a href="{{ route('inauguracoes') }}" class="list-group-item list-group-item-action">Inaugurações</a>
            </div>        
        </div>
        
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    @empty($filtro)
                        <h3 class="mx-4">Postagens</h3>                       
                    @else
                        <h3 class="mx-4">{{$filtro}}</h3>
                    @endempty                    
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <form class="form-inline" action="{{ route('pesquisa.post') }}" method="post">
                                @csrf
                                @method('GET')
                                <input type="hidden" id="filtro" name="filtro" value="@empty($filtro)@else{{$filtro}}@endempty">
                                <div class="row">
                                    <div class="col-auto">
                                            <input type="text" class="form-control @error('pesquisa') is-invalid @enderror" 
                                                id="pesquisa" name="pesquisa" placeholder="Pesquisar Post" value="@empty($pesquisa)@else{{$pesquisa}}@endempty">
                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a id="filtro" class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa-solid fa-filter"></i> Filtro
                            </a>

                            <div class="dropdown-menu" aria-labelledby="filtro">
                                <a class="dropdown-item" href="">
                                    Apenas Hoje
                                </a>

                                <a class="dropdown-item" href="">
                                    <form class=" form-inline" id="logout-form" action="#" method="">
                                        Data Espeficíca
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <input id="data-moradia" type="date" class="form-control mb-2 @error('data-moradia') is-invalid @enderror" 
                                                    name="data-moradia" value="{{ old('data-moradia') }}" autocomplete="data-moradia">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary mx-auto">Pesquisar</button>
                                            </div>
                                        </div>
                                    </form>
                                </a>
                            </div>
                        </div>                        
                    </div>  
                </div>   
            </div>

            <div class="row justify-content-center my-4">
                <div class="col-md-10">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row justify-content-center">
                                    <div class="col-2 text-center">
                                        <img src="{{ asset('img/perfil.png')}}" alt="..." width="55px" class="rounded-circle">
                                    </div>
                                    <div class="col-10">
                                        <div class="row justify-content-center">
                                            <div class="col-6 text-start">
                                                <strong>{{ $post->usuario }}</strong> @_{{$post->username}}
                                            </div>
                                            <div class="col-6 text-end">
                                                <span class="badge bg-secondary">{{$post->tag}}</span>
                                                @if(Auth::user()->funcao == 'cid')
                                                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarDenuncia" data-bs-whatever="{{$post->id}}" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Denunciar Postagem">
                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                </button>  
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <h5><strong>{{$post->titulo}}</strong></h5>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div> 
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-center"></h5>
                                <p class="card-text mx-5">{{$post->texto}}</p>
                                @empty($post->imagem)@else<img src="/storage/{{$post->imagem}}" class="card-img ">@endempty
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-start">
                                        {{$post->created_at}}
                                    </div>
                                    <div class="col-6 text-end">
                                        Post
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @endif
                    @if(count($posts) == 0)
                        <div class="alert alert-info my-3">
                            Não há postagens cadastradas
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarDenuncia" tabindex="-1" aria-labelledby="confirmarDenuncia" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"><strong>Deseja denunciar essa postagem?</strong></h5> 

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ao confirmar a  <strong>denuncia</strong> a postagem será enviada para equipe de denuncias. 
            </div>
            <div class="modal-footer">
                <form>
                    <input type="hidden" id="denunciaId">

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger">Denunciar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
    <script type="text/javascript">
        var exampleModal = document.getElementById('confirmarDenuncia');

        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var info = button.getAttribute('data-bs-whatever');

            var modalFooterInput = exampleModal.querySelector('.modal-footer input');

            modalFooterInput.value = info;
        });
    </script>
@endsection
