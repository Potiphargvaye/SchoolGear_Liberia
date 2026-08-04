<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fee Statement — {{ $student->name }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 15px;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .school-name {
            font-size: 20px;
            font-weight: bold;
            color: #0a1f44;
        }

        .school-address {
            font-size: 11px;
            margin-top: 2px;
        }

        .receipt-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 8px;
            color: #0a1f44;
        }

        .divider {
            border-bottom: 2px solid #0a1f44;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .student-info {
            margin-bottom: 12px;
            font-size: 12px;
        }

        .student-info strong {
            color: #0a1f44;
        }

        table {
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
            border-bottom: 1px solid #eee;
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
        }

        .summary .balance {
            color: #b91c1c;
            font-weight: bold;
            font-size: 15px;
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

    <div class="header">
        <div class="school-name">EDMOL MEMORIAL MATADI BAPTIST HIGH SCHOOL</div>
        <div class="school-address">New Matadi Estate Drive, Opposite Don Bosco Youth Center</div>
        <div class="school-address">P.O. Box: 4330 Monrovia, Liberia</div>
        <div class="receipt-title">STUDENT FEE STATEMENT</div>
        <div class="divider"></div>
    </div>

    <div class="student-info">
        <strong>Student:</strong> {{ $student->name }} &nbsp;|&nbsp;
        <strong>Student ID:</strong> {{ $student->student_id }} &nbsp;|&nbsp;
        <strong>Grade:</strong> {{ $student->class_applying_for ?? '—' }} &nbsp;|&nbsp;
        <strong>Statement Date:</strong> {{ now()->format('M d, Y') }}
    </div>

    <table>
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

</body>

</html>
