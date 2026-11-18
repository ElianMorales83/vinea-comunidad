<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolAdmin = Rol::where('nombre', 'Administrador')->first();
        $rolEditor = Rol::where('nombre', 'Editor')->first();
        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        // 1. Usuario Administrador (Elián)
        $admin = User::firstOrCreate(
            ['email' => 'admin@mariamadrededios.org'],
            [
                'name' => 'José Elián Martínez Morales',
                'password' => Hash::make('admin1234'),
                'email_verified_at' => now(),
            ]
        );
        if ($rolAdmin) {
            $admin->roles()->syncWithoutDetaching([$rolAdmin->id]);
        }

        // 2. Usuario Editor Pastoral
        $editor = User::firstOrCreate(
            ['email' => 'editor@mariamadrededios.org'],
            [
                'name' => 'Editor Pastoral Vinea',
                'password' => Hash::make('editor1234'),
                'email_verified_at' => now(),
            ]
        );
        if ($rolEditor) {
            $editor->roles()->syncWithoutDetaching([$rolEditor->id]);
        }

        // 3. Usuario Cliente / Feligrés
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@mariamadrededios.org'],
            [
                'name' => 'Fiel Parroquiano',
                'password' => Hash::make('cliente1234'),
                'email_verified_at' => now(),
            ]
        );
        if ($rolCliente) {
            $cliente->roles()->syncWithoutDetaching([$rolCliente->id]);
        }
    }
}
