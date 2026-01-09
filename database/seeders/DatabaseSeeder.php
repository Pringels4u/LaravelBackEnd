<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Maak de admin gebruiker aan (idempotent)
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make('Password!321'),
                'is_admin' => true, // Dit maakt hem admin!
            ]
        );
    // Roep je FAQ seeder aan
    $this->call(FaqSeeder::class);
    // Voeg wat voorbeeld nieuws toe over Chiro Lembeek
    $this->call(NewsSeeder::class);
}
}
