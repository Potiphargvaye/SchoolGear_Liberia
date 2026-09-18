<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'school_name',
        'short_name',
        'slug',
        'email',
        'phone',
        'logo',
        'address',
        'country',
        'city',
        'owner_user_id',
        'trial_start_date',
        'trial_end_date',
        'subscription_status',
        'status',
    ];

    protected $casts = [
        'trial_start_date' => 'date',
        'trial_end_date'   => 'date',
    ];

    /**
     * The initial Owner/User account tied to this school.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function isOnTrial(): bool
    {
        return $this->subscription_status === 'trial'
            && $this->trial_end_date
            && $this->trial_end_date->isFuture();
    }

    public function documentSettings(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SchoolDocumentSettings::class);
    }



    /**
     * Sidebar/compact display name. Uses the Owner-provided short_name if
     * set; otherwise auto-generates initials from school_name, skipping
     * common filler words so "MOSES Z BLADE SECONDARY AND PRIMARY SCHOOL"
     * becomes "MZBSPS" rather than including "AND"/"THE"/"OF".
     */
    public function getDisplayShortNameAttribute(): string
    {
        if ($this->short_name) {
            return $this->short_name;
        }

        $skipWords = ['and', 'of', 'the', 'for', 'a', 'an'];

        $initials = collect(explode(' ', $this->school_name))
            ->map(fn($word) => trim($word))
            ->filter(fn($word) => $word !== '' && ! in_array(strtolower($word), $skipWords))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');

        return $initials ?: strtoupper(substr($this->school_name, 0, 2));
    }
}
