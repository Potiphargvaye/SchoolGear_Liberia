<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Demo Request</title>
</head>

<body style="margin:0; padding:0; background:#F4F6FE; font-family:Arial, sans-serif;">

    <div
        style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Logo -->
        <div style="background:#ffffff; padding:22px 25px 16px; text-align:center;">
            <img src="{{ asset('logo/download (1).png') }}" alt="SchoolGear Liberia"
                style="height:52px; width:auto; border:0;">
        </div>

        <!-- Header -->
        <div style="background:#3A2A99; padding:24px 25px; text-align:center;">
            <h2 style="color:#ffffff; margin:0; font-size:20px;">New demo request</h2>
            <p style="color:#dcd6fb; margin:6px 0 0; font-size:13px;">{{ $demoRequest->reference }}</p>
        </div>

        <!-- Body -->
        <div style="padding:30px; color:#111827;">

            <p style="font-size:15px; line-height:1.6; margin-top:0;">
                <strong>{{ $demoRequest->school_name }}</strong> asked to book a live demo or consultation.
            </p>

            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                style="border:1px solid #e5e7eb; border-radius:8px; margin:20px 0; font-size:14px;">
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; width:38%; border-bottom:1px solid #f0f0f5;">Contact
                        person</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->full_name }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Email</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->email }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">WhatsApp</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">
                        <a href="{{ $demoRequest->whatsapp_link }}"
                            style="color:#5B3DE0;">{{ $demoRequest->whatsapp_number }}</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Category</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->category_label }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">City</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->city }}</td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Address</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">{{ $demoRequest->school_address }}
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; border-bottom:1px solid #f0f0f5;">Preferred slot</td>
                    <td style="padding:10px 14px; border-bottom:1px solid #f0f0f5;">
                        {{ $demoRequest->preferred_date->format('l, j F Y') }} at {{ $demoRequest->time_label }} (GMT)
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 14px; color:#6b7280; vertical-align:top;">Message</td>
                    <td style="padding:10px 14px;">{!! $demoRequest->message ? nl2br(e($demoRequest->message)) : 'No message provided.' !!}</td>
                </tr>
            </table>

            <!-- Button -->
            <div style="text-align:center; margin:30px 0 10px;">
                <a href="{{ route('admin.demo-requests.index') }}"
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
                    Open in admin
                </a>
            </div>

            <p style="font-size:12px; color:#6b7280; text-align:center;">
                Reply to this email to write directly to {{ $demoRequest->full_name }}.
            </p>
        </div>

        <!-- Footer -->
        <div style="background:#f3f4f6; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
            &copy; {{ date('Y') }} SchoolGear Liberia
        </div>

    </div>

</body>

</html>
