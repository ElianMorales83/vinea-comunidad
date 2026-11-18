@extends('layouts.app')

@section('title', 'Acceso No Autorizado — Vinea Comunidad')

@section('content')
<div class="py-5 bg-light d-flex align-items-center" style="min-height: 80vh;">
    <div class="container-xl text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 p-5 bg-white">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle p-4 mb-2" style="width: 90px; height: 90px;">
                            <i class="bi bi-shield-x fs-1"></i>
                        </div>
                        <h1 class="h3 fw-bold text-dark mt-3" style="font-family: var(--font-heading);">
                            Acceso Restringido (403)
                        </h1>
                        <p class="text-muted mb-4">
                            {{ $exception->getMessage() ?: 'No cuentas con los permisos o rol requerido para acceder a esta área administrativa.' }}
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary fw-semibold px-4" style="background-color: var(--color-primary);">
                            <i class="bi bi-speedometer2 me-1"></i> Regresar al Dashboard
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary fw-semibold px-3">
                            <i class="bi bi-house me-1"></i> Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
