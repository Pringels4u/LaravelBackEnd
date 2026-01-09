<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'username',       // Toegevoegd
    'email',
    'password',
    'is_admin',       // Toegevoegd
    'birthday',       // Toegevoegd
    'bio',            // Toegevoegd
    'profile_picture' // Toegevoegd
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Many-to-many: the news items this user has favourited.
     */
    public function favorites()
    {
        return $this->belongsToMany(\App\Models\NewsItem::class, 'news_user')->withTimestamps();
    }

    /**
     * Comments the user has posted on news items.
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\NewsComment::class);
    }
}
