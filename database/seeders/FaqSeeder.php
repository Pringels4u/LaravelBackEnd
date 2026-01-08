<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Maak eerst een categorie
    $category = \App\Models\Category::create(['name' => 'Algemeen']);

    // Voeg daar vragen aan toe
    $category->faqItems()->create([
        'question' => 'Hoe maak ik een account?',
        'answer' => 'Klik op de registreer knop rechtsboven.'
    ]);

    $category->faqItems()->create([
        'question' => 'Is deze website gratis?',
        'answer' => 'Ja, voor studenten is dit volledig gratis.'
    ]);
}
}
