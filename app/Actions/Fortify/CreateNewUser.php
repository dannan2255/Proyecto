<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // 1. Validación usando nombres de tabla y columnas en minúsculas
        Validator::make($input, [
            'cedula' => ['required', 'string', 'max:10', 'unique:usuarios,cedulausu'],
            'nombres' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:usuarios,emailusu'],
            'password' => $this->passwordRules(),
            //'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // 2. Inserción con columnas en minúsculas
        return User::create([
            'cedulausu' => $input['cedula'],
            'nombresusu' => $input['nombres'],
            'apellidosusu' => $input['apellidos'],
            'emailusu' => $input['email'],
            'contraseniausu' => Hash::make($input['password']),
            'idrol' => 1, // Verifica que el ID 1 exista en tu tabla 'roles'
            'estadousu' => true,
            'telefonousu' => $input['telefono'] ?? '0999999999',
            'fechacreacion' => now(),
            'fechaactualizacion' => now(),
        ]);
    }
}