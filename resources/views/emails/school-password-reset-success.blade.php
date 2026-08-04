<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset Successful</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, sans-serif;">

<!-- Container -->
<div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #e5e7eb;">

    <!-- Header -->
    <div style="background:#0f2b50; padding:25px; text-align:center;">
        
        <img src="{{ asset('logo/edmol-orginal-logo.png') }}"
             style="width:80px; height:80px; border-radius:50%; object-fit:cover; background:white; padding:5px;"
             alt="School Logo">

        <h2 style="color:#ffffff; margin:10px 0 0;">Password Reset Successful</h2>
        <p style="color:#cbd5e1; margin:5px 0 0;">ED-Mol Memorial Matadi Baptist High School Portal</p>
    </div>

    <!-- Body -->
    <div style="padding:30px; color:#111827;">

        <p style="font-size:16px;">Hello {{ $user->name }},</p>

        <p style="font-size:15px; line-height:1.6;">
            Your password has been successfully reset for your school portal account.
        </p>

        <p style="font-size:15px; line-height:1.6;">
            If you did NOT perform this action, please contact the ICT Department immediately.
        </p>

        <!-- Button -->
        <div style="text-align:center; margin:30px 0;">
            <a href="{{ url('/login') }}"
                style="
            background:linear-gradient(135deg,#0b1f3a,#ff7a00);
            color:#ffffff;
            padding:12px 28px;
            text-decoration:none;
            border-radius:8px;
            display:inline-block;
            font-weight:bold;
            box-shadow:0 3px 10px rgba(0,0,0,0.15);
       ">
                Login to Your Account
            </a>
        </div>

        <p style="font-size:13px; color:#6b7280;">
            For security reasons, never share your login details with anyone.
        </p>

        <p style="margin-top:20px; font-size:13px;">
            Regards,<br>
            <strong>ICT Department</strong><br>
            ED-Mol Memorial Matadi Baptist High School
        </p>
    </div>

    <!-- Footer -->
    <div style="background:#f3f4f6; padding:15px; text-align:center; font-size:12px; color:#6b7280;">
        © {{ date('Y') }} ED-Mol Memorial Matadi Baptist High School
    </div>

</div>

</body>
</html>