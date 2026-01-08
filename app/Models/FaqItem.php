<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaqItem extends Model
{
    // Velden die we mogen invullen via een formulier
    protected $fillable = ['category_id', 'question', 'answer'];

    /**
     * Relatie: Dit FAQ item hoort bij één categorie (Inverse van One-to-Many).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
