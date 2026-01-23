<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('👤 Criando usuários...');

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@locacar.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
            [
                'name' => 'Gerente',
                'email' => 'gerente@locacar.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now()
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info("   ✓ {$this->getCount(User::class)} usuários criados");
    }

    /**
     * Get model count
     */
    private function getCount(string $model): int
    {
        return $model::count();
    }
}
