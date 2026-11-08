@extends('emails.layouts.base')

@section('title', 'Your school account is ready')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $owner->name }},
    </p>
    @if ($createdByAdmin)
        <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
            A SchoolGear administrator has created the account for <strong style="color:#1F2937;">{{ $school->school_name }}</strong>.
            Please get your login details from the SchoolGear administrator, or use
            <a href="{{ route('password.request') }}" style="color:#3A2A99; text-decoration:underline;">Forgot password</a>
            on the login page.
        </p>
    @else
        <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
            Your SchoolGear account for <strong style="color:#1F2937;">{{ $school->school_name }}</strong> was created successfully.
            You can now enjoy your free three-month trial.
        </p>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $school->school_name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School registration ID</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC;">{{ $school->registration_id }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">Your registration ID</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">{{ $owner->registration_id }}</td>
        </tr>
    </table>

    @if ($school->trial_start_date && $school->trial_end_date)
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F1FA"
            style="width:100%; margin-top:20px; border-collapse:collapse; background-color:#F2F1FA;">
            <tr>
                <td style="padding:16px 18px; color:#667085; font-size:13px; line-height:1.5;">
                    Trial period<br>
                    <strong style="display:inline-block; margin-top:5px; color:#3A2A99; font-size:15px;">
                        {{ $school->trial_start_date->format('j F Y') }} to {{ $school->trial_end_date->format('j F Y') }}
                    </strong>
                </td>
            </tr>
        </table>
    @endif

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:26px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ $loginUrl }}"
                    style="display:inline-block; padding:13px 24px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Log in to SchoolGear
                </a>
            </td>
        </tr>
    </table>
@endsection
