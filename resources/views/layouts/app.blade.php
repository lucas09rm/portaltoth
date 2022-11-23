<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal Toth</title>

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
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png')}}" alt=""width="35" height="35" class="d-inline-block mx-3">
                    Portal Toth
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @guest
                            <li class="nav-item my-2">
                                <strong><a class="nav-link" href="">Saber Mais</a></strong>
                            </li>
                        @else
                            <li class="nav-item">
                                <strong><a class="nav-link " href="{{ route('home') }}">Postagens</a></strong>
                            </li>
                            <li class="nav-item">
                                <strong><a class="nav-link " href="{{ route('infos') }}">Informações</a></strong>
                            </li>
                            <li class="nav-item">
                                <strong><a class="nav-link " href="{{ route('vagas') }}">Vagas</a></strong>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <strong><a class="nav-link " href="{{ route('login') }}">Login</a></strong>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <strong><a class="nav-link " href="{{ route('register') }}">Cadastrar-se</a></strong>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <strong><a class="nav-link" href="{{ url()->previous() }}">Voltar</a></strong>
                            </li>
                            <li class="nav-item dropdown">
                                <strong>
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                        @if (Auth::user()->funcao == "cid") 
                                        
                                            <a class="dropdown-item" href="{{ route('feed.createPost') }}">Novo post</a>
                                                        
                                        @endif
                                        @if (Auth::user()->funcao == "emp")
                                            
                                            <a class="dropdown-item" href="{{ route('feed.createVaga') }}">Nova Vaga</a>
                                                                        
                                        @endif
                                        
                                        <a class="dropdown-item" href="{{ route('perfil') }}">
                                            Perfil
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
                                </strong>
                            </li>
                            <li class="nav-item">
                                <strong>
                                <a class="nav-link" href="{{ route('perfil') }}">
                                    <img src="{{ asset('img/perfil.png')}}" alt="..." width="50px" class="rounded-circle">
                                </a>
                                </strong>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <footer class="bg-dark text-white pt-4 pb-2" style="margin-top: 180px">
        <div class="container text-white text-md-left">
            <div class="row text-center text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3"> 
                    <h6 class="text-uppercase mb-4 font-weight-bold text-primary">
                        <img src="{{ asset('img/5.png')}}" alt=""width="30" class="d-inline-block mx-3">
                        Portal Toth
                    </h6>
                    <p>
                        A comunicação fundamental para troca de informações e experiências, contribuindo para a organização social, 
                        através da mobilização dos indivíduos em prol da luta pelos seus direitos.
                        <a class="text-white" href="" style="text-decoration: none"><strong class="text-primary">Saber Mais</strong></a>
                    </p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3"> 
                    <h6 class="text-uppercase mb-4 font-weight-bold text-primary">Serviços</h6>
                    <p><a class="text-white" href="{{ route('home') }}" style="text-decoration: none">Postagens</a></p>
                    <p><a class="text-white" href="{{ route('vagas') }}" style="text-decoration: none">Vagas</a></p>
                    <p><a class="text-white" href="{{ route('infos') }}" style="text-decoration: none">Informações</a></p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">     
                    @guest
                        <h6 class="text-uppercase mb-4 font-weight-bold text-primary">Tenha acesso</h6>
                        <p><i class="fa-solid fa-right-to-bracket me-2"></i><a class="text-white" href="{{ route('login') }}" style="text-decoration: none">Login</a></p>
                        <p><i class="fa-solid fa-address-card me-2"></i><a class="text-white" href="{{ route('register') }}" style="text-decoration: none">Cadastrar-se</a></p> 
                    @else
                        <h6 class="text-uppercase mb-4 font-weight-bold text-primary">Usuário</h6>
                        <p><i class="fas fa-solid fa-user me-2"></i><a class="text-white" href="{{ route('perfil') }}" style="text-decoration: none">Perfil</a></p>
                        <p><i class="fas fa-solid fa-square-plus me-2"></i><a class="text-white" href="@if(Auth::user()->funcao == 'cid') {{ route('feed.createPost') }}  @elseif (Auth::user()->funcao == 'emp') {{ route('feed.createVaga') }} @endif" style="text-decoration: none">Postar</a></p>
                    @endguest                    
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3"> 
                    <p>Copyright &copy; All rights reserved by:</p>
                    <p><a class="text-white" href="" style="text-decoration: none"><strong class="text-primary">Portal Toth &copy; {{ date("Y") }}</strong></a></p>
                    
                    <p>Este portal é Open Source</p>
                    <p><i class="fa-brands fa-github me-2"></i> <a class="text-white" href="" style="text-decoration: none"><strong class="text-primary">Link Repositório</strong></a></p>
                    <p>Aplique o portal a sua comunidade</p>
                </div>            
            </div>
            <hr class="mb-2" />
        </div>
    </footer>

    @hasSection('javascript')
        @yield('javascript')
    @endif

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
