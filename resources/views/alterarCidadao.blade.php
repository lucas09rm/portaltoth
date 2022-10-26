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
                <div class="card-header text-center">Alterar Usúario - Cidadão</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update.cidadao') }}">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome Completo</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                    value="{{ old('name') == '' ? (Auth::user()->name) : old('name')}}" autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefone" class="col-md-4 col-form-label text-md-end">Telefone</label>

                            <div class="col-md-6">
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" 
                                value="{{ old('telefone') == '' ? (Auth::user()->telefone) : old('telefone')}}" autocomplete="telefone">

                                @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cep" class="col-md-4 col-form-label text-md-end">CEP</label>

                            <div class="col-md-6">
                                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" 
                                value="{{ old('cep') == '' ? (Auth::user()->cep) : old('cep')}}" autocomplete="cep">

                                @error('cep')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

<!-- Cidadao -->
                        <div class="row mb-3" id="morador">
                            <label for="morador-desde" class="col-md-4 col-form-label text-md-end">Morador(a) desde</label>

                            <div class="col-md-6">

                                <input id="morador-desde" type="date" class="form-control @error('morador-desde') is-invalid @enderror" name="morador-desde" 
                                    value="{{ old('morador-desde') == '' ? $cidadao->data_moradia : old('morador-desde')}}" autocomplete="morador-desde">

                                @error('morador-desde')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="dataNasc">
                            <label for="data-nasc" class="col-md-4 col-form-label text-md-end">Data Nascimento</label>

                            <div class="col-md-6">

                                <input id="data-nasc" type="date" class="form-control @error('data-nasc') is-invalid @enderror" name="data-nasc" 
                                value="{{ old('data-nasc') == '' ? $cidadao->data_nascimento : old('data-nasc')}}" autocomplete="data-nasc">

                                @error('data-nasc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="sexoUsuario">
                            <label for="sexo" class="col-md-4 col-form-label text-md-end">Sexo</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select mr-sm-2 @error('sexo') is-invalid @enderror" id="sexo" name="sexo">
                                    <option value="">Escolha uma opção...</option>
                                    <option value="Masc" {{ old('sexo') == 'Masc' ? 'selected' : ''}}>Masculino</option>
                                    <option value="Fem" {{ old('sexo') == 'Fem' ? 'selected' : ''}}>Feminino</option>
                                    <option value="NQI" {{ old('sexo') == 'NQI' ? 'selected' : ''}}>Não quero informar</option>
                                </select>

                                @error('sexo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="estadoCivil">
                            <label for="estado-civil" class="col-md-4 col-form-label text-md-end">Estado Civil</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select mr-sm-2 @error('estado-civil') is-invalid @enderror" id="estado-civil" name="estado-civil">
                                    <option value="">Escolha uma opção...</option>
                                    <option value="Casado" {{ old('estado-civil') == 'Casado' ? 'selected' : ''}}>Casado</option>
                                    <option value="Solteiro" {{ old('estado-civil') == 'Solteiro' ? 'selected' : ''}}>Solteiro</option>
                                    <option value="Separado" {{ old('estado-civil') == 'Separado' ? 'selected' : ''}}>Separado</option>
                                    <option value="Divorciado" {{ old('estado-civil') == 'Divorciado' ? 'selected' : ''}}>Divorciado</option>
                                    <option value="Viúvo" {{ old('estado-civil') == 'Viúvo' ? 'selected' : ''}}>Viúvo</option>
                                </select>

                                @error('estado-civil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-5" id="perfil">
                            <div class="col-md-6 offset-md-4">
                                <h5>Perfil Profissional</h5>
                            </div>
                        </div>
<!-- Perfil Profissional -->
                        <div class="row mb-3" id="perfil-profissao">
                            <label for="profissao" class="col-md-4 col-form-label text-md-end">Profissão</label>

                            <div class="col-md-6">
                                <input id="profissao" type="text" class="form-control @error('profissao') is-invalid @enderror" name="profissao" 
                                value="{{ old('profissao') == '' ? $perfil->profissao : old('profissao')}}" autocomplete="profissao">

                                @error('profissao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="areaInteresse">
                            <label for="area" class="col-md-4 col-form-label text-md-end">Área Interesse</label>

                            <div class="col-md-6">
                                <input id="area" type="text" class="form-control @error('area') is-invalid @enderror" name="area" 
                                value="{{ old('area') == '' ? $perfil->area : old('area')}}" autocomplete="area">

                                @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="escola">
                            <label for="escolaridade" class="col-md-4 col-form-label text-md-end">Escolaridade</label>

                            <div class="col-md-6">
                                <input id="escolaridade" type="text" class="form-control @error('escolaridade') is-invalid @enderror" name="escolaridade" 
                                value="{{ old('escolaridade') == '' ? $perfil->escolaridade : old('escolaridade')}}" autocomplete="escolaridade">

                                @error('escolaridade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="resumoCid">
                            <label for="resumo-cid" class="col-md-4 col-form-label text-md-end">Resumo Profissional</label>

                            <div class="col-md-6">
                                <textarea id="resumo-cid" class="form-control @error('resumo-cid') is-invalid @enderror" name="resumo-cid" autocomplete="resumo-cid" 
                                    rows="12" maxlength="800">{{ old('resumo-cid') == '' ? $perfil->texto : old('resumo-cid')}}</textarea>

                                @error('resumo-cid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="perfilStatus">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status Profissional</label>

                            <div class="col-md-6">
                                <select class="form-control custom-select mr-sm-2 @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="">Escolha uma opção...</option>
                                    <option value="true" {{ old('status') == "true" ? 'selected' : ''}}>Disponivel</option>
                                    <option value="false" {{ old('status') == "false" ? 'selected' : ''}}>Indisponivel</option>
                                </select>


                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 my-3   ">
                                <a class="btn btn-danger" data-bs-toggle="modal" href="#confirmarAlteracao" role="button">
                                    Alterar Perfil
                                </a>
                            </div>
                        </div>

                        
                        <!-- Modal -->
                        <div class="modal fade" id="confirmarAlteracao" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title"><strong>Alterar perfil?</strong></h5> 

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Ao confirmar a  <strong>alteração</strong> o perfil será alterado sem haver a possibilidade de voltar atras. 
                                    </div>
                                    <div class="modal-footer">
                                        
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Alterar Perfil</button>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
