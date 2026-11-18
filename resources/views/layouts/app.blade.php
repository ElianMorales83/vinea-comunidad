<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Parroquia María Madre de Dios — Tehuacán | Vinea Comunidad')</title>
    <meta name="description" content="Portal comunitario de la Parroquia María Madre de Dios en Tehuacán, Puebla. Consulta horarios de misa, sacramentos, calendario litúrgico y enciende una velita en el Muro de Oraciones.">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/virgen-maria.jpg') }}">

    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Estilos Personalizados Vinea Comunidad -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @stack('styles')
</head>
<body>

    <!-- Enlace de Salto Accesible (Skip Link para Teclado - RNF-06) -->
    <a href="#contenido-principal" class="skip-link">Saltar al contenido principal</a>

    <!-- ==========================================================================
         BARRA DE NAVEGACIÓN PRINCIPAL (NAVBAR)
         ========================================================================== -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top py-2" aria-label="Navegación principal">
            <div class="container-xl">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}#inicio">
                    <img src="{{ asset('img/virgen-maria.jpg') }}" alt="María Madre de Dios" class="rounded-circle me-2 border border-warning" style="width: 38px; height: 38px; object-fit: cover;">
                    <div>
                        <span class="d-block fw-bold lh-1" style="font-size: 1.15rem;">María Madre de Dios</span>
                        <small class="text-white-50" style="font-size: 0.72rem; letter-spacing: 1px;">PARROQUIA · TEHUACÁN</small>
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menú de navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}#inicio">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#parroquia">La Parroquia</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#horarios">Horarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#sacramentos">Sacramentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#calendario">Calendario</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#muro">Muro</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#grupos">Grupos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contacto">Contacto</a></li>

                        @auth
                            <!-- Enlaces de Usuario Autenticado -->
                            <li class="nav-item ms-lg-2">
                                <a class="nav-link fw-semibold text-warning {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>

                            @if(Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link fw-semibold text-info {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                        <i class="bi bi-people-fill me-1"></i> Usuarios
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item ms-lg-2">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-light btn-sm px-2 shadow-sm" title="Cerrar Sesión">
                                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                                    </button>
                                </form>
                            </li>
                        @else
                            <!-- Enlace de Acceso Pastoral para Invitados -->
                            <li class="nav-item ms-lg-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm fw-semibold px-3 {{ request()->routeIs('login') ? 'active' : '' }}">
                                    <i class="bi bi-person-lock me-1"></i> Acceso Pastoral
                                </a>
                            </li>
                        @endauth

                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <button type="button" class="btn btn-warning btn-sm fw-bold px-3 shadow-sm text-dark" data-bs-toggle="modal" data-bs-target="#modalEncenderVelita">
                                <i class="bi bi-fire me-1" aria-hidden="true"></i> Encender Velita
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- ==========================================================================
         MENSAJES FLASH Y NOTIFICACIONES
         ========================================================================== -->
    <div class="container-xl mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill fs-5 me-2 text-info"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
    </div>

    <!-- ==========================================================================
         ÁREA DE CONTENIDO PRINCIPAL
         ========================================================================== -->
    <main id="contenido-principal">
        @yield('content')
    </main>

    <!-- ==========================================================================
         PIE DE PÁGINA (FOOTER)
         ========================================================================== -->
    <footer class="custom-footer">
        <div class="container-xl">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('img/virgen-maria.jpg') }}" alt="Logo Parroquial" class="rounded-circle me-2 border border-warning" style="width: 34px; height: 34px; object-fit: cover;">
                        <h3 class="h5 fw-bold text-white mb-0" style="font-family: var(--font-heading);">
                            Parroquia María Madre de Dios
                        </h3>
                    </div>
                    <p class="small text-white-50 mb-3">
                        Comunidad eclesial diocesana de Tehuacán, Puebla. Sitio web informativo y comunitario sin fines de lucro, desarrollado en el marco del TSU en Tecnologías de la Información.
                    </p>
                    <div class="small text-warning">
                        <i class="bi bi-shield-check me-1" aria-hidden="true"></i> Proyecto Vinea Comunidad
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <h4 class="h6 fw-bold text-warning mb-3">Navegación</h4>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}#inicio">Inicio</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#parroquia">La Parroquia</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#horarios">Horarios</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#sacramentos">Sacramentos</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#calendario">Calendario</a></li>
                        <li class="mb-2"><a href="{{ route('home') }}#muro">Muro de Oraciones</a></li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <h4 class="h6 fw-bold text-warning mb-3">Capillas y Sedes</h4>
                    <ul class="list-unstyled small text-white-50">
                        <li class="mb-1">Templo Parroquial (Sectores 1-13)</li>
                        <li class="mb-1 text-white">Capilla del Observatorio (Sectores 14 y 15)</li>
                        <li class="mb-1">Capilla San Juan Diego [SUPUESTO]</li>
                        <li class="mb-1">Capilla Ntra. Sra. de Guadalupe [SUPUESTO]</li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h4 class="h6 fw-bold text-warning mb-3">Acceso Administrativo</h4>
                    @auth
                        <p class="small text-white-50 mb-2">Conectado como <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role_names }}):</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-warning btn-sm fw-semibold me-2 mb-2">
                            <i class="bi bi-speedometer2 me-1"></i> Ir al Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm fw-semibold mb-2">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <p class="small text-white-50 mb-2">Panel de gestión litúrgica y pastoral para el párroco, sacristán y administración:</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-warning btn-sm fw-semibold">
                            <i class="bi bi-lock-fill me-1" aria-hidden="true"></i> Acceso al Panel Pastoral
                        </a>
                    @endauth
                </div>
            </div>

            <div class="pt-4 border-top border-secondary text-center small text-white-50">
                <p class="mb-1">
                    © 2026 Parroquia María Madre de Dios (Tehuacán) · Vinea Comunidad. Todos los derechos pastorales reservados.
                </p>
                <p class="mb-0" style="font-size: 0.78rem;">
                    Desarrollado por el equipo: Sandra Belén De La Cruz Morales, Anthony Pérez Bautista, Guadalupe Amayrani Méndez Huerta, Zamira Pérez Ponce, José Elián Martínez Morales, Luis Ángel Cisneros.
                </p>
            </div>
        </div>
    </footer>

    <!-- Modales Compartidos -->
    @include('partials.modals')

    <!-- Scripts Bootstrap 5.3 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Módulos JavaScript Propios -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/calendario.js') }}"></script>
    <script src="{{ asset('js/muro.js') }}"></script>
    <script src="{{ asset('js/sacramentos.js') }}"></script>

    <script>
        // Toggle dinámico del campo de nombre según la casilla de anonimato en el modal de velitas
        const anonimoCheck = document.getElementById('velita-anonimo');
        const campoNombre = document.getElementById('campo-nombre-velita');
        if (anonimoCheck && campoNombre) {
            anonimoCheck.addEventListener('change', () => {
                campoNombre.style.display = anonimoCheck.checked ? 'none' : 'block';
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
