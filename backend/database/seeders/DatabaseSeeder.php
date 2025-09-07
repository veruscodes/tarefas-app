<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Empresa de exemplo
        $company = Company::create([
            'name' => 'Empresa Exemplo',
            'slug' => 'empresa-exemplo',
        ]);

        // Usuário Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@empresa.com',
            'password' => bcrypt('secret'),
            'company_id' => $company->id,
        ]);
    }
}
