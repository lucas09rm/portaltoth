@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 mb-3">  
            <div class="list-group">
                <a href="{{ route('infos') }}" class="list-group-item list-group-item-action list-group-item-secondary">Informações</a>
                <a href="{{ route('historia') }}" class="list-group-item list-group-item-action">Historia</a>
                <a href="{{ route('voluntariar') }}" class="list-group-item list-group-item-action">Voluntariar-se</a>
                <a href="{{ route('projetos') }}" class="list-group-item list-group-item-action">Projetos</a>
                <a href="{{ route('infosRegiao') }}" class="list-group-item list-group-item-action">Infos da Região</a>
            </div>        
        </div>
        
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    @empty($filtro)
                        <h3 class="mx-4">Informações</h3>                       
                    @else
                        <h3 class="mx-4">{{$filtro}}</h3>
                    @endempty
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <form class="form-inline" action="{{ route('pesquisa.info') }}" method="post">
                                @csrf
                                @method('GET')
                                <input type="hidden" id="filtro" name="filtro" value="@empty($filtro)@else{{$filtro}}@endempty">
                                <div class="row">
                                    <div class="col-auto">
                                            <input type="text" class="form-control @error('pesquisa') is-invalid @enderror" 
                                                id="pesquisa" name="pesquisa" placeholder="Pesquisar Informação" value="@empty($pesquisa)@else{{$pesquisa}}@endempty">
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
                                <p class="card-text mx-5">{{nl2br($info->texto)}}</p>
                                @empty($info->imagem)@else<img src="/storage/{{$info->imagem}}" class="card-img ">@endempty
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
    </div>
    
</div>
@endsection
