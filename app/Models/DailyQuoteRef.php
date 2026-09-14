<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyQuoteRef extends Model
{
    protected $fillable = ['type', 'ref', 'order'];
}
