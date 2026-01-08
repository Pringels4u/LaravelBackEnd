<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    use HasFactory;

    // Deze velden mogen "massaal" ingevuld worden (bijv. via een formulier)
    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
    ];

    // Dit zorgt ervoor dat de datum automatisch als een datum-object wordt behandeld
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
