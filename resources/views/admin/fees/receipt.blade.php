<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $payment->receipt_number }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 15px;
            font-size: 13px;
            color: #000;
            position: relative;
        }

        .header,
        .section,
        .footer {
            position: relative;
            z-index: 2;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .school-name {
            font-size: 22px;
            font-weight: bold;
            color: #0a1f44;
        }

        .school-address {
            font-size: 12px;
            margin-top: 2px;
        }

        .receipt-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 8px;
            color: #0a1f44;
        }

        .receipt-date {
            font-size: 12px;
            margin-top: 3px;
        }

        .divider {
            border-bottom: 2px solid #0a1f44;
            margin-top: 8px;
        }

        .section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 6px;
            color: #0a1f44;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }

        .detail-group {
            margin-bottom: 4px;
        }

        .detail-label {
            font-weight: bold;
        }

        .amount-paid {
            color: #065f46;
            font-weight: bold;
        }

        .amount-balance {
            color: #b91c1c;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 25px;
        }

        .footer {
            margin-top: 12px;
            font-size: 11px;
            text-align: center;
            color: #444;
        }

        .print-toolbar {
            text-align: center;
            margin-bottom: 15px;
        }

        .print-toolbar button {
            background: #0a1f44;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        @media print {
            body {
                margin: 10mm;
            }

            .section {
                page-break-inside: avoid;
            }

            .print-toolbar {
                display: none;
            }
        }
    </style>
</head>

<body>

    @if (!$forPdf)
        <div class="print-toolbar">
            <button onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
        </div>
    @endif

    <div class="header">
        <div class="school-name">EDMOL MEMORIAL MATADI BAPTIST HIGH SCHOOL</div>
        <div class="school-address">New Matadi Estate Drive, Opposite Don Bosco Youth Center</div>
        <div class="school-address">P.O. Box: 4330 Monrovia, Liberia</div>
        <div class="school-address">Email: emmmbhs@gmail.com</div>
        <div class="school-address">0777-151-394 | 0771-761-098 | 0555-472-972</div>
        <div class="receipt-title">OFFICIAL STUDENT FEE RECEIPT</div>
        <div class="receipt-date">Date: {{ $payment->payment_date->format('M d, Y') }}</div>
        <div class="divider"></div>
    </div>

    <div class="section">
        <div class="section-title">Receipt Details</div>
        <div class="detail-grid">
            <div class="detail-group"><span class="detail-label">Receipt Number:</span> {{ $payment->receipt_number }}
            </div>
            <div class="detail-group"><span class="detail-label">Payment Date:</span>
                {{ $payment->payment_date->format('M d, Y') }}</div>
            <div class="detail-group"><span class="detail-label">Student:</span>
                {{ $payment->feeAssignment->student->name }}</div>
            <div class="detail-group"><span class="detail-label">Student ID:</span>
                {{ $payment->feeAssignment->student->student_id }}</div>
            <div class="detail-group"><span class="detail-label">Academic Year:</span>
                {{ $payment->feeAssignment->academic_year }}</div>
            <div class="detail-group"><span class="detail-label">Fee Category:</span>
                {{ $payment->feeAssignment->feeCategory->name }}</div>
            <div class="detail-group"><span class="detail-label">Payment Method:</span> {{ $payment->payment_method }}
            </div>
            <div class="detail-group"><span class="detail-label">Reference Number:</span>
                {{ $payment->reference_number ?: '—' }}</div>
            <div class="detail-group"><span class="detail-label">Amount Paid:</span> <span
                    class="amount-paid">${{ number_format($payment->amount_paid, 2) }}</span></div>
            <div class="detail-group"><span class="detail-label">Remaining Balance:</span> <span
                    class="amount-balance">${{ number_format($payment->feeAssignment->balance(), 2) }}</span></div>
            <div class="detail-group"><span class="detail-label">Recorded By:</span>
                {{ $payment->recordedBy?->name ?? '—' }}</div>
        </div>
        @if ($payment->remarks)
            <div class="detail-group" style="margin-top: 8px;">
                <span class="detail-label">Remarks:</span> {{ $payment->remarks }}
            </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Authorization</div>
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>School Bursar / Accountant
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>Authorized Signature
            </div>
        </div>
    </div>

    <div class="footer">
        <div>Printed on {{ now()->format('M d, Y') }} at {{ now()->format('h:i A') }}</div>
        <div>This document is system-generated and valid without a stamp.</div>
    </div>

</body>

</html>
