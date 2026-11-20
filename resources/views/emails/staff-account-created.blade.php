@extends('emails.layouts.base')

@section('title', 'Your SchoolGear account')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $user->name }},
    </p>

    @if ($schoolName)
        <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
            You have been added to <strong style="color:#1F2937;">{{ $schoolName }}</strong>'s workspace on SchoolGear as
            <strong style="color:#1F2937;">{{ $roleName }}</strong>.
        </p>
    @else
        <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
            You have been added to the SchoolGear platform as
            <strong style="color:#1F2937;">{{ $roleName }}</strong>.
        </p>
    @endif

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Email address</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $user->email }}</td>
        </tr>
        @if ($user->registration_id)
            <tr>
                <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">
                    User registration ID
                </td>
                <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">
                    {{ $user->registration_id }}
                </td>
            </tr>
        @endif
    </table>

    <p style="margin:22px 0 8px; color:#344054; font-size:13px; font-weight:700;">
        Temporary password
    </p>
    <div style="padding:14px 16px; background-color:#F2F1FA; border:1px solid #E2E5EC; color:#1F2937; font-family:Consolas,'Courier New',monospace; font-size:15px; line-height:1.6; overflow-wrap:anywhere;">
        {{ $temporaryPassword }}
    </div>

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

    <p style="margin:24px 0 0; padding:14px 16px; background-color:#FEF2F2; border-left:3px solid #B91C1C; color:#7F1D1D; font-size:13px; line-height:1.7;">
        This is a temporary password. Change it immediately after your first login. Use
        <a href="{{ $passwordResetUrl }}" style="color:#991B1B; text-decoration:underline; font-weight:700;">Forgot password</a>
        on the login page to reset it.
    </p>
@endsection
