<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Period extends Model
{
    protected $fillable = ['school_id', 'name', 'sort_order'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
