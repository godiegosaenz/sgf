<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="icon" href="img/iconofisioterapia.png">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    @stack('styles')
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <script src="{{ asset('js/axios.min.js') }}" defer></script>
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{route('home')}}">SGF</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                  @can('Menu personas')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Paciente
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('mostrar.persona') }}">
                                Lista de pacientes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('ingresar.persona') }}">
                                Ingreso de pacientes
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Reportes</a></li>
                    </ul>
                  </li>
                  @endcan
                  @can('Menu citas')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Citas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.cita') }}">
                                Lista de citas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('create.cita') }}">
                                Ingreso de citas
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Reportes</a></li>
                    </ul>
                  </li>
                  @endcan
                  @can('Menu consultas')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Consultas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.consulta') }}">
                                Lista de consultas
                            </a>
                        </li>
                    </ul>
                  </li>
                  @endcan

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Comprobantes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.liquidaciones') }}">
                                Lista de comprobantes
                            </a>
                        </li>
                    </ul>
                  </li>

                  @can('Menu configuraciones')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Configuraciones
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.roles') }}">
                                Roles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('create.roles') }}">
                                Ingresar roles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('crear.asignar.roles') }}">
                                Asignar roles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('index.servicios') }}">
                                servicios
                            </a>
                        </li>
                    </ul>
                  </li>
                  @endcan
                  @can('Menu especialistas')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Especialistas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.especialista') }}">
                                Lista de especialistas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('create.especialista') }}">
                                Ingresar especialista
                            </a>
                        </li>
                    </ul>
                  </li>
                  @endcan
                  @can('Menu usuarios')
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Usuarios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('index.usuario') }}">
                                usuarios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('create.usuario') }}">
                                Ingresar usuario
                            </a>
                        </li>
                    </ul>
                  </li>
                  @endcan
                  <li class="nav-item dropdown me-auto">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Bienvenido {{auth()->user()->name}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('show.usuario',['id' => auth()->user()->id]) }}">
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('ingresar.persona') }}">
                                Cambiar contraseña
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <a onclick="this.closest('form').submit()" style="cursor: pointer;" class="dropdown-item">
                              <i class="fas fa-sign-out-alt mr-2"></i> Salir
                            </a>
                          </form>
                    </ul>
                  </li>
                </ul>

              </div>
            </div>
        </nav>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
@stack('scripts')
</body>
</html>
