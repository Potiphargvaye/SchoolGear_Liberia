<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'school_id',
        'admission_id',
        'user_id',
        'image',
        'name',
        'age',
        'gender',
        'parent_phone',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    /**
     * The login account this Student profile belongs to. Student ID
     * shown in the UI is $student->user->registration_id — same pattern
     * as LIPA's Student model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class)->latest('promoted_at');
    }

    public function canBeDeleted(): bool
    {
        return $this->promotions()->doesntExist();
    }
}
