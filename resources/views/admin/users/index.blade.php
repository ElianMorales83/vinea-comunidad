@extends('layouts.app')

@section('title', 'Gestión de Usuarios — Vinea Comunidad')

@section('content')
<div class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container-xl">

        <!-- Barra Superior / Breadcrumbs -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gestión de Usuarios</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0" style="font-family: var(--font-heading);">
                    <i class="bi bi-people-fill text-danger me-2"></i> Gestión de Usuarios y Roles
                </h1>
                <small class="text-muted">Módulo exclusivo de administración para la Parroquia María Madre de Dios</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Dashboard
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-danger btn-sm fw-bold shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
                </a>
            </div>
        </div>

        <!-- Tarjeta de Contenido / Tabla de Usuarios -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="buscar" value="{{ $busqueda ?? '' }}" class="form-control border-start-0" placeholder="Buscar por nombre o correo...">
                                <button type="submit" class="btn btn-primary fw-semibold">Buscar</button>
                                @if(!empty($busqueda))
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Limpiar filtro">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6 text-md-end small text-muted">
                        Total de usuarios: <strong>{{ $usuarios->total() }}</strong>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small text-muted">
                        <tr>
                            <th scope="col" class="ps-4">ID</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Correo Electrónico</th>
                            <th scope="col">Roles Asignados</th>
                            <th scope="col">Fecha Registro</th>
                            <th scope="col" class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $userItem)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#{{ $userItem->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($userItem->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $userItem->name }}</div>
                                            @if(Auth::id() === $userItem->id)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle small" style="font-size: 0.7rem;">Tu cuenta</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $userItem->email }}</span>
                                </td>
                                <td>
                                    @forelse($userItem->roles as $rol)
                                        @php
                                            $badgeClass = match($rol->nombre) {
                                                'Administrador' => 'bg-danger text-white',
                                                'Editor' => 'bg-info text-dark',
                                                'Cliente' => 'bg-secondary text-white',
                                                default => 'bg-light text-dark border'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} me-1 px-2 py-1">
                                            {{ $rol->nombre }}
                                        </span>
                                    @empty
                                        <span class="badge bg-warning text-dark">Sin rol</span>
                                    @endforelse
                                </td>
                                <td class="small text-muted">
                                    {{ $userItem->created_at ? $userItem->created_at->format('d/m/Y') : '—' }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.users.edit', $userItem) }}" class="btn btn-outline-primary" title="Editar Usuario">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>

                                        @if(Auth::id() !== $userItem->id)
                                            <form action="{{ route('admin.users.destroy', $userItem) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar al usuario «{{ $userItem->name }}»? Esta acción desvinculará sus roles y no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar Usuario">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-outline-secondary disabled" title="No puedes eliminar tu propia cuenta en sesión">
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron usuarios registrados con los criterios solicitados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($usuarios->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                    {{ $usuarios->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
