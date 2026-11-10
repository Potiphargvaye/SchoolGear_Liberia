<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>

<body style="margin:0; padding:0; background-color:#F5F7FA; color:#1F2937; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F7FA"
        style="width:100%; border-collapse:collapse; background-color:#F5F7FA;">
        <tr>
            <td align="center" style="padding:24px 12px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF"
                    style="width:100%; max-width:600px; border-collapse:collapse; background-color:#FFFFFF;">
                    <tr>
                        <td bgcolor="#3A2A99" style="padding:22px 28px; background-color:#3A2A99;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td width="78" valign="middle" style="width:78px; padding-right:18px;">
                                        <img src="{{ asset('logo/schoolgear-logo1.png') }}" width="68" height="68"
                                            alt="SchoolGear Liberia logo"
                                            style="display:block; width:68px; height:68px; border:0; border-radius:50%; background-color:#FFFFFF;">
                                    </td>  
                                    <td valign="middle" style="color:#FFFFFF;">
                                        <p style="margin:0; color:#FFFFFF; font-size:19px; line-height:1.3; font-weight:700;">
                                            SchoolGear Liberia
                                        </p>
                                        <p style="margin:5px 0 0; color:#E4DEFB; font-size:13px; line-height:1.5;">
                                            School management for Liberian schools
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="padding:30px 28px; background-color:#FFFFFF;">
                            <h1 style="margin:0 0 22px; color:#3A2A99; font-size:23px; line-height:1.3; font-weight:700;">
                                @yield('title')
                            </h1>
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#F2F1FA" style="padding:22px 28px; background-color:#F2F1FA; border-top:1px solid #E2E5EC;">
                            @include('emails.partials.footer')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
