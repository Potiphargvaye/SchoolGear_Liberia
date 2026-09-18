<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Receipt {{ $payment->receipt_number }} — {{ $branding['name'] }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 15px;
            font-size: 12px;
            color: #1e293b;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .logo-cell {
            width: 70px;
        }

        .logo-cell img {
            height: 60px;
            width: 60px;
            object-fit: contain;
        }

        .header-text-cell {
            text-align: center;
            padding-left: 10px;
        }

        .school-name {
            font-size: 19px;
            font-weight: bold;
            color: #0a1f44;
            line-height: 1.3;
        }

        .school-address {
            font-size: 10.5px;
            margin-top: 2px;
            color: #475569;
        }

        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 6px;
            color: #0a1f44;
            letter-spacing: 0.5px;
        }

        .receipt-caption {
            font-size: 10.5px;
            color: #64748B;
            margin-top: 2px;
        }

        .receipt-date {
            font-size: 11px;
            margin-top: 3px;
            color: #475569;
        }

        .divider {
            border-bottom: 3px solid #B91C1C;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .section {
            border: 1px solid #E2E8F0;
            padding: 10px 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 8px;
            color: #0a1f44;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 5px;
        }

        .receipt-number-badge {
            background: #0a1f44;
            color: #fff;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 6px;
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
            color: #334155;
        }

        .amount-paid {
            color: #15803d;
            font-weight: bold;
        }

        .amount-balance {
            color: #B91C1C;
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
            font-size: 11px;
            color: #475569;
        }

        .signature-line {
            border-top: 1px solid #334155;
            margin-top: 25px;
        }

        .footer-contact {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #E2E8F0;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            padding: 0 10px;
            vertical-align: top;
            font-size: 10.5px;
            color: #475569;
            width: 33.33%;
        }

        .footer-label {
            font-weight: bold;
            color: #0a1f44;
            font-size: 11px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 3px;
        }

        .footer {
            margin-top: 12px;
            font-size: 10.5px;
            text-align: center;
            color: #64748B;
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

        .print-toolbar button:hover {
            background: #0a1f44;
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

    @include('partials.documents.header', ['documentDate' => $payment->payment_date->format('M d, Y')])

    <div class="section">
        <div class="section-title">
            Receipt <span class="receipt-number-badge">{{ $payment->receipt_number }}</span>
        </div>
        <div class="detail-grid">
            <div class="detail-group"><span class="detail-label">Payment Date:</span>
                {{ $payment->payment_date->format('M d, Y') }}</div>
            <div class="detail-group"><span class="detail-label">Student:</span>
                {{ $payment->feeAssignment->enrollment->student->name }}</div>
            <div class="detail-group"><span class="detail-label">Student ID:</span>
                {{ $payment->feeAssignment->enrollment->student->user->registration_id }}</div>
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

    @include('partials.documents.footer')

</body>

</html>
