<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Statement — {{ $student->name }} — {{ $branding['name'] }}</title>
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
            color: #0B3A57;
            letter-spacing: 0.5px;
        }

        .receipt-caption {
            font-size: 10.5px;
            color: #64748B;
            margin-top: 2px;
        }

        .divider {
            border-bottom: 3px solid #B91C1C;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .student-info {
            margin-bottom: 12px;
            font-size: 12px;
            color: #334155;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 4px;
            padding: 8px 10px;
        }

        .student-info strong {
            color: #0a1f44;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th {
            background: #0a1f44;
            color: #fff;
            text-align: left;
            padding: 6px 8px;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-top: 10px;
            text-align: right;
            font-size: 13px;
            color: #334155;
        }

        .summary .balance {
            color: #B91C1C;
            font-weight: bold;
            font-size: 15px;
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
            color: #0a1f44;
        }

        .print-toolbar {
            text-align: center;
            margin-bottom: 15px;
        }

        .print-toolbar button {
            background: #155E8A;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
        }

        .print-toolbar button:hover {
            background: #0B3A57;
        }

        @media print {
            .print-toolbar {
                display: none;
            }
        }
    </style>
</head>

<body>

    @if (!$forPdf)
        <div class="print-toolbar">
            <button onclick="window.print()"><i class="fas fa-print"></i> Print Statement</button>
        </div>
    @endif

    @include('partials.documents.header')

    <div class="student-info">
        <strong>Student:</strong> {{ $student->name }} &nbsp;|&nbsp;
        <strong>Student ID:</strong> {{ $student->user->registration_id }} &nbsp;|&nbsp;
        <strong>Grade:</strong> {{ $student->enrollment?->grade?->level }}
        {{ $student->enrollment?->grade?->section ?? '—' }} &nbsp;|&nbsp;
        <strong>Statement Date:</strong> {{ now()->format('M d, Y') }}
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Academic Year</th>
                <th>Fee Category</th>
                <th>Installment</th>
                <th>Due Date</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Paid</th>
                <th class="text-right">Balance</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandAmount = 0;
                $grandPaid = 0;
            @endphp
            @forelse ($assignments as $assignment)
                @php
                    $paid = $assignment->payments->sum('amount_paid');
                    $balance = $assignment->amount - $paid;
                    $grandAmount += $assignment->amount;
                    $grandPaid += $paid;
                @endphp
                <tr>
                    <td>{{ $assignment->academic_year }}</td>
                    <td>{{ $assignment->feeCategory->name }}</td>
                    <td>{{ $assignment->installment_number ?: '—' }}</td>
                    <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                    <td class="text-right">${{ number_format($assignment->amount, 2) }}</td>
                    <td class="text-right">${{ number_format($paid, 2) }}</td>
                    <td class="text-right">${{ number_format($balance, 2) }}</td>
                    <td class="text-center">{{ ucfirst($assignment->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No fee assignments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div>Total Assigned: ${{ number_format($grandAmount, 2) }}</div>
        <div>Total Paid: ${{ number_format($grandPaid, 2) }}</div>
        <div class="balance">Outstanding Balance: ${{ number_format($grandAmount - $grandPaid, 2) }}</div>
    </div>

    @include('partials.documents.footer')

</body>

</html>
