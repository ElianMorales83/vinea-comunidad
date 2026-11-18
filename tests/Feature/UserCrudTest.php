<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    private Rol $adminRole;
    private Rol $editorRole;
    private Rol $clienteRole;
    private User $adminUser;
    private User $clienteUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRole = Rol::create(['nombre' => 'Administrador', 'descripcion' => 'Admin total']);
        $this->editorRole = Rol::create(['nombre' => 'Editor', 'descripcion' => 'Editor de contenidos']);
        $this->clienteRole = Rol::create(['nombre' => 'Cliente', 'descripcion' => 'Cliente parroquial']);

        $this->adminUser = User::create([
            'name' => 'Admin Elián',
            'email' => 'admin@vinea.org',
            'password' => Hash::make('secret123'),
        ]);
        $this->adminUser->roles()->attach($this->adminRole);

        $this->clienteUser = User::create([
            'name' => 'Feligrés Juan',
            'email' => 'juan@vinea.org',
            'password' => Hash::make('secret123'),
        ]);
        $this->clienteUser->roles()->attach($this->clienteRole);
    }

    public function test_usuario_sin_rol_admin_no_puede_acceder_al_crud_de_usuarios(): void
    {
        // El cliente intenta ingresar a la lista de usuarios
        $response = $this->actingAs($this->clienteUser)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_administrador_puede_listar_usuarios(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Gestión de Usuarios y Roles');
        $response->assertSee('Admin Elián');
        $response->assertSee('Feligrés Juan');
    }

    public function test_administrador_puede_ver_formulario_de_creacion(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/users/create');

        $response->assertStatus(200);
        $response->assertSee('Registrar Nuevo Usuario');
        $response->assertSee('Administrador');
        $response->assertSee('Editor');
        $response->assertSee('Cliente');
    }

    public function test_administrador_puede_crear_un_usuario_con_roles(): void
    {
        $nuevoData = [
            'name' => 'Sandra Belén Morales',
            'email' => 'sandra@vinea.org',
            'password' => 'segura1234',
            'password_confirmation' => 'segura1234',
            'roles' => [$this->editorRole->id],
        ];

        $response = $this->actingAs($this->adminUser)->post('/admin/users', $nuevoData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Sandra Belén Morales',
            'email' => 'sandra@vinea.org',
        ]);

        $creado = User::where('email', 'sandra@vinea.org')->first();
        $this->assertTrue(Hash::check('segura1234', $creado->password));
        $this->assertTrue($creado->roles->contains('nombre', 'Editor'));
    }

    public function test_validacion_al_crear_usuario(): void
    {
        $response = $this->actingAs($this->adminUser)->post('/admin/users', [
            'name' => '',
            'email' => 'email_invalido',
            'password' => '123',
            'password_confirmation' => 'abc',
            'roles' => [],
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'roles']);
    }

    public function test_administrador_puede_ver_formulario_de_edicion(): void
    {
        $response = $this->actingAs($this->adminUser)->get("/admin/users/{$this->clienteUser->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Editar Usuario: Feligrés Juan');
        $response->assertSee($this->clienteUser->email);
    }

    public function test_administrador_puede_actualizar_usuario_y_sus_roles(): void
    {
        $updateData = [
            'name' => 'Feligrés Juan Actualizado',
            'email' => 'juan.actualizado@vinea.org',
            'password' => '', // Mantener contraseña
            'password_confirmation' => '',
            'roles' => [$this->clienteRole->id, $this->editorRole->id],
        ];

        $response = $this->actingAs($this->adminUser)->put("/admin/users/{$this->clienteUser->id}", $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->clienteUser->refresh();
        $this->assertEquals('Feligrés Juan Actualizado', $this->clienteUser->name);
        $this->assertEquals('juan.actualizado@vinea.org', $this->clienteUser->email);
        $this->assertTrue($this->clienteUser->roles->contains('nombre', 'Editor'));
        $this->assertTrue($this->clienteUser->roles->contains('nombre', 'Cliente'));
    }

    public function test_administrador_puede_eliminar_otro_usuario(): void
    {
        $response = $this->actingAs($this->adminUser)->delete("/admin/users/{$this->clienteUser->id}");

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $this->clienteUser->id]);
        $this->assertDatabaseMissing('rol_usuario', ['user_id' => $this->clienteUser->id]);
    }

    public function test_administrador_no_puede_eliminar_su_propia_cuenta(): void
    {
        $response = $this->actingAs($this->adminUser)->delete("/admin/users/{$this->adminUser->id}");

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $this->adminUser->id]);
    }
}
