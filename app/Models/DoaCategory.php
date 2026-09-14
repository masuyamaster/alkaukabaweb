<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoaCategory extends Model
{
    protected $fillable = ['slug', 'name', 'order'];

    public function items(): HasMany
    {
        return $this->hasMany(DoaItem::class)->orderBy('order');
    }
}
