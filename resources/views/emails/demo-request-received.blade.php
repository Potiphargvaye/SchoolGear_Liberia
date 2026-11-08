@extends('emails.layouts.base')

@section('title', 'Demo request received')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $demoRequest->full_name }},
    </p>
    <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
        Thank you for requesting a SchoolGear demo for <strong style="color:#1F2937;">{{ $demoRequest->school_name }}</strong>.
        Our team will contact you to confirm the session.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Reference</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC;">{{ $demoRequest->reference }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">School</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->school_name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Category</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->category_label }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">City</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->city }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Preferred date</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->preferred_date->format('l, j F Y') }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">Preferred time</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">{{ $demoRequest->time_label }} (Liberia time, GMT)</td>
        </tr>
    </table>

    <p style="margin:22px 0 0; color:#475467; font-size:14px; line-height:1.7;">
        We will be in touch using the contact details you provided.
    </p>
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:24px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="https://wa.me/231777987113"
                    style="display:inline-block; padding:13px 22px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Contact SchoolGear on WhatsApp
                </a>
            </td>
        </tr>
    </table>
@endsection
