<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * A request to book a live SchoolGear demo / school consultation.
 *
 * Platform-level record: intentionally has no school_id (see migration).
 */
class DemoRequest extends Model
{
    /** Pipeline statuses: key => label. */
    public const STATUSES = [
        'pending'   => 'Pending',
        'contacted' => 'Contacted',
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    public const CATEGORIES = [
        'primary'   => 'Primary',
        'secondary' => 'Secondary',
    ];

    /** Bookable slots (Liberia time, GMT): key => label. Single source of truth. */
    public const TIME_SLOTS = [
        '09:00' => '9:00 AM',
        '11:00' => '11:00 AM',
        '14:00' => '2:00 PM',
        '16:00' => '4:00 PM',
    ];

    protected $fillable = [
        'full_name',
        'email',
        'whatsapp_number',
        'school_name',
        'city',
        'school_category',
        'school_address',
        'preferred_date',
        'preferred_time',
        'message',
        'status',
        'admin_notes',
        'status_changed_at',
    ];

    protected $casts = [
        'preferred_date'    => 'date',
        'status_changed_at' => 'datetime',
    ];

    /* ---------------------------------------------------------------
     | Accessors
     * ------------------------------------------------------------- */

    /** Human reference shown to the requester and admin, e.g. DEMO-0012. */
    public function getReferenceAttribute(): string
    {
        return 'DEMO-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->school_category] ?? ucfirst((string) $this->school_category);
    }

    public function getTimeLabelAttribute(): string
    {
        return self::TIME_SLOTS[$this->preferred_time] ?? (string) $this->preferred_time;
    }

    public function getWhatsappLinkAttribute(): string
    {
        return 'https://wa.me/' . preg_replace('/\D+/', '', (string) $this->whatsapp_number);
    }

    /* ---------------------------------------------------------------
     | Scopes (shared by the admin list and the Excel export)
     * ------------------------------------------------------------- */

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $like = '%' . $term . '%';

            $q->where('full_name', 'like', $like)
                ->orWhere('email', 'like', $like)
                ->orWhere('school_name', 'like', $like)
                ->orWhere('whatsapp_number', 'like', $like)
                ->orWhere('city', 'like', $like);

            // Allow searching by reference, e.g. "DEMO-0012"
            if (preg_match('/^DEMO-?0*(\d+)$/i', $term, $m)) {
                $q->orWhere('id', (int) $m[1]);
            }
        });
    }

    public function scopeWithStatus(Builder $query, ?string $status): Builder
    {
        if ($status && array_key_exists($status, self::STATUSES)) {
            $query->where('status', $status);
        }

        return $query;
    }
}
