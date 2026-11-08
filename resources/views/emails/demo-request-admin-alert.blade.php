@extends('emails.layouts.base')

@section('title', 'New demo request')

@section('content')
    <p style="margin:0 0 20px; color:#475467; font-size:15px; line-height:1.7;">
        A school has requested a SchoolGear demo. Reply to this email to contact {{ $demoRequest->full_name }}.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Reference</td>
            <td style="padding:11px 12px; color:#3A2A99; font-weight:700; border-top:1px solid #E2E5EC;">{{ $demoRequest->reference }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Contact person</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->full_name }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Email</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->email }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">WhatsApp</td>
            <td style="padding:11px 12px; border-top:1px solid #E2E5EC;">
                <a href="{{ $demoRequest->whatsapp_link }}" style="color:#3A2A99; text-decoration:underline;">{{ $demoRequest->whatsapp_number }}</a>
            </td>
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
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">City / address</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->city }} / {{ $demoRequest->school_address }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Preferred slot</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $demoRequest->preferred_date->format('l, j F Y') }} at {{ $demoRequest->time_label }} (GMT)</td>
        </tr>
        <tr>
            <td valign="top" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">Message</td>
            <td style="padding:11px 12px; color:#1F2937; white-space:pre-line; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">{{ $demoRequest->message ?: 'No message provided.' }}</td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:24px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ route('admin.demo-requests.index') }}"
                    style="display:inline-block; padding:13px 22px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Open demo requests
                </a>
            </td>
        </tr>
    </table>
@endsection
