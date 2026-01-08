<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Dit zorgt ervoor dat we namen in één keer kunnen opslaan
    protected $fillable = ['name'];

    /**
     * Relatie: Eén categorie heeft veel FAQ items (One-to-Many).
     */
    public function faqItems(): HasMany
    {
        return $this->hasMany(FaqItem::class);
    }
}
