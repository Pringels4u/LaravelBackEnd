<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        \App\Models\NewsItem::create([
            'title' => 'Start nieuw werkjaar: welkom allemaal!',
            'content' => 'We starten het nieuwe werkjaar met een grote groepsactiviteit op het dorpsplein. Iedereen is welkom — breng vrienden mee!',
            'published_at' => $now->subDays(5),
        ]);

        \App\Models\NewsItem::create([
            'title' => 'Weekendkamp inschrijvingen geopend',
            'content' => 'De inschrijvingen voor het jaarlijkse weekendkamp zijn geopend. Plaatsen zijn beperkt, schrijf je snel in via de website.',
            'published_at' => $now->subDays(12),
        ]);

        \App\Models\NewsItem::create([
            'title' => 'Vrijwilligers gezocht voor Chiro-activiteiten',
            'content' => 'We zoeken enthousiaste vrijwilligers en oud-leiding om te helpen bij spelletjes en begeleiding. Neem contact op als je wilt meewerken.',
            'published_at' => $now->subDays(20),
        ]);
    }
}
