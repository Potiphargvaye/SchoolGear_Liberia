<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="margin:0; padding:0; background:#F4F6FE; font-family:Arial, sans-serif;">

    @php
        $schoolName = $school->school_name ?? 'SchoolGear Liberia';
        $tagline = $school ? 'Academic Management Portal' : 'School Management Platform';

        $logoUrl = asset('logo/schoolgear-logo.png');

        if ($school && $school->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($school->logo)) {
            $logoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($school->logo);
        }
    @endphp
    <div
        style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#3A2A99,#5B3DE0); padding:28px 25px; text-align:center;">

            <div style="margin-bottom:12px;">
                <img src="{{ $logoUrl }}"
                    style="
                    width:80px;
                    height:80px;
                    border-radius:50%;
                    object-fit:cover;
                    background:#ffffff;
                    padding:4px;
                    border:3px solid #ffffff;
                    box-shadow:0 2px 10px rgba(0,0,0,0.2);
                 "
                    alt="{{ $schoolName }}">
            </div>

            <h2 style="color:#ffffff; margin:0; font-size:18px;">
                {{ $schoolName }}
            </h2>

            <p style="color:#E4DEFB; margin:6px 0 0; font-size:13px;">
                {{ $tagline }}
            </p>
        </div>

        <!-- Body -->
        <div style="padding:30px; color:#111827;">

            <h3 style="color:#3A2A99; margin-top:0;">Hello {{ $user->name }},</h3>

            <p style="font-size:14px; line-height:1.6; color:#333;">
                A request was received to reset the password for your
                <strong>{{ $schoolName }}</strong> account.
            </p>

            <p style="font-size:14px; color:#333;">
                If you made this request, click the button below:
            </p>

            <!-- Button -->
            <div style="text-align:center; margin:30px 0;">
                <a href="{{ $url }}"
                    style="
                    background:linear-gradient(135deg,#3A2A99,#5B3DE0);
                    color:#ffffff;
                    padding:12px 28px;
                    text-decoration:none;
                    border-radius:8px;
                    display:inline-block;
                    font-weight:bold;
                    box-shadow:0 3px 10px rgba(91,61,224,0.25);
               ">
                    Reset My Password
                </a>
            </div>

            <p style="font-size:12px; color:#777;">
                This link will expire in <strong>60 minutes</strong>.
            </p>

            <p style="font-size:12px; color:#777;">
                If you did not request this password reset, you can safely ignore this email.
            </p>

            <hr style="margin:25px 0; border:none; border-top:1px solid #eee;">

            <p style="font-size:13px; color:#3A2A99;">
                Regards,<br>
                <strong>{{ $schoolName }}</strong>
                @if ($school)
                    <br><span style="color:#9c93d6;">Powered by SchoolGear Liberia</span>
                @endif
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f3f4f6; padding:15px; text-align:center; font-size:11px; color:#6b7280;">
            &copy; {{ date('Y') }} {{ $schoolName }}. All rights reserved.
        </div>

    </div>

</body>

</html>
