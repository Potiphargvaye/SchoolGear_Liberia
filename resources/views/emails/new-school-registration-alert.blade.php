@extends('emails.layouts.base')

@section('title', 'New school registration')

@section('content')
    @if ($createdByAdmin)
        <p style="margin:0 0 20px; color:#475467; font-size:15px; line-height:1.7;">
            <strong style="color:#3A2A99;">Created by admin.</strong>
            @if ($createdByName)
                Created by {{ $createdByName }}.
            @endif
        </p>
    @else
        <p style="margin:0 0 20px; color:#475467; font-size:15px; line-height:1.7;">
            A new school has registered on SchoolGear.
        </p>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School registration ID</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC;">{{ $school->registration_id }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School name</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->school_name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Short name</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->short_name ?: 'Not provided' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School email</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->email }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Phone</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->phone ?: 'Not provided' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Address</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->address ?: 'Not provided' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">City / country</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->city ?: 'Not provided' }} / {{ $school->country ?: 'Not provided' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Owner name</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $owner->name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Owner email</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $owner->email }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">User registration ID</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC;">{{ $owner->registration_id }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Registration date</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->created_at?->format('l, j F Y g:i A') ?? 'Not available' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Subscription status</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->subscription_status }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Trial starts</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->trial_start_date?->format('j F Y') ?? 'Not set' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">Trial ends</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">{{ $school->trial_end_date?->format('j F Y') ?? 'Not set' }}</td>
        </tr>
    </table>
@endsection
