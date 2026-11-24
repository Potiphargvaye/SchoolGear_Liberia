@extends('emails.layouts.base')

@section('title', 'Your grades are available')

@section('content')
    <p style="margin:0 0 12px; color:#1F2937; font-size:16px; line-height:1.6;">
        Hello {{ $student->name }},
    </p>
    <p style="margin:0 0 22px; color:#475467; font-size:15px; line-height:1.7;">
        {{ $schoolName }} has published new grades for you on SchoolGear Liberia.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="width:100%; border-collapse:collapse; font-size:14px; line-height:1.5;">
        <tr>
            <td width="38%" style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Published item</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $slotLabel }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Class</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $gradeName }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Academic year</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $academicYearName }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC;">Published by</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC;">{{ $publishedByName }}</td>
        </tr>
        <tr>
            <td style="padding:11px 12px; color:#667085; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">Published at</td>
            <td style="padding:11px 12px; color:#1F2937; border-top:1px solid #E2E5EC; border-bottom:1px solid #E2E5EC;">{{ $publishedAt->format('j F Y, g:i A') }}</td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"
        style="margin:26px auto 0; border-collapse:collapse;">
        <tr>
            <td align="center" bgcolor="#F2C14E" style="background-color:#F2C14E; border-radius:4px;">
                <a href="{{ $loginUrl }}"
                    style="display:inline-block; padding:13px 24px; color:#241A5B; font-size:14px; line-height:1.2; font-weight:700; text-decoration:none;">
                    Log in to view your grades
                </a>
            </td>
        </tr>
    </table>

    <p style="margin:24px 0 0; padding:14px 16px; background-color:#F2F1FA; border-left:3px solid #3A2A99; color:#344054; font-size:13px; line-height:1.7;">
        Only published grades are visible in the student portal.
    </p>
@endsection
