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
                                        <input class="form-check-input @error('funcao') is-invalid @enderror" type="radio" name="funcao" id="funcao" value="cid" onClick="habilitarCid()" checked  autofocus>
                                        <label class="form-check-label" for="cid">Cidadão</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input @error('funcao') is-invalid @enderror" type="radio" name="funcao" id="funcao" value="emp" onClick="habilitarEmp()">
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

            <!-- Empresa -->
                        <div class="row mb-3" id="dataInau">
                            <label for="data-inauguracao" class="col-md-4 col-form-label text-md-end">Data Inauguração</label>

                            <div class="col-md-6">

                                <input id="data-inauguracao" type="date" class="form-control @error('data-inauguracao') is-invalid @enderror" name="data-inauguracao" value="{{ old('data-inauguracao') }}" autocomplete="data-inauguracao">

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

                                <input id="chegou-regiao" type="date" class="form-control @error('chegou-regiao') is-invalid @enderror" name="chegou-regiao" value="{{ old('chegou-regiao') }}" autocomplete="chegou-regiao">

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
                            <textarea id="resumo" class="form-control @error('resumo') is-invalid @enderror" name="resumo" value="{{ old('resumo') }}" autocomplete="resumo"></textarea>

                                @error('resumo')
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

                                <input id="morador-desde" type="date" class="form-control @error('morador-desde') is-invalid @enderror" name="morador-desde" value="{{ old('morador-desde') }}" autocomplete="morador-desde">

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

                                <input id="data-nasc" type="date" class="form-control @error('data-nasc') is-invalid @enderror" name="data-nasc" value="{{ old('data-nasc') }}" autocomplete="data-nasc">

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
                                <select class="form-control custom-select mr-sm-2 @error('sexo') is-invalid @enderror" id="sexo">
                                    <option selected>Escolha uma opção...</option>
                                    <option value="Masc">Masculino</option>
                                    <option value="Fem">Feminino</option>
                                    <option value="NQI">Não quero informar</option>
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
                                <select class="form-control custom-select mr-sm-2 @error('estado-civil') is-invalid @enderror" id="estado-civil">
                                    <option selected>Escolha uma opção...</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Solteiro">Solteiro</option>
                                    <option value="Separado">Separado</option>
                                    <option value="Divorciado">Divorciado</option>
                                    <option value="Viúvo">Viúvo</option>
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

                        <div class="row mb-3" id="perfil-profissao">
                            <label for="profissao" class="col-md-4 col-form-label text-md-end">Profissão</label>

                            <div class="col-md-6">
                                <input id="profissao" type="text" class="form-control @error('profissao') is-invalid @enderror" name="profissao" value="{{ old('profissao') }}" autocomplete="profissao">

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
                                <input id="area" type="text" class="form-control @error('area') is-invalid @enderror" name="area" value="{{ old('area') }}" autocomplete="area">

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
                                <input id="escolaridade" type="text" class="form-control @error('escolaridade') is-invalid @enderror" name="escolaridade" value="{{ old('escolaridade') }}" autocomplete="escolaridade">

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
                                <textarea id="resumo-cid" class="form-control @error('resumo-cid') is-invalid @enderror" name="resumo-cid" value="{{ old('resumo-cid') }}" autocomplete="resumo-cid"></textarea>

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
                                <select class="form-control custom-select mr-sm-2 @error('status') is-invalid @enderror" id="status">
                                    <option value="Disponivel" selected>Disponivel</option>
                                    <option value="Indisponivel">Indisponivel</option>
                                </select>


                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

<script>
    function habilitarCid() {
        document.getElementById("morador").style.display = '';
        document.getElementById("dataNasc").style.display = '';
        document.getElementById("estadoCivil").style.display = '';
        document.getElementById("sexoUsuario").style.display = '';
        document.getElementById("resumoCid").style.display = '';
        document.getElementById("perfil").style.display = '';
        document.getElementById("perfil-profissao").style.display = '';
        document.getElementById("areaInteresse").style.display = '';
        document.getElementById("escola").style.display = '';
        document.getElementById("perfilStatus").style.display = '';

        document.getElementById("resumoEmp").style.display = 'none';
        document.getElementById("chegouRegiao").style.display = 'none';
        document.getElementById("dataInau").style.display = 'none';
    }

    function habilitarEmp() {
        document.getElementById("morador").style.display = 'none';
        document.getElementById("dataNasc").style.display = 'none';
        document.getElementById("estadoCivil").style.display = 'none';
        document.getElementById("sexoUsuario").style.display = 'none';
        document.getElementById("resumoCid").style.display = 'none';
        document.getElementById("perfil").style.display = 'none';
        document.getElementById("perfil-profissao").style.display = 'none';
        document.getElementById("areaInteresse").style.display = 'none';
        document.getElementById("escola").style.display = 'none';
        document.getElementById("perfilStatus").style.display = 'none';

        document.getElementById("resumoEmp").style.display = '';
        document.getElementById("chegouRegiao").style.display = '';
        document.getElementById("dataInau").style.display = '';
    }
</script>

@endsection
