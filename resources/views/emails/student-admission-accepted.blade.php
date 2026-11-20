@extends('emails.layouts.base')

@section('title', 'Your admission has been accepted')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Congratulations, {{ $user->name }}.
    </p>
    <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
        Your admission to <strong style="color:#1F2937;">{{ $schoolName }}</strong> has been accepted.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Academic year</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $academicYearName }}</td>
        </tr>
        @if ($gradeName !== '')
            <tr>
                <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Class / grade</td>
                <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $gradeName }}</td>
            </tr>
        @endif
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Admission date</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">
                {{ $admissionDate?->format('j F Y') ?? '—' }}
            </td>
        </tr>
    </table>

    <p style="margin:22px 0 10px; color:#344054; font-size:13px; font-weight:700;">
        Sign in with your {{ $user->registration_id ? 'Registration ID' : 'account email' }} and password.
    </p>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; table-layout:fixed; border-collapse:separate; border-spacing:8px 0;">
        <tr>
            <td width="50%" valign="top" style="padding:0;">
                <p style="margin:0 0 6px; color:#667085; font-size:12px; font-weight:700;">{{ $loginIdentifierLabel }}</p>
                <div style="padding:14px 12px; background-color:#F2F1FA; border:1px solid #E2E5EC; border-radius:4px; color:#3A2A99; font-family:Consolas,'Courier New',monospace; font-size:14px; line-height:1.6; overflow-wrap:anywhere;">
                    {{ $loginIdentifier }}
                </div>
            </td>
            <td width="50%" valign="top" style="padding:0;">
                <p style="margin:0 0 6px; color:#667085; font-size:12px; font-weight:700;">Password</p>
                <div style="padding:14px 12px; background-color:#F2F1FA; border:1px solid #E2E5EC; border-radius:4px; color:#1F2937; font-family:Consolas,'Courier New',monospace; font-size:14px; line-height:1.6; overflow-wrap:anywhere;">
                    {{ $temporaryPassword }}
                </div>
            </td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:26px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ $loginUrl }}"
                    style="display:inline-block; padding:13px 24px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Log in to your student portal
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0; padding:14px 16px; background-color:#FEF2F2; border-left:3px solid #B91C1C; color:#7F1D1D; font-size:13px; line-height:1.7;">
        For your security, change this password after your first login. Use
        <a href="{{ $passwordResetUrl }}" style="color:#991B1B; text-decoration:underline; font-weight:700;">Forgot password</a>
        on the login page to reset it.
    </p>
@endsection
