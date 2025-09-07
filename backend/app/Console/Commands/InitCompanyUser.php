<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\User;

class InitCompanyUser extends Command
{
    protected $signature = 'app:init';
    protected $description = 'Cria a primeira empresa e o usuário administrador';

    public function handle()
    {
        $name = $this->ask('Nome da empresa');
        $slug = $this->ask('Slug da empresa (ex: minha-empresa)');
        $company = Company::create(['name' => $name, 'slug' => $slug]);

        $userName = $this->ask('Nome do usuário admin');
        $email = $this->ask('E-mail do usuário admin');
        $password = $this->secret('Senha do usuário admin');

        $user = User::create([
            'name' => $userName,
            'email' => $email,
            'password' => bcrypt($password),
            'company_id' => $company->id,
        ]);

        $this->info("Empresa '{$company->name}' criada com usuário {$user->email}");
    }
}
