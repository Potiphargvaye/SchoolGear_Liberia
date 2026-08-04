<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, sans-serif;">

<!-- HEADER -->
<!-- HEADER -->
<div style="background:#0f2b50; padding:25px; text-align:center;">

    <!-- CIRCULAR LOGO -->
    <div style="margin-bottom:12px;">
        <img src="{{ asset('logo/edmol-orginal-logo.png') }}"
             style="
                width:85px;
                height:85px;
                border-radius:50%;
                object-fit:cover;
                border:3px solid #ffffff;
                box-shadow:0 2px 10px rgba(0,0,0,0.2);
             ">
    </div>

    <h2 style="color:#ffffff; margin:0; font-size:18px;">
        ED-Mol Memorial Matadi Baptist High School
    </h2>

    <p style="color:#cbd5e1; margin:6px 0 0; font-size:13px;">
        Academic Management Portal
    </p>
</div>

<!-- BODY -->
<div style="max-width:600px; margin:30px auto; background:#ffffff; padding:25px; border-radius:10px;">

    <h3 style="color:#0b1f3a;">Hello {{ $user->name }},</h3>

    <p style="color:#333; font-size:14px;">
        A request was received to reset the password for your
        <strong>ED-Mol Memorial Matadi Baptist High School Portal</strong> account.
    </p>

    <p style="color:#333; font-size:14px;">
        If you made this request, click the button below:
    </p>

    <!-- BUTTON -->
    <!-- BUTTON -->
<div style="text-align:center; margin:30px 0;">
    <a href="{{ $url }}"
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

    <p style="font-size:13px; color:#0b1f3a;">
        Regards,<br>
        <strong>ICT Department</strong><br>
        ED-Mol Memorial Matadi Baptist High School
    </p>

</div>

<!-- FOOTER -->
<div style="text-align:center; font-size:11px; color:#888; padding:15px;">
    © {{ date('Y') }} ED-Mol Memorial Matadi Baptist High School. All rights reserved.
</div>

</body>
</html>