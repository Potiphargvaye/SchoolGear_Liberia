<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolDocumentSettings extends Model
{
    protected $fillable = [
        'school_id',
        'document_name',
        'address',
        'po_box',
        'phone',
        'website',
        'school_number',
        'email',
        'logo_path',
        'footer_location_label',
        'footer_location',
        'footer_call_label',
        'footer_call',
        'footer_email_label',
        'footer_email',
        'footer_note',
        'document_settings',
    ];

    protected $casts = [
        'document_settings' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
