<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Demo Request Received</title>
</head>

<body style="margin:0; padding:0; background:#F4F6FE; font-family:Arial, sans-serif;">

    <div
        style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Logo -->
        <div style="background:#ffffff; padding:22px 25px 16px; text-align:center;">
            <img src="{{ asset('logo/schoolgear-logo.png') }}" alt="SchoolGear Liberia"
                style="height:52px; width:auto; border:0;">
        </div>

        <!-- Header -->
        <div style="background:#3A2A99; padding:24px 25px; text-align:center;">
            <h2 style="color:#ffffff; margin:0; font-size:20px;">Demo request received</h2>
            <p style="color:#dcd6fb; margin:6px 0 0; font-size:13px;">Reference {{ $demoRequest->reference }}</p>
        </div>

        <!-- Body -->
        <div style="padding:30px; color:#111827;">

            <p style="font-size:16px; margin-top:0;">Hello {{ $demoRequest->full_name }},</p>

            <p style="font-size:15px; line-height:1.6;">
                Thank you for booking a live SchoolGear demo for
                <strong>{{ $demoRequest->school_name }}</strong>. Here are the details we received:
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                style="border:1px solid #e5e7eb; border-radius:8px; margin:20px 0; font-size:14px;">
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; width:38%; border-bottom:1px solid #f0f0f5;">School
                    </td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">
                        <strong>{{ $demoRequest->school_name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Category</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->category_label }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Location</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->city }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Preferred date</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">
                        {{ $demoRequest->preferred_date->format('l, j F Y') }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280;">Preferred time</td>
                    <td style="padding:10px 14px;">{{ $demoRequest->time_label }} (Liberia time, GMT)</td>
                </tr>
            </table>

            <p style="font-size:15px; line-height:1.6;">
                This is a request, not a confirmed session yet. Our team will contact you on WhatsApp or by email
                to confirm the date and time.
            </p>

            <!-- Button -->
            <div style="text-align:center; margin:30px 0;">
                <a href="https://wa.me/231777987113"
                    style="
                    background-color:#5B3DE0;
                    background:linear-gradient(135deg,#3A2A99,#5B3DE0);
                    color:#ffffff;
                    padding:12px 28px;
                    text-decoration:none;
                    border-radius:8px;
                    display:inline-block;
                    font-weight:bold;
                    box-shadow:0 3px 10px rgba(0,0,0,0.15);
               ">
                    Message us on WhatsApp
                </a>
            </div>

            <p style="font-size:13px; color:#6b7280;">
                Need to change your date or time? Reply to this email or message us on WhatsApp and quote
                {{ $demoRequest->reference }}.
            </p>

            <p style="margin-top:20px; font-size:13px;">
                Regards,<br>
                <strong>The SchoolGear Liberia Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="background:#f3f4f6; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
            &copy; {{ date('Y') }} SchoolGear Liberia &middot; Airfield, Sinkor, Monrovia, Liberia
        </div>

    </div>

</body>

</html>
