<?php

namespace App\Services;

use App\Models\School;
use App\Models\SchoolDocumentSettings;

class SchoolDocumentBranding
{
    public static function for(int $schoolId): array
    {
        $school = School::findOrFail($schoolId);
        $settings = SchoolDocumentSettings::where('school_id', $schoolId)->first();

        return [
            'name' => $settings?->document_name ?: $school->school_name,
            'logo' => $settings?->logo_path ?: $school->logo,
            'address' => $settings?->address ?: $school->address,
            // No fallback on the School model for these three — they're
            // document-branding-only concepts, not columns on schools.
            'po_box' => $settings?->po_box,
            'phone' => $settings?->phone ?: $school->phone,
            'website' => $settings?->website,
            'school_number' => $settings?->school_number,
            'email' => $settings?->email ?: $school->email,
            'footer' => [
                'location_label' => $settings?->footer_location_label ?? 'Our Location',
                'location' => $settings?->footer_location,
                'call_label' => $settings?->footer_call_label ?? 'Call Us',
                'call' => $settings?->footer_call,
                'email_label' => $settings?->footer_email_label ?? 'Email',
                'email' => $settings?->footer_email,
                'note' => $settings?->footer_note ?? 'This document is system-generated and valid without a stamp.',
            ],
            // Internal only — nested {docType: {title, caption}}. Consumers should
            // always go through title()/caption() below, never read this directly,
            // so this structure is free to evolve without breaking callers.
            'documents' => $settings?->document_settings ?? [],
        ];
    }

    public static function title(array $branding, string $docType, string $default): string
    {
        return data_get($branding['documents'], "{$docType}.title") ?: $default;
    }

    public static function caption(array $branding, string $docType, string $default = ''): string
    {
        return data_get($branding['documents'], "{$docType}.caption") ?: $default;
    }
}
