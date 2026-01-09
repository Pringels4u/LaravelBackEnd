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

    /**
     * Many-to-many: users who favourited this news item.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'news_user')->withTimestamps();
    }

    /**
     * Comments for this news item.
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\NewsComment::class)->orderBy('created_at', 'asc');
    }
}
