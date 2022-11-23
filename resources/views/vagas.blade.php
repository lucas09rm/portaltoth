@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 mb-3">  
            <div class="list-group">
                <a href="{{ route('vagas') }}" class="list-group-item list-group-item-action list-group-item-secondary">Vagas</a>
                <a href="{{ route('candidatos') }}" class="list-group-item list-group-item-action">Candidatos</a>
                <a href="{{ route('vagas') }}" class="list-group-item list-group-item-action">Vagas em aberto</a>
            </div>        
        </div>
        
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    @empty($filtro)
                        <h3 class="mx-4">Vagas</h3>                       
                    @else
                        <h3 class="mx-4">{{$filtro}}</h3>
                    @endempty
                </div>
                <div class="col-md-6 mb-3">
                    <div class="row">
                        <div class="col-auto mb-3">
                            <form class="form-inline" action="{{ route('pesquisa.vaga') }}" method="post">
                                @csrf
                                @method('GET')
                                <input type="hidden" id="filtro" name="filtro" value="@empty($filtro)@else{{$filtro}}@endempty">
                                <div class="row">
                                    <div class="col-auto">
                                            <input type="text" class="form-control @error('pesquisa') is-invalid @enderror" 
                                                id="pesquisa" name="pesquisa" placeholder="@empty($filtro) Pesquisar Vaga @else Pesquisar Candidato  @endempty" value="@empty($pesquisa)@else{{$pesquisa}}@endempty">
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
                                    <form class="form-inline" action="{{ route('vaga.data') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="tipo" name="tipo" value="hoje">
                                        <input type="hidden" id="filtro" name="filtro" value="@empty($filtro)@else{{$filtro}}@endempty">
                                        
                                        <button class="btn btn-light" type="submit">Apenas Hoje</button>
                                    </form>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <form class="form-inline" action="{{ route('vaga.data') }}" method="post">
                                        Data Espeficíca
                                        @csrf
                                        <input type="hidden" id="tipo" name="tipo" value="data">
                                        <input type="hidden" id="filtro" name="filtro" value="@empty($filtro)@else{{$filtro}}@endempty">
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
                    </d iv>  
                </div>

            </div>

            <div class="row justify-content-center my-4">
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
                    @if(count($vagas) > 0)
                        @foreach($vagas as $vaga)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="row justify-content-center">
                                        <div class="col-2 text-center">
                                            <img src="{{ asset('img/perfil.png')}}" alt="..." width="55px" class="rounded-circle">
                                        </div>
                                        <div class="col-10">
                                            <div class="row justify-content-center">
                                                <div class="col-6 text-start">
                                                    <strong>{{ $vaga->usuario }}</strong> @_{{$vaga->username}}
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge bg-secondary"> @empty($filtro) {{$vaga->tag}} @else Candidatos @endempty </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    @empty($filtro) Vaga para: @else Profissão: @endempty<h5><strong>@empty($filtro) {{$vaga->titulo}} @else {{$vaga->profissao}} @endempty</strong></h5>
                                                </div>
                                            </div>
                                                                                    
                                        </div>
                                    </div> 
                                </div>
                                <div class="card-body">
                                    @empty($filtro)
                                    @else                                     
                                    <h6 class="card-title mx-5"><strong>Status profissional:</strong> {{$vaga->disponivel == 1 ? "Disponível" : "Indisponível"}}</h6>
                                    <h6 class="card-title mx-5"><strong>Email:</strong> {{$vaga->email}} - <strong>Telefone:</strong> {{$vaga->telefone}}</h6>
                                    @endempty
                                    <h6 class="card-title mx-5"><strong>Área:</strong> {{$vaga->area}}</h6>
                                    <h6 class="card-title mx-5"><strong>@empty($filtro) Profissão: @else Escolaridade: @endempty</strong> @empty($filtro) {{$vaga->profissao}} @else {{$vaga->escolaridade}} @endempty</h6>
                                    <p class="card-text mx-5"><strong>@empty($filtro) Perfil da vaga: @else Resumo Profissional: @endempty </strong> {{nl2br($vaga->texto)}}</p>
                                    @empty($vaga->imagem)@else<img src="/storage/{{$vaga->imagem}}" class="card-img ">@endempty
                                    
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-center">
                                        <div class="col-6 text-start">
                                            {{$vaga->created_at}}
                                        </div>
                                        <div class="col-6 text-end">
                                            Vagas
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if(count($vagas) == 0)
                        <div class="alert alert-info my-3">
                            Não há @empty($filtro) vagas cadastradas @else candidatos cadastrados @endempty 
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
