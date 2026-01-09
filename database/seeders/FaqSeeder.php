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
    // Algemene vragen over Chiro Lembeek
    $general = \App\Models\Category::firstOrCreate(['name' => 'Algemeen']);

    $general->faqItems()->create([
        'question' => 'Wat is Chiro Lembeek?',
        'answer' => 'Chiro Lembeek is een jeugdbeweging die wekelijks activiteiten organiseert voor kinderen en jongeren in Lembeek.'
    ]);

    $general->faqItems()->create([
        'question' => 'Wanneer zijn de activiteiten?',
        'answer' => 'De groepsactiviteiten vinden plaats op zaterdag van 14:00 tot 17:00, tenzij anders vermeld op de kalender.'
    ]);

    // Activiteiten gerelateerde vragen
    $activities = \App\Models\Category::firstOrCreate(['name' => 'Activiteiten']);

    $activities->faqItems()->create([
        'question' => 'Hoe schrijf ik mijn kind in voor een weekendkamp?',
        'answer' => 'Deelnemers kunnen zich inschrijven via het inschrijvingsformulier of door contact op te nemen met de leiding.'
    ]);

    $activities->faqItems()->create([
        'question' => 'Wat moet mijn kind meebrengen?',
        'answer' => 'Een slaapzak, comfortabele kledij, persoonlijk bestek, en eventuele medicatie. De leiding stuurt een volledige paklijst voor elk kamp.'
    ]);
}
}
