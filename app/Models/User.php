<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // Configuración de tabla y llave primaria en minúsculas
    protected $table = 'usuarios';
    protected $primaryKey = 'cedulausu';

    // 1. Desactivar los timestamps automáticos de Laravel
    public $timestamps = false;

    // 2. Si quieres que Laravel los maneje con tus nombres, añade esto:
    const CREATED_AT = 'fechacreacion';
    const UPDATED_AT = 'fechaactualizacion';

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Atributos asignables (Columnas en minúsculas para Postgres)
     */
    protected $fillable = [
        'cedulausu',
        'idrol',
        'nombresusu',
        'apellidosusu',
        'emailusu',
        'contraseniausu',
        'telefonousu',
        'direccionusu',
        'estadousu',
        'fechacreacion',
        'fechaactualizacion',
    ];

    protected $hidden = [
        'contraseniausu',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contraseniausu' => 'hashed',
            'estadousu' => 'boolean',
        ];
    }

    // Indica a Laravel que use 'contraseniausu' para el login de suaurios
    public function getAuthPassword()
    {
        return $this->contraseniausu;
    }

    // Indica a Laravel que use 'emailusu' para recuperar contraseña
    public function getEmailForPasswordReset()
    {
        return $this->emailusu;
    }
}
