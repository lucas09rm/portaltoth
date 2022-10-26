@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

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
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <strong>Cidadão</strong>
                        </div>
                        <div class="col-md-3">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="col-md-7 text-center">
                            <a class="btn btn-light" href="{{ route('edit.perfil') }}" role="button"><i class="fa-solid fa-pen-to-square me-2"></i>Alterar Usuario</a>
                            <a class="btn btn-light" href="{{ route('edit.senha') }}" role="button"><i class="fa-solid fa-pen-to-square me-2"></i>Alterar Senha</a>
                        </div> 
                    </div>
                </div>

                <div class="card-body" >
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ asset('img/perfil.png')}}" alt="..." width="80px" class="rounded-circle">
                        </div>
                        <div class="col-md-5 mb-3" >
                            <div class="row ">
                                <div class="col-md">
                                    <strong>@</strong>{{ Auth::user()->username }}
                                </div>                                                          
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <strong>Email: </strong>{{ Auth::user()->email }}
                                </div>                          
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <strong>Profissão: </strong>{{ $perfil->profissao }}
                                </div>                          
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <strong>Morador desde: </strong>{{ $cidadao->data_moradia }}
                                </div>                          
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <div class="row">
                                <div class="col">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#perfilProfissional">
                                        <i class="fa-solid fa-circle-info me-2"></i>Perfil Profissional
                                    </button> 
                                </div>                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center my-4">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h2 class="mx-4">Postagens</h2>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <form class="form-inline" action="{{ route('pesquisa.perfil') }}" method="post">
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
                                                <input id="data-moradia" type="date" class="form-control mb-2 @error('data-moradia') is-invalid @enderror" name="data-moradia" 
                                                    value="{{ old('data-moradia') }}" autocomplete="data-moradia">
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
        </div>
    </div>
    <div class="row justify-content-center my-4">
        <div class="col-md-8">
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
                                    <span class="badge bg-secondary me-2">{{$post->tag}}</span>
                                     
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarDelete" data-bs-whatever="{{$post->id}}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>  
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
                Não há Postagens cadastradas
            </div>
        @endif
        </div>
    </div>
</div>

<!-- Modal Postagem -->
<div class="modal fade" id="confirmarDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"><strong>Excluir Postagem?</strong></h5> 

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ao confirmar a  <strong>exclusão</strong> a postagem será deletada do portal sem haver a possibilidade de voltar atras. 
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('destroy.post') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="postId" name="postId">

                    <button type="button" class="btn btn-primary " data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Perfil Profissional -->
<div class="modal fade" id="perfilProfissional" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"><strong>Perfil Profissional</strong></h5> 

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Profissão: </strong>{{ $perfil->profissao }}</p>
                <p><strong>Escolaridade: </strong>{{ $perfil->escolaridade }}</p>
                <p><strong>Area: </strong>{{ $perfil->area }}</p>
                <p><strong>Resumo: </strong>{{ $perfil->texto }}</p>
                <p><strong>Status: </strong>{{ $perfil->disponivel == 1 ? "Disponível" : "Indisponível"}}</p>
                
            </div>
            <div class="modal-footer">
                <form>
                    <button type="button" class="btn btn-primary " data-bs-dismiss="modal">Fechar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
    <script type="text/javascript">
        var exampleModal = document.getElementById('confirmarDelete');

        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var info = button.getAttribute('data-bs-whatever');

            var postId = document.getElementById('postId');

            postId.value = info;
        });
    </script>
@endsection
