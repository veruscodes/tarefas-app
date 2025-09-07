<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Aqui definimos o guard e configuração de senha padrão da aplicação.
    | Alteramos para "api" para usar JWT por padrão.
    |
    */

    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Definimos o guard "api" para usar JWT ao invés de sessões.
    |
    */

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Define como os usuários serão buscados. Aqui usamos Eloquent.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // Caso queira usar query direto no banco:
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset de Senhas
    |--------------------------------------------------------------------------
    |
    | Configurações para reset de senhas.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout de Confirmação de Senha
    |--------------------------------------------------------------------------
    |
    | Tempo em segundos antes de expirar a confirmação de senha.
    |
    */

    'password_timeout' => 10800,

];
