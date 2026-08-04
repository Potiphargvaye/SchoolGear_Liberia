<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'start_date',
        'end_date',
        'type',
        'priority',
        'is_pinned',
        'attachment',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_pinned' => 'boolean',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for attachment URL
    public function attachmentUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->attachment ? \Storage::url($this->attachment) : null
        );
    }

    // Scope for pinned announcements
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    // Scope for active announcements
    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', now())
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    // Scope by priority
    public function scopePriority($query, $level)
    {
        return $query->where('priority', $level);
    }
}