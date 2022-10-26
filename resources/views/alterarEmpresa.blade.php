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
                <div class="card-header text-center">Alterar Usúario - Empresa</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update.empresa') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome Completo</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                                value="{{ old('name') == '' ? (Auth::user()->name) : old('name')}}" required autocomplete="name">

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
                                value="{{ old('telefone') == '' ? (Auth::user()->telefone) : old('telefone')}}" required autocomplete="telefone">

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
                                value="{{ old('cep') == '' ? (Auth::user()->cep) : old('cep')}}" required autocomplete="cep">

                                @error('cep')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<!-- Empresa -->
                        <div class="row mb-3" id="dataInau">
                            <label for="data-inauguracao" class="col-md-4 col-form-label text-md-end">Data Inauguração</label>

                            <div class="col-md-6">

                                <input id="data-inauguracao" type="date" class="form-control @error('data-inauguracao') is-invalid @enderror" name="data-inauguracao" 
                                value="{{ old('data-inauguracao') == '' ? $empresa->data_inauguracao : old('data-inauguracao')}}" autocomplete="data-inauguracao">

                                @error('data-inauguracao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="chegouRegiao">
                            <label for="chegou-regiao" class="col-md-4 col-form-label text-md-end">Chegou na região em</label>

                            <div class="col-md-6">

                                <input id="chegou-regiao" type="date" class="form-control @error('chegou-regiao') is-invalid @enderror" name="chegou-regiao" 
                                value="{{ old('chegou-regiao') == '' ? $empresa->data_chegada : old('chegou-regiao')}}" autocomplete="chegou-regiao">

                                @error('chegou-regiao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3" id="resumoEmp">
                            <label for="resumo" class="col-md-4 col-form-label text-md-end">Resumo Profissional</label>

                            <div class="col-md-6">
                            <textarea id="resumo" class="form-control @error('resumo') is-invalid @enderror" name="resumo" autocomplete="resumo" 
                                rows="12" maxlength="800">{{ old('resumo') == '' ? $empresa->resumo : old('resumo')}}</textarea>

                                @error('resumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 my-3 ">
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
