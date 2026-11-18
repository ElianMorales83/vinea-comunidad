<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso total al sistema, gestión de usuarios, roles y configuración pastoral.',
            ],
            [
                'nombre' => 'Editor',
                'descripcion' => 'Gestión de contenidos, avisos parroquiales, calendario litúrgico y moderación de intenciones.',
            ],
            [
                'nombre' => 'Cliente',
                'descripcion' => 'Fiel parroquial o usuario registrado para solicitar sacramentos, citas y encendido de velitas.',
            ],
        ];

        foreach ($roles as $rolData) {
            Rol::firstOrCreate(
                ['nombre' => $rolData['nombre']],
                ['descripcion' => $rolData['descripcion']]
            );
        }
    }
}
