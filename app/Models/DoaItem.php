<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoaItem extends Model
{
    protected $fillable = [
        'doa_category_id', 'title', 'arabic', 'latin', 'translation',
        'notes', 'fawaid', 'source', 'order',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(DoaCategory::class, 'doa_category_id');
    }
}
