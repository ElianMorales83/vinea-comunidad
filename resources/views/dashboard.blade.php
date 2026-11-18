@extends('layouts.app')

@section('title', 'Panel Pastoral y Dashboard — Vinea Comunidad')

@section('content')
<div class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container-xl">

        <!-- Encabezado de Bienvenida del Dashboard -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4 p-md-5 text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 60%, #0f172a 100%);">
                <div class="row align-items-center">
                    <div class="col-lg-8 d-flex align-items-center">
                        <img src="{{ asset('img/virgen-maria.jpg') }}" alt="María Madre de Dios" class="rounded-circle border border-warning shadow me-3 d-none d-sm-block" style="width: 70px; height: 70px; object-fit: cover;">
                        <div>
                            <div class="d-inline-flex align-items-center gap-2 mb-2 flex-wrap">
                                <span class="badge bg-warning text-dark px-3 py-1 fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Panel Pastoral
                                </span>
                                @foreach(Auth::user()->roles as $rol)
                                    <span class="badge {{ $rol->nombre === 'Administrador' ? 'bg-danger' : ($rol->nombre === 'Editor' ? 'bg-info text-dark' : 'bg-secondary') }} px-3 py-1 fw-bold">
                                        Rol: {{ $rol->nombre }}
                                    </span>
                                @endforeach
                            </div>

                            <h1 class="h2 fw-bold mb-1 text-white" style="font-family: var(--font-heading);">
                                Bienvenido(a), <span class="text-warning">{{ Auth::user()->name }}</span>
                            </h1>
                            <p class="text-white-50 mb-0">
                                Sesión activa: <strong>{{ Auth::user()->email }}</strong> · Parroquia María Madre de Dios (Tehuacán)
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                <i class="bi bi-globe me-1"></i> Ver Portal Web
                            </a>

                            <!-- Botón funcional de Cerrar Sesión (logout via POST) -->
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm fw-bold shadow-sm">
                                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fila de Tarjetas de Métrica Pastoral -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-warning bg-opacity-25 text-warning me-3">
                            <i class="bi bi-fire fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Velitas Activas</span>
                            <span class="fs-4 fw-bold text-dark">{{ $metricas['velitas_activas'] ?? 12 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-heart-pulse-fill fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Oraciones Elevadas</span>
                            <span class="fs-4 fw-bold text-dark">{{ $metricas['oraciones_totales'] ?? 148 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-calendar-check-fill fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Citas Notaría</span>
                            <span class="fs-4 fw-bold text-dark">{{ $metricas['citas_pendientes'] ?? 4 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted small fw-semibold d-block">Usuarios Registrados</span>
                            <span class="fs-4 fw-bold text-dark">{{ $metricas['total_usuarios'] ?? 1 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Módulos y Accesos según Roles -->
        <div class="row g-4">
            <!-- Módulo de Usuarios (Solo Administrador) -->
            @if(Auth::user()->isAdmin())
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 border-top border-danger border-4 bg-white">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                    <i class="bi bi-person-gear fs-4"></i>
                                </div>
                                <div>
                                    <h2 class="h5 fw-bold mb-0 text-dark">Gestión de Usuarios</h2>
                                    <small class="text-danger fw-semibold"><i class="bi bi-shield-fill-check"></i> Solo Administrador</small>
                                </div>
                            </div>
                            <p class="text-muted small flex-grow-1">
                                Administra las cuentas pastorales, crea nuevos usuarios, modifica datos personales y asigna o remueve roles (Administrador, Editor, Cliente).
                            </p>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-danger w-100 fw-semibold">
                                <i class="bi bi-arrow-right-circle me-1"></i> Administrar Usuarios (CRUD)
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Módulo de Contenidos Litúrgicos -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 border-top border-primary border-4 bg-white">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="bi bi-calendar3 fs-4"></i>
                            </div>
                            <div>
                                <h2 class="h5 fw-bold mb-0 text-dark">Calendario Litúrgico</h2>
                                <small class="text-primary fw-semibold">Eventos y Fiestas Parroquiales</small>
                            </div>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            Consulta la programación de misas patronales, peregrinaciones comunitarias y festividades en la Sede y Capillas filiales.
                        </p>
                        <a href="{{ route('home') }}#calendario" class="btn btn-outline-primary w-100 fw-semibold">
                            <i class="bi bi-calendar-event me-1"></i> Ver Calendario
                        </a>
                    </div>
                </div>
            </div>

            <!-- Módulo Muro de Oraciones -->
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 border-top border-warning border-4 bg-white">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-dark rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                <i class="bi bi-fire fs-4"></i>
                            </div>
                            <div>
                                <h2 class="h5 fw-bold mb-0 text-dark">Muro de Oraciones</h2>
                                <small class="text-warning-emphasis fw-semibold">Intenciones Comunitarias</small>
                            </div>
                        </div>
                        <p class="text-muted small flex-grow-1">
                            Visualiza las velitas encendidas por los feligreses, intenciones de salud, difuntos y familias de Tehuacán.
                        </p>
                        <a href="{{ route('home') }}#muro" class="btn btn-outline-warning w-100 fw-semibold text-dark">
                            <i class="bi bi-fire me-1"></i> Ver Muro Comunitario
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Sesión y Cuenta del Usuario -->
        <div class="card border-0 shadow-sm rounded-4 mt-4 bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <h2 class="h6 fw-bold mb-0 text-primary">
                    <i class="bi bi-info-circle me-1"></i> Detalles de la Cuenta Actual
                </h2>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 small">
                    <div class="col-md-3">
                        <span class="text-muted d-block">Nombre Registrado:</span>
                        <strong class="fs-6">{{ Auth::user()->name }}</strong>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted d-block">Correo Electrónico:</span>
                        <strong class="fs-6">{{ Auth::user()->email }}</strong>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted d-block">Roles Asignados:</span>
                        @foreach(Auth::user()->roles as $rol)
                            <span class="badge bg-secondary me-1">{{ $rol->nombre }}</span>
                        @endforeach
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted d-block">Fecha de Creación:</span>
                        <strong>{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y H:i') : 'N/A' }}</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
