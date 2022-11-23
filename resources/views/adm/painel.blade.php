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
                        <div class="col-md-5 text-center text-md-end mt-2 mt-md-0">
                            <a class="btn btn-light" href="{{ route('admin.painel') }}" role="button">Informações</a>
                            <a class="btn btn-light" href="{{ route('admin.denuncias') }}" role="button">Denuncias</a>
                        </div>
                        <div class="col-md-5 text-center text-md-end mt-2 mt-md-0 ">
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
                    <h2 class="mx-4">Informações</h2>
                </div>
                <div class="col-md-6">
                    
                    <div class="row">
                        <div class="col-auto">
                            <form class="form-inline" action="{{ route('admin.pesquisa') }}" method="POST">
                                @csrf
                                @method('GET')
                                <div class="row">
                                    <div class="col-auto">
                                        <input type="text" class="form-control @error('pesquisa') is-invalid @enderror" id="pesquisa" name="pesquisa" placeholder="Pesquisar Post" value="@empty($pesquisa)@else{{$pesquisa}}@endempty">
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
                                    <form class="form-inline" action="{{ route('admin.info.data') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="tipo" name="tipo" value="hoje">
                                        
                                        <button class="btn btn-light" type="submit">Apenas Hoje</button>
                                    </form>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <form class="form-inline" action="{{ route('admin.info.data') }}" method="post">
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
            
            @if(count($infos) > 0)
                @foreach($infos as $info)
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row justify-content-center">
                            <div class="col-2 text-center">
                                <img src="{{ asset('img/perfil.png')}}" alt="..." width="55px" class="rounded-circle">
                            </div>
                            <div class="col-10">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-start">
                                        <strong>{{ $info->usuario }}</strong> @_{{$info->username}}
                                    </div>
                                    <div class="col-6 text-end">                                       
                                        <span class="badge bg-secondary">{{$info->tag}}</span>
                                         <!-- Button trigger modal -->
                                         <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmarDelete" 
                                            data-bs-whatever="{{$info->id}}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h5><strong>{{$info->titulo}}</strong></h5>
                                    </div>
                                </div>                                        
                            </div>
                        </div> 
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center"></h5>
                        <p class="card-text mx-5">{!! $info->texto !!}</p>
                        
                        <img src="/storage/{{$info->imagem}}" class="card-img ">
                        
                    </div>
                    
                    <div class="card-footer">
                        <div class="row justify-content-center">
                            <div class="col-6 text-start">
                                {{$info->created_at}}
                            </div>
                            <div class="col-6 text-end">
                                Informações
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            @endif
            @if(count($infos) == 0)
                <div class="alert alert-info my-3">
                    Não há informações cadastradas
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmarDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"><strong>Excluir informação?</strong></h5> 

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ao confirmar a  <strong>exclusão</strong> a informação será deletada do portal sem haver a possibilidade de voltar atras. 
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('admin.destroy.info') }}">
                    @csrf
                    @method('DELETE')
                
                    <input type="hidden" id="infoId" name="infoId">

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Excluir</button>
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

            var infoId = document.getElementById('infoId');

            infoId.value = info;
        });
    </script>
@endsection
