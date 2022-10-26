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
                        <div class="col-md-3">
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
                                                <input id="data-moradia" type="date" class="form-control mb-2 @error('data-moradia') is-invalid @enderror" name="data-moradia" value="{{ old('data-moradia') }}" autocomplete="data-moradia">
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
                <div class="card border-light mb-3">
                    <div class="card-header">
                    {{$denuncia->id}}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-center">{{$denuncia->titulo}}</h5>
                        <p class="card-text mx-3">{{$denuncia->texto}}</p>
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
@endsection
