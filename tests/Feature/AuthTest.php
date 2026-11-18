<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Sembrar roles básicos
        Rol::create(['nombre' => 'Administrador', 'descripcion' => 'Admin']);
        Rol::create(['nombre' => 'Editor', 'descripcion' => 'Editor']);
        Rol::create(['nombre' => 'Cliente', 'descripcion' => 'Cliente']);
    }

    public function test_pantalla_de_login_es_accesible_para_invitados(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Portal Pastoral Vinea');
        $response->assertSee('Iniciar Sesión');
    }

    public function test_usuario_puede_iniciar_sesion_con_credenciales_correctas(): void
    {
        $user = User::create([
            'name' => 'Elián Martínez',
            'email' => 'elian@mariamadrededios.org',
            'password' => Hash::make('password123'),
        ]);

        $rol = Rol::where('nombre', 'Administrador')->first();
        $user->roles()->attach($rol);

        $response = $this->post('/login', [
            'email' => 'elian@mariamadrededios.org',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('dashboard'));
    }

    public function test_usuario_no_puede_iniciar_sesion_con_password_incorrecto(): void
    {
        User::create([
            'name' => 'Elián Martínez',
            'email' => 'elian@mariamadrededios.org',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'elian@mariamadrededios.org',
            'password' => 'password_erroneo',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    public function test_usuario_autenticado_es_redirigido_lejos_del_login(): void
    {
        $user = User::create([
            'name' => 'Fiel Parroquiano',
            'email' => 'fiel@mariamadrededios.org',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(route('dashboard'));
    }

    public function test_usuario_puede_cerrar_sesion_mediante_post(): void
    {
        $user = User::create([
            'name' => 'Fiel Parroquiano',
            'email' => 'fiel@mariamadrededios.org',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('home'));
    }

    public function test_invitado_es_redirigido_al_intentar_acceder_al_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_usuario_autenticado_puede_ver_dashboard_con_su_nombre(): void
    {
        $user = User::create([
            'name' => 'José Elián Martínez',
            'email' => 'elian@mariamadrededios.org',
            'password' => Hash::make('password123'),
        ]);

        $rol = Rol::where('nombre', 'Administrador')->first();
        $user->roles()->attach($rol);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('José Elián Martínez');
        $response->assertSee('Cerrar Sesión');
    }
}
