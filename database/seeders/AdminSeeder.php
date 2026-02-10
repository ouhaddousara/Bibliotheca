<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Utiliser firstOrCreate pour éviter les doublons
        Admin::firstOrCreate(
            ['email' => 'admin@biblio.fr'],
            [
                'name' => 'Administrateur Principal',
                'password' => Hash::make('admin.2026'),
            ]
        );

    

    

        $this->command->info('✅ Admin créé avec succès !');
    }
}