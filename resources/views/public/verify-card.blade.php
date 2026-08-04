<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Verification | Official Portal</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #d5e0f1;
            color: #333;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .verification-card {
            background: #ffffff;
            max-width: 500px;
            width: 100%;
            border-top: 8px solid navy; /* School Brand Navy Blue */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            padding: 30px;
            text-align: center;
        }

        .badge-container {
            margin-bottom: 20px;
        }

        .verified-badge {
            display: inline-block;
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #badbcc;
        }

        h1 {
            color: navy;
            font-size: 22px;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        p.subtitle {
            font-style: italic;
            color: #666;
            margin: 0 0 25px 0;
            font-size: 14px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-table tr {
            border-bottom: 1px solid #edf2f7;
        }

        .info-table td {
            padding: 12px 6px;
            font-size: 16px;
        }

        .info-table td.label {
            text-align: left;
            font-weight: bold;
            color: navy;
            width: 40%;
        }

        .info-table td.value {
            text-align: right;
            color: #2d3748;
            font-weight: 500;
        }

        .disclaimer {
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            font-style: italic;
            line-height: 1.4;
        }
    </style>
</head>
<body>
<div class="verification-card">
    
    <div class="badge-container">
        <span class="verified-badge">✓ Authenticated Record</span>
    </div>

    <h1>Document Verification</h1>
    <p class="subtitle">Official Academic Report Validation Portal</p>

    <table class="info-table">
        <tr>
            <td class="label">Student Name:</td>
            <td class="value">{{ $student->name }}</td>
        </tr>
        <tr>
            <td class="label">Student ID:</td>
            <td class="value">{{ $student->student_id }}</td> </tr>
        <tr>
            <td class="label">Academic Year / Intake:</td>
            <td class="value">{{ $student->intake ?? '2025/2026' }}</td> </tr>
        <tr>
            <td class="label">Current Status:</td>
            <td class="value" style="color: #0f5132; font-weight: bold; text-transform: uppercase;">
                {{ $student->status }} </td>
        </tr>
    </table>

    <div class="disclaimer">
        This confirmation page programmatically verifies that the physical report card matches the active parameters archived on the school registration engine server.
    </div>
</div>

</body>
</html>