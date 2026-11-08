@extends('emails.layouts.base')

@php
    $schoolName = $school->school_name ?? 'SchoolGear Liberia';
@endphp

@section('title', 'Reset your password')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $user->name }},
    </p>

    <p style="margin:0 0 18px; color:#475467; font-size:15px; line-height:1.7;">
        We received a request to reset the password for your <strong style="color:#1F2937;">{{ $schoolName }}</strong> account.
        If you made this request, use the button below to choose a new password.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:24px auto; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ $url }}"
                    style="display:inline-block; padding:13px 24px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Reset your password
                </a>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F1FA"
        style="width:100%; border-collapse:collapse; background-color:#F2F1FA;">
        <tr>
            <td style="padding:14px 16px; color:#475467; font-size:13px; line-height:1.6;">
                This link expires in <strong>60 minutes</strong>. If you did not request a password reset, you can ignore this email.
            </td>
        </tr>
    </table>
@endsection
