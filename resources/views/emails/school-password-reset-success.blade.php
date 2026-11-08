@extends('emails.layouts.base')

@php
    $schoolName = $school->school_name ?? 'SchoolGear Liberia';
@endphp

@section('title', 'Password updated')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $user->name }},
    </p>

    <p style="margin:0 0 18px; color:#475467; font-size:15px; line-height:1.7;">
        The password for your <strong style="color:#1F2937;">{{ $schoolName }}</strong> account was reset successfully.
    </p>

    <p style="margin:0; color:#475467; font-size:14px; line-height:1.7;">
        If you did not make this change, contact your school's ICT department as soon as possible.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:26px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ url('/login') }}"
                    style="display:inline-block; padding:13px 24px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Log in to your account
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:22px 0 0; color:#667085; font-size:13px; line-height:1.6;">
        For your security, do not share your password with anyone.
    </p>
@endsection
