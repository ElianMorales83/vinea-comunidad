@extends('layouts.app')

@section('title', 'Acceso Pastoral — Vinea Comunidad')

@section('content')
<div class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white text-center py-4 border-bottom border-warning border-3" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning text-dark rounded-circle mb-2" style="width: 54px; height: 54px;">
                            <i class="bi bi-shield-lock-fill fs-3"></i>
                        </div>
                        <h1 class="h4 fw-bold mb-1" style="font-family: var(--font-heading);">Portal Pastoral Vinea</h1>
                        <p class="small text-white-50 mb-0">Inicia sesión con tu cuenta registrada</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show small py-2 mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold small text-muted">
                                    <i class="bi bi-envelope-fill me-1 text-primary"></i> Correo Electrónico
                                </label>
                                <input id="email" type="email" 
                                       class="form-control form-control-lg fs-6 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autofocus 
                                       placeholder="ejemplo@mariamadrededios.org">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold small text-muted">
                                    <i class="bi bi-key-fill me-1 text-primary"></i> Contraseña
                                </label>
                                <input id="password" type="password" 
                                       class="form-control form-control-lg fs-6 @error('password') is-invalid @enderror" 
                                       name="password" required 
                                       placeholder="••••••••">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">
                                        Recordar sesión
                                    </label>
                                </div>
                                <span class="small text-muted"><i class="bi bi-shield-check text-success"></i> Acceso seguro</span>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold text-dark shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-light text-center py-3 border-top small text-muted">
                        <i class="bi bi-info-circle me-1"></i> Módulo de Autenticación y Control de Acceso por Roles
                    </div>
                </div>

                <!-- Tarjeta de credenciales de prueba para evaluación -->
                <div class="card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-body p-3 small">
                        <div class="fw-bold text-primary mb-2 border-bottom pb-1">
                            <i class="bi bi-people-fill me-1"></i> Credenciales de Prueba Sembradas:
                        </div>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">
                                <span class="badge bg-danger">Administrador</span>: <code>admin@mariamadrededios.org</code> / <code>admin1234</code>
                            </li>
                            <li class="mb-1">
                                <span class="badge bg-primary">Editor</span>: <code>editor@mariamadrededios.org</code> / <code>editor1234</code>
                            </li>
                            <li>
                                <span class="badge bg-secondary">Cliente</span>: <code>cliente@mariamadrededios.org</code> / <code>cliente1234</code>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
