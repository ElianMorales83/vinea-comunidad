<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios y sus roles asignados.
     */
    public function index(Request $request): View
    {
        $busqueda = $request->query('buscar');

        $usuarios = User::with('roles')
            ->when($busqueda, function ($query, $busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('name', 'like', "%{$busqueda}%")
                      ->orWhere('email', 'like', "%{$busqueda}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('usuarios', 'busqueda'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create(): View
    {
        $roles = Rol::orderBy('nombre')->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Almacena un usuario nuevo en la base de datos y le asigna sus roles.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', "El usuario «{$user->name}» ha sido registrado correctamente.");
    }

    /**
     * Muestra el formulario de edición de un usuario y sus roles.
     */
    public function edit(User $user): View
    {
        $user->load('roles');
        $roles = Rol::orderBy('nombre')->get();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza la información del usuario y sincroniza sus roles.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->roles()->sync($validated['roles']);

        return redirect()->route('admin.users.index')
            ->with('success', "El usuario «{$user->name}» fue actualizado exitosamente.");
    }

    /**
     * Elimina el usuario especificado del sistema.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Por seguridad, no puedes eliminar tu propia cuenta mientras estás en sesión.');
        }

        $nombre = $user->name;
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "El usuario «{$nombre}» ha sido eliminado correctamente.");
    }
}
