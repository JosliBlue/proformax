<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo User para manejar los usuarios del sistema
 *
 * @property int $id
 * @property string $user_name
 * @property string $user_email
 * @property string $user_password
 * @property UserRole $user_rol
 * @property bool $user_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',    // Nombre del usuario
        'user_email',   // Email único del usuario
        'user_password', // Contraseña hasheada
        'user_rol',     // Rol del usuario (admin/user)
        'user_status',   // Estado del usuario (activo/inactivo)
        'company_id'
    ];

    /**
     * Los atributos que deben ser ocultos para serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password', // Ocultar contraseña en respuestas JSON
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_rol' => UserRole::class, // Convertir a Enum UserRole
        'user_status' => 'boolean'     // Convertir a booleano
    ];

    /**
     * Obtiene el campo que se usa como contraseña para autenticación.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    /**
     * Obtiene el campo que se usa como nombre de usuario para autenticación.
     *
     * @return string
     */
    public function username()
    {
        return 'user_email';
    }

    /**
     * Relación con los papers (documentos) creados por el usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function papers()
    {
        return $this->hasMany(Paper::class, 'user_id');
    }

    /**
     * Verifica si el usuario tiene el rol de administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->user_rol === UserRole::ADMIN;
    }

    /**
     * Verifica si el usuario está activo.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->user_status === true;
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
