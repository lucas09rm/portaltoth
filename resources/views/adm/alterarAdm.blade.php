@extends('adm.layouts.appAdm')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('mensagem'))
                <div class="alert alert-success my-3">
                    {{ session('mensagem') }}
                </div>
            @endif
            @if (session('falha'))
                <div class="alert alert-danger">
                    {{ session('falha') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header text-center">Alterar Administrador</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome Completo</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') == '' ? (Auth::user()->name) : old('name')}}" autocomplete="name">

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
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') == '' ? (Auth::user()->telefone) : old('telefone')}}" autocomplete="telefone">

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
                                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') == '' ? (Auth::user()->cep) : old('cep')}}" autocomplete="cep">

                                @error('cep')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="data-nascimento" class="col-md-4 col-form-label text-md-end">Data Nascimento</label>

                            <div class="col-md-6">

                                <input id="data-nascimento" type="date" class="form-control @error('data-nascimento') is-invalid @enderror" name="data-nascimento" value="{{ old('data-nascimento') == '' ? $admin->data_nascimento : old('data-nascimento')}}" autocomplete="data-nascimento">

                                @error('data-nascimento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="data-moradia" class="col-md-4 col-form-label text-md-end">Morador(a) desde</label>

                            <div class="col-md-6">

                                <input id="data-moradia" type="date" class="form-control @error('data-moradia') is-invalid @enderror" name="data-moradia" value="{{ old('data-moradia') == '' ? $admin->data_moradia : old('data-moradia')}}" autocomplete="data-moradia">

                                @error('data-moradia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-danger" data-bs-toggle="modal" href="#confirmarAlteracao" role="button">
                                    Alterar Admin
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
