<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Muestra el panel principal / Dashboard pastoral.
     */
    public function index(): View
    {
        $user = Auth::user()->load('roles');

        $metricas = [
            'total_usuarios' => User::count(),
            'total_roles' => Rol::count(),
            'velitas_activas' => 12,
            'oraciones_totales' => 148,
            'citas_pendientes' => 4,
            'eventos_mes' => 8,
        ];

        return view('dashboard', compact('user', 'metricas'));
    }
}
