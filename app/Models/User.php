<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación muchos a muchos con el modelo Rol.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'user_id', 'rol_id')
            ->withTimestamps();
    }

    /**
     * Verifica si el usuario posee uno o más roles específicos.
     *
     * @param string|array<string> $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $roleList = is_array($roles) ? $roles : func_get_args();

        return $this->roles->pluck('nombre')->intersect($roleList)->isNotEmpty();
    }

    /**
     * Verifica si el usuario es Administrador.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Administrador');
    }

    /**
     * Verifica si el usuario es Editor.
     */
    public function isEditor(): bool
    {
        return $this->hasRole('Editor');
    }

    /**
     * Verifica si el usuario es Cliente.
     */
    public function isCliente(): bool
    {
        return $this->hasRole('Cliente');
    }

    /**
     * Obtiene los nombres de los roles asignados concatenados por coma.
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('nombre')->implode(', ');
    }
}
