@extends('layouts.app')

@section('title', 'Editar Usuario — Vinea Comunidad')

@section('content')
<div class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container-xl">

        <!-- Barra Superior / Breadcrumbs -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Gestión de Usuarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Editar Usuario</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0" style="font-family: var(--font-heading);">
                    <i class="bi bi-pencil-square text-danger me-2"></i> Editar Usuario: {{ $user->name }}
                </h1>
                <small class="text-muted">Actualiza los datos personales, contraseña o roles del usuario</small>
            </div>

            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Cancelar y Volver
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-primary text-white py-3 border-bottom border-warning border-3" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="h6 fw-bold mb-0 text-white">
                                <i class="bi bi-person-gear me-1"></i> Modificación de Cuenta #{{ $user->id }}
                            </h2>
                            <span class="badge bg-warning text-dark">
                                Registrado el {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4 small" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                <strong>Por favor revisa los errores indicados:</strong>
                                <ul class="mb-0 mt-1 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PUT')

                            <!-- Nombre Completo -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold small text-muted">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <input id="name" type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold small text-muted">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cambio opcional de contraseña -->
                            <div class="p-3 bg-light rounded-3 mb-4 border">
                                <div class="fw-bold small text-dark mb-1">
                                    <i class="bi bi-shield-lock me-1 text-primary"></i> Cambiar Contraseña (Opcional)
                                </div>
                                <small class="text-muted d-block mb-3">
                                    Deja estos campos en blanco si deseas conservar la contraseña actual del usuario.
                                </small>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold small text-muted">
                                            Nueva Contraseña
                                        </label>
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password" 
                                               placeholder="Dejar en blanco para mantener">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold small text-muted">
                                            Confirmar Nueva Contraseña
                                        </label>
                                        <input id="password_confirmation" type="password" 
                                               class="form-control" 
                                               name="password_confirmation" 
                                               placeholder="Repite la nueva contraseña">
                                    </div>
                                </div>
                            </div>

                            <!-- Asignación de Roles -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted d-block">
                                    Roles Asignados <span class="text-danger">*</span>
                                </label>
                                <small class="text-muted d-block mb-3">
                                    Selecciona los roles activos para este usuario:
                                </small>

                                @php
                                    $rolesActuales = old('roles', $user->roles->pluck('id')->toArray());
                                @endphp

                                <div class="row g-3">
                                    @foreach($roles as $rol)
                                        <div class="col-md-4">
                                            <div class="border rounded-3 p-3 h-100 bg-light">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="roles[]" 
                                                           value="{{ $rol->id }}" 
                                                           id="rol_{{ $rol->id }}"
                                                           {{ in_array($rol->id, $rolesActuales) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold small text-dark" for="rol_{{ $rol->id }}">
                                                        {{ $rol->nombre }}
                                                    </label>
                                                </div>
                                                <small class="text-muted d-block mt-1" style="font-size: 0.78rem;">
                                                    {{ $rol->descripcion }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de Acción -->
                            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-semibold">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-danger fw-bold px-4 shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> Actualizar Usuario
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
