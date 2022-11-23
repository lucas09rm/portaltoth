@extends('adm.layouts.appAdm')

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
                <div class="card-header text-center">
                    <i class="fa-solid fa-house"></i> {{ Auth::user()->name }} 
                    <i class="fa-solid fa-user ms-2"></i> @_{{ Auth::user()->username }} 
                    <i class="fa-solid fa-envelope ms-2"></i> {{ Auth::user()->email }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ asset('img/perfil.png')}}" alt="..." width="60px" class="rounded-circle">
                        </div>
                        <div class="col-md-5 text-end">
                            <a class="btn btn-light" href="{{ route('admin.painel') }}" role="button">Informações</a>
                            <a class="btn btn-light" href="{{ route('admin.denuncias') }}" role="button">Denuncias</a>
                        </div>
                        <div class="col-md-5 text-end">
                            <a class="btn btn-primary" href="{{ route('feed.createInfo') }}" role="button">Nova Informação</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center my-4">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mx-4">Denúncias</h2>
                </div>
                <div class="col-md-6">
                    
                    <div class="row">
                        <div class="col-auto">
                            <form class="form-inline" action="{{ route('admin.pesquisa.denuncia') }}" method="post">
                                @csrf
                                @method('GET')
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
                                <a class="dropdown-item" href="#">
                                    <form class="form-inline" action="{{ route('admin.denuncia.data') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="tipo" name="tipo" value="hoje">
                                        
                                        <button class="btn btn-light" type="submit">Apenas Hoje</button>
                                    </form>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <form class="form-inline" action="{{ route('admin.denuncia.data') }}" method="POST">
                                        Data Espeficíca
                                        @csrf
                                        <input type="hidden" id="tipo" name="tipo" value="data">
                                        <div class="row">
                                            <div class="col">
                                                <input id="data" type="date" class="form-control mb-2 @error('data') is-invalid @enderror" 
                                                    name="data" value="{{ old('data') }}" autocomplete="data">
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
            @if(count($denuncias) > 0)
                @foreach($denuncias as $denuncia)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-2 text-center">
                                <img src="{{ asset('img/perfil.png')}}" alt="..." width="55px" class="rounded-circle">
                            </div>
                            <div class="col-10">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-start">
                                        <strong>{{ $denuncia->usuario }}</strong> @_{{$denuncia->username}}
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="badge bg-secondary">{{$denuncia->tag}}</span>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarAnalise" 
                                            data-bs-whatever="{{$denuncia->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Análise Denúncia">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>                      
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5><strong>{{$denuncia->titulo}}</strong></h5>
                                    </div>
                                </div>                                        
                            </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"></h5>
                        <p class="card-text mx-5">{{$denuncia->texto}}</p>
                        @empty($denuncia->imagem)@else<img src="/storage/{{$denuncia->imagem}}" class="card-img ">@endempty
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-6 text-start">
                                Criado em: {{$denuncia->created_at}}
                            </div>
                            <div class="col-6 text-end">
                                Denunciado em: {{$denuncia->data_denuncia}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            @if(count($denuncias) == 0)
                <div class="alert alert-info my-3">
                    Não há postagens denunciadas
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarAnalise" tabindex="-1" aria-labelledby="confirmarAnalise" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"><strong>Analise de denúncia</strong></h5> 

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ao confirmar a  <strong>análise</strong> a postagem ou denuncia será excluida do portal sem haver a possibilidade de voltar atrás. 
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('admin.analise.denuncia') }}">
                    @csrf
                    <input type="hidden" id="postId" name="postId">

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    
                    <input type="submit" class="btn btn-danger" name="excluirDenuncia" value="Excluir Denúncia">
                    <input type="submit" class="btn btn-danger" name="excluirPost" value="Excluir Postagem">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('javascript')
    <script type="text/javascript">
        var exampleModal = document.getElementById('confirmarAnalise');

        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var info = button.getAttribute('data-bs-whatever');

            var denunciaPost = document.getElementById('postId');

            denunciaPost.value = info;
        });
    </script>
@endsection