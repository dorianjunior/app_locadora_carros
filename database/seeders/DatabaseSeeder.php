<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('');
        $this->command->info('🌱 Iniciando processo de seeding...');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->newLine();

        // Executa seeders em ordem de dependência
        DB::transaction(function () {
            $this->call([
                UserSeeder::class,
                MarcaSeeder::class,
                ModeloSeeder::class,
                CarroSeeder::class,
                ClienteSeeder::class,
                LocacaoSeeder::class,
            ]);
        });

        $this->command->newLine();
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('✅ Seeders concluídos com sucesso!');
        $this->command->newLine();

        // Resumo dos dados criados
        $this->command->table(
            ['Recurso', 'Quantidade'],
            [
                ['Usuários', User::count()],
                ['Marcas', Marca::count()],
                ['Modelos', Modelo::count()],
                ['Carros', Carro::count()],
                ['Clientes', Cliente::count()],
                ['Locações', Locacao::count()],
            ]
        );

        $this->command->newLine();
        $this->command->info('🔑 Credenciais de acesso:');
        $this->command->info('   📧 Email: admin@locacar.com');
        $this->command->info('   🔒 Senha: password123');
        $this->command->newLine();
    }
}
