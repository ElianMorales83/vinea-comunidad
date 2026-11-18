<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rol extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'rol';

    /**
     * Atributos asignables en masa.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Relación muchos a muchos con el modelo User.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rol_usuario', 'rol_id', 'user_id')
            ->withTimestamps();
    }
}
