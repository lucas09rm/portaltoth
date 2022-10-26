<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - Portal Toth</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/4fc827e0ea.js" crossorigin="anonymous"></script> 
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ route('admin.painel') }}">
                    <img src="{{ asset('img/logo.png')}}" alt=""width="35" height="35" class="d-inline-block mx-3">
                    Portal Admin Toth
                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                        @else
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('admin.create') }}">Novo Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('admin.edit') }}">Alterar Admin</a>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.create') }}">Cadastrar-se</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url()->previous() }}">Voltar</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('feed.createInfo') }}">
                                        Nova Informação
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.edit.senha') }}">
                                        Alterar Senha
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-dark text-white pt-4 pb-2" style="margin-top: 180px">
            <div class="container text-white text-md-left">
                <div class="row text-center text-md-left">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3"> 
                        <h6 class="text-uppercase mb-4 font-weight-bold text-primary">
                            <img src="{{ asset('img/5.png')}}" alt=""width="30" class="d-inline-block mx-3">
                            Portal Toth
                        </h6>
                        <p><a class="text-white" href="{{ route('feed.createInfo') }}" style="text-decoration: none">Nova Informação</a></p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3"> 
                        <h6 class="text-uppercase mb-4 font-weight-bold text-primary">Ações</h6>
                        <p><a class="text-white" href="{{ route('admin.painel') }}" style="text-decoration: none">Informação</a></p>
                        <p><a class="text-white" href="{{ route('admin.denuncias') }}" style="text-decoration: none">Denúncias</a></p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3"> 
                        <h6 class="text-uppercase mb-4 font-weight-bold text-primary">Usuário</h6>
                        <p><i class="fas fa-solid fa-user me-2"></i><a class="text-white" href="{{ route('admin.create') }}" 
                            style="text-decoration: none">Novo Admin</a></p>
                        <p><i class="fa-solid fa-pen-to-square me-2"></i><a class="text-white" href="{{ route('admin.edit') }}" 
                            style="text-decoration: none">Alterar Admin</a></p>                
                    </div>      
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3"> 
                        <p>Copyright &copy; All rights reserved by:</p>
                        <p><a class="text-white" href="#" style="text-decoration: none"><strong class="text-primary">Portal Toth &copy; {{ date("Y") }}</strong></a></p>
                    </div>            
                </div>
                <hr class="mb-2" />
            </div>
        </footer>
    </div>

    @hasSection('javascript')
        @yield('javascript')
    @endif

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
