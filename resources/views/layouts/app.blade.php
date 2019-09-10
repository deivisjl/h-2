<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('img/herbalife.ico') }}">

    <title>Herbalife</title>

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"> -->
</head>
<body>
<div id="loading"></div>
    <div id="app">
    <div class="container-fluid">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="" href="{{ url('/') }}">
                        <img alt="brand" src="{{ asset('img/logo-blanco.png') }}" class="img">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <!-- <li><a href="#">Link</a></li> -->
                        @if(Auth::user()->esAsociado())
                            <li><a href="/mis-comisiones">MIS COMISIONES</a></li>
                        @endif

                        @if(Auth::user()->esAdministrador() || Auth::user()->esDigitador())
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ADMINISTRAR <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="{{ route('paises.index') }}">Paises</a></li>                            
                            <li><a href="{{ route('categorias.index') }}">Categorías</a></li>
                            <li><a href="{{ route('tipo-asociado.index') }}">Tipo asociado</a></li>
                          </ul>
                        </li>
                        <li><a href="{{ route('productos.index') }}">PRODUCTOS</a></li>   
                        <li><a href="{{ route('asociados.index') }}">ASOCIADOS</a></li>
                        @endif
                        @if(Auth::user()->esAdministrador() || Auth::user()->esVendedor())
                         <li><a href="{{ route('pedidos.index') }}">PEDIDOS</a></li>
                        @endif

                         @if(Auth::user()->esAdministrador())
                            <li><a href="{{ route('comisiones.index') }}">COMISIONES</a></li>
                            <li><a href="/reportes">REPORTES</a></li>
                         @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nombres }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                 @if(Auth::user()->esAdministrador())
                                    <li><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                                 @endif
                                
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar sesión
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
    </div> 
    <!-- app -->

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/application.js') }}"></script>
    @yield('js-primary')
    @yield('js')
    @yield('js-secondary')
    @yield('js-tercero')
    @include('flash-toastr::message')
</body>
</html>
