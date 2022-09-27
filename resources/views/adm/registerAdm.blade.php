@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Cadastro de Usúario</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="funcao" class="col-md-4 col-form-label text-md-end">Tipo de Perfil</label>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('funcao') is-invalid @enderror" type="radio" name="funcao" id="funcao" value="cid" onClick="habilitar()"  autofocus>
                                        <label class="form-check-label" for="cid">Cidadão</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('funcao') is-invalid @enderror" type="radio" name="funcao" id="funcao" value="emp" onClick="habilitar()">
                                        <label class="form-check-label" for="emp">Empresa</label>
                                    </div>
                                </div>
                                @error('funcao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Nome Completo</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telefone" class="col-md-4 col-form-label text-md-end">Telefone</label>

                            <div class="col-md-6">
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}" required autocomplete="telefone">

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
                                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') }}" required autocomplete="cep">

                                @error('cep')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                       <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar Senha</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!--
 <div class="row mb-3">
                            <label for="data-nascimento" class="col-md-4 col-form-label text-md-end">Data Nascimento</label>

                            <div class="col-md-6">

                                <input id="data-nascimento" type="date" class="form-control @error('data-nascimento') is-invalid @enderror" name="data-nascimento" value="{{ old('data-nascimento') }}" required autocomplete="data-nascimento">

                                @error('data-nascimento')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="morador-desde" class="col-md-4 col-form-label text-md-end">Morador(a) desde</label>

                            <div class="col-md-6">

                                <input id="morador-desde" type="date" class="form-control @error('morador-desde') is-invalid @enderror" name="morador-desde" value="{{ old('morador-desde') }}" required autocomplete="morador-desde">

                                @error('morador-desde')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="data-inauguracao" class="col-md-4 col-form-label text-md-end">Data Inauguração</label>

                            <div class="col-md-6">

                                <input id="data-inauguracao" type="date" class="form-control @error('data-inauguracao') is-invalid @enderror" name="data-inauguracao" value="{{ old('data-inauguracao') }}" required autocomplete="data-inauguracao">

                                @error('data-inauguracao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="chegou-regiao" class="col-md-4 col-form-label text-md-end">Chegou na região em</label>

                            <div class="col-md-6">

                                <input id="chegou-regiao" type="date" class="form-control @error('chegou-regiao') is-invalid @enderror" name="chegou-regiao" value="{{ old('chegou-regiao') }}" required autocomplete="chegou-regiao">

                                @error('chegou-regiao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="resumo" class="col-md-4 col-form-label text-md-end">Resumo Profissional</label>

                            <div class="col-md-6">
                            <textarea id="resumo" class="form-control @error('resumo') is-invalid @enderror" name="resumo" value="{{ old('resumo') }}" required autocomplete="resumo"></textarea>

                                @error('resumo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


<script type="text/javascript">

    function habilitar(){
        var funcao = document.getElementById("funcao");

        console.log(''+funcao);

        if(funcao == 'cid') {
            document.getElementById("data-inauguracao").style.display = "block";
            document.getElementById("chegou-regiao").style.display = "block";
            document.getElementById("resumo").style.display = "block";

            document.getElementById("morador-desde").style.display = "none";
            document.getElementById("data-nascimento").style.display = "none";
            document.getElementById("data-inauguracao").style.display = "none";
        }
        else if(funcao == 'emp') {
            document.getElementById("morador-desde").style.display = "block";
            document.getElementById("data-nascimento").style.display = "block";
            document.getElementById("data-inauguracao").style.display = "block";

            document.getElementById("data-inauguracao").style.display = "none";
            document.getElementById("chegou-regiao").style.display = "none";
            document.getElementById("resumo").style.display = "none";
        }
    }
</script>
-->
