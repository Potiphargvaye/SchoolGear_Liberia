<div class="min-w-0 max-w-full space-y-5 overflow-x-clip px-2 py-2 text-slate-800 dark:text-slate-200">
    <div class="no-print">
        @include('livewire.admin.attendance.partials.nav-tabs')
    </div>

    <div class="min-w-0 space-y-5">
        <div class="no-print">
            @include('partials.notifications')
        </div>

        <div class="grid min-w-0 grid-cols-1 gap-4 xl:grid-cols-[340px_minmax(0,1fr)] xl:gap-5">

            {{-- ── Report Configuration panel (unchanged) ── --}}
            <div class="no-print min-w-0 self-start rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="border-b border-slate-100 px-3 py-4 dark:border-slate-700 sm:px-5">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100"><i class="fas fa-sliders text-[#155E8A] mr-2"></i>Report
                        Configuration</h2>
                </div>
                <div class="space-y-4 p-3 sm:p-5">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase text-slate-700 dark:text-slate-300">Academic Year</label>
                        <select wire:model="academicYearId"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                            @foreach ($allAcademicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase text-slate-700 dark:text-slate-300">Grade / Class</label>
                        <select wire:model.live="gradeId"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                            @foreach ($allGrades as $g)
                                <option value="{{ $g->id }}">
                                    {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase text-slate-700 dark:text-slate-300">Subject</label>
                        <select wire:model="subjectId"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                            @foreach ($allSubjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase text-slate-700 dark:text-slate-300">Period</label>
                        <select wire:model="periodId"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                            @foreach ($allPeriods as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase text-slate-700 dark:text-slate-300">Date Range</label>
                        <input type="date" wire:model="dateFrom"
                            class="mb-2 min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <input type="date" wire:model="dateTo"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                    </div>
                    <button wire:click="generate"
                        class="min-h-11 w-full rounded-xl bg-[#155E8A] py-3 text-sm font-semibold text-white hover:bg-[#0F4A6E] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                        <i class="fas fa-wand-magic-sparkles mr-1"></i> Generate Preview
                    </button>
                </div>
            </div>

            {{-- ── Preview area ── --}}
            <div class="space-y-4">
                @if (!$showPreview)
                    <div class="no-print rounded-xl border border-slate-200 bg-white p-8 text-center text-slate-600 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 sm:p-16">
                        <i class="fas fa-file-lines text-3xl mb-3 block"></i> Choose your filters and click Generate
                        Preview.
                    </div>
                @else
                    <div class="flex justify-end no-print">
                        <button onclick="window.print()"
                            class="min-h-11 rounded-xl bg-[#155E8A] px-4 py-2 text-sm font-semibold text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                    </div>

                    <div id="print-preview"
                        class="attendance-doc bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="doc-body">

                            @include('partials.documents.header', [
                                'documentTitle' => 'Attendance Register',
                                'documentCaption' =>
                                    $grade->level .
                                    ($grade->section ? ' - ' . $grade->section : '') .
                                    ' · ' .
                                    $subject->name .
                                    ' · ' .
                                    $period->name .
                                    ' · ' .
                                    ($allAcademicYears->firstWhere('id', $academicYearId)?->name ?? ''),
                                'documentDate' => $documentDate,
                            ])

                            <div class="attendance-register-scroll max-w-full overflow-x-auto">
                                <table class="attendance-register-table w-full border-collapse text-xs">
                                    <thead>
                                        <tr class="bg-[#155E8A] text-white">
                                            <th
                                                class="sticky left-0 min-w-[160px] border border-slate-300 bg-[#155E8A] px-2 py-2 text-left">
                                                Student
                                            </th>
                                            @foreach ($weeks as $weekLabel => $weekDates)
                                                <th colspan="{{ $weekDates->count() }}"
                                                    class="border border-slate-300 px-2 py-2 text-center">
                                                    {{ $weekLabel }}
                                                </th>
                                            @endforeach
                                            <th class="border border-slate-300 px-2 py-2 text-center">P</th>
                                            <th class="border border-slate-300 px-2 py-2 text-center">A</th>
                                            <th class="border border-slate-300 px-2 py-2 text-center">L</th>
                                            <th class="border border-slate-300 px-2 py-2 text-center">Rate</th>
                                        </tr>
                                        <tr class="bg-slate-100 text-slate-600">
                                            <th class="border border-slate-300 px-2 py-1 sticky left-0 bg-slate-100">
                                            </th>
                                            @php $dayLetters = ['S', 'M', 'T', 'W', 'T', 'F', 'S']; @endphp
                                            @foreach ($weeks as $weekDates)
                                                @foreach ($weekDates as $date)
                                                    <th class="attendance-day-cell border border-slate-300 px-1 py-1 text-center">
                                                        {{ $date->format('d') }} {{ $dayLetters[$date->dayOfWeek] }}
                                                    </th>
                                                @endforeach
                                            @endforeach
                                            <th class="border border-slate-300"></th>
                                            <th class="border border-slate-300"></th>
                                            <th class="border border-slate-300"></th>
                                            <th class="border border-slate-300"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rows as $row)
                                            <tr>
                                                <td
                                                    class="border border-slate-300 px-2 py-2 font-semibold sticky left-0 bg-white">
                                                    {{ $row['enrollment']->student->name }}
                                                </td>
                                                @foreach ($weeks as $weekDates)
                                                    @foreach ($weekDates as $date)
                                                        @php
                                                            $status = $row['cells'][$date->toDateString()] ?? null;
                                                            $letter = match ($status) {
                                                                'present' => 'P',
                                                                'absent' => 'A',
                                                                'late' => 'L',
                                                                default => 'NR',
                                                            };
                                                            $color = match ($status) {
                                                                'present' => 'text-green-700',
                                                                'absent' => 'text-red-700',
                                                                'late' => 'text-amber-700',
                                                                default => 'text-slate-600',
                                                            };
                                                        @endphp
                                                        <td
                                                            class="attendance-day-cell border border-slate-300 px-1 py-2 text-center font-bold {{ $color }}">
                                                            {{ $letter }}
                                                        </td>
                                                    @endforeach
                                                @endforeach
                                                <td
                                                    class="border border-slate-300 px-2 py-2 text-center text-green-700 font-bold">
                                                    {{ $row['present'] }}
                                                </td>
                                                <td
                                                    class="border border-slate-300 px-2 py-2 text-center text-red-600 font-bold">
                                                    {{ $row['absent'] }}
                                                </td>
                                                <td
                                                    class="border border-slate-300 px-2 py-2 text-center text-amber-600 font-bold">
                                                    {{ $row['late'] }}
                                                </td>
                                                <td
                                                    class="border border-slate-300 px-2 py-2 text-center text-[#155E8A] font-bold">
                                                    {{ $row['rate'] }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @php
                                $printColumns = $rows->chunk(max(1, (int) ceil($rows->count() / 2)));
                            @endphp
                            <div class="attendance-print-register">
                                @forelse ($printColumns as $printRows)
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                @foreach ($weeks as $weekDates)
                                                    @foreach ($weekDates as $date)
                                                        <th class="attendance-print-day">{{ $date->format('d') }}</th>
                                                    @endforeach
                                                @endforeach
                                                <th class="attendance-print-total">P</th>
                                                <th class="attendance-print-total">A</th>
                                                <th class="attendance-print-total">L</th>
                                                <th class="attendance-print-total">Rate</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($printRows as $row)
                                                <tr>
                                                    <td class="attendance-print-student">{{ $row['enrollment']->student->name }}</td>
                                                    @foreach ($weeks as $weekDates)
                                                        @foreach ($weekDates as $date)
                                                            @php
                                                                $status = $row['cells'][$date->toDateString()] ?? null;
                                                                $letter = match ($status) {
                                                                    'present' => 'P',
                                                                    'absent' => 'A',
                                                                    'late' => 'L',
                                                                    default => 'NR',
                                                                };
                                                            @endphp
                                                            <td class="attendance-print-day">{{ $letter }}</td>
                                                        @endforeach
                                                    @endforeach
                                                    <td class="attendance-print-total">{{ $row['present'] }}</td>
                                                    <td class="attendance-print-total">{{ $row['absent'] }}</td>
                                                    <td class="attendance-print-total">{{ $row['late'] }}</td>
                                                    <td class="attendance-print-total">{{ $row['rate'] }}%</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @empty
                                    <p>No students in this register.</p>
                                @endforelse
                            </div>

                            <div
                                class="px-8 py-3 bg-slate-50 border-t border-slate-100 flex items-center gap-6 text-xs text-slate-500 flex-wrap">
                                <span><strong class="text-green-700">P</strong> = Present</span>
                                <span><strong class="text-red-600">A</strong> = Absent</span>
                                <span><strong class="text-amber-600">L</strong> = Late</span>
                                <span><strong class="text-slate-500">NR</strong> = No record</span>
                            </div>

                            <div class="section" style="margin: 16px 32px;">
                                <div class="signature-section">
                                    <div class="signature-box">
                                        <div class="signature-line"></div>Class Teacher
                                    </div>
                                    <div class="signature-box">
                                        <div class="signature-line"></div>Administrator
                                    </div>
                                </div>
                            </div>

                            @include('partials.documents.footer')
                            <div class="attendance-print-by">Printed by {{ auth()->user()->name }} · {{ now()->format('M d, Y h:i A') }}</div>

                        </div>{{-- /.doc-body --}}
                    </div>{{-- /.attendance-doc --}}
                @endif
            </div>
        </div>
    </div>

    {{-- Written directly here rather than via @push('styles') — the
         admin layout has no @stack('styles') slot in its <head>, so
         pushed styles were being silently dropped. This block renders
         in place instead, with no dependency on the layout at all. --}}
    @if ($showPreview)
        <style>
            .attendance-doc {
                font-family: Arial, Helvetica, sans-serif;
                color: #1e293b;
                min-width: 0;
            }

            .attendance-doc .doc-body {
                padding: 20px 32px;
            }

            .attendance-doc .header-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 0;
            }

            .attendance-doc .header-table td {
                border: none;
                padding: 0;
                vertical-align: middle;
            }

            .attendance-doc .logo-cell {
                width: 70px;
            }

            .attendance-doc .logo-cell img {
                height: 60px;
                width: 60px;
                object-fit: contain;
            }

            .attendance-doc .header-text-cell {
                text-align: center;
                padding-left: 10px;
            }

            .attendance-doc .school-name {
                font-size: 19px;
                font-weight: bold;
                color: #0a1f44;
                line-height: 1.3;
            }

            .attendance-doc .school-address {
                font-size: 10.5px;
                margin-top: 2px;
                color: #475569;
            }

            .attendance-doc .receipt-title {
                font-size: 14px;
                font-weight: bold;
                margin-top: 6px;
                color: #0a1f44;
                letter-spacing: 0.5px;
            }

            .attendance-doc .receipt-caption {
                font-size: 10.5px;
                color: #64748B;
                margin-top: 2px;
            }

            .attendance-doc .receipt-date {
                font-size: 11px;
                margin-top: 3px;
                color: #475569;
            }

            .attendance-doc .divider {
                border-bottom: 3px solid #B91C1C;
                margin-top: 8px;
                margin-bottom: 14px;
            }

            .attendance-doc .signature-section {
                margin-top: 20px;
                display: flex;
                justify-content: space-between;
            }

            .attendance-doc .signature-box {
                width: 45%;
                text-align: center;
                font-size: 11px;
                color: #475569;
            }

            .attendance-doc .signature-line {
                border-top: 1px solid #334155;
                margin-top: 25px;
                margin-bottom: 6px;
            }

            .attendance-doc .footer-contact {
                margin-top: 24px;
                padding: 0 32px 0;
                padding-top: 12px;
                border-top: 1px solid #E2E8F0;
            }

            .attendance-doc .footer-table {
                width: 100%;
                border-collapse: collapse;
            }

            .attendance-doc .footer-table td {
                border: none;
                padding: 0 10px;
                vertical-align: top;
                font-size: 10.5px;
                color: #475569;
                width: 33.33%;
            }

            .attendance-doc .footer-label {
                font-weight: bold;
                color: #0a1f44;
                font-size: 11px;
                text-transform: uppercase;
                display: block;
                margin-bottom: 3px;
            }

            .attendance-doc .footer {
                margin-top: 12px;
                padding-bottom: 20px;
                font-size: 10.5px;
                text-align: center;
                color: #64748B;
            }

            .attendance-print-by {
                display: none;
            }

            .attendance-print-register {
                display: none;
            }

            @media (max-width: 640px) {

                .attendance-doc .header-table,
                .attendance-doc .header-table tr,
                .attendance-doc .header-table td {
                    display: block;
                    width: 100% !important;
                    text-align: center !important;
                }

                .attendance-doc .logo-cell {
                    margin: 0 auto 8px;
                }

                .attendance-doc .header-text-cell {
                    padding-left: 0;
                }

                .attendance-doc .footer-table,
                .attendance-doc .footer-table tr,
                .attendance-doc .footer-table td {
                    display: block;
                    width: 100% !important;
                    text-align: center !important;
                    margin-bottom: 8px;
                }

                .attendance-doc .signature-section {
                    flex-direction: column;
                    gap: 16px;
                }

                .attendance-doc .signature-box {
                    width: 100%;
                }
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            @media print {
                html,
                body {
                    color-scheme: light;
                    background: #fff !important;
                    color: #000 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }

                body * {
                    visibility: hidden;
                }

                #print-preview,
                #print-preview * {
                    visibility: visible;
                }

                #print-preview {
                    position: fixed !important;
                    inset: 0 !important;
                    width: 100% !important;
                    min-height: 0 !important;
                    padding: 0 !important;
                    border: 0 !important;
                    border-radius: 0 !important;
                    background: #fff !important;
                    box-shadow: none !important;
                    color: #000 !important;
                    overflow: visible !important;
                }

                #print-preview .doc-body {
                    padding: 0 !important;
                }

                #print-preview .header + .footer {
                    display: none !important;
                }

                .no-print {
                    display: none !important;
                }

                .admin-shell .sidebar-menu,
                .admin-shell .sidebar-overlay,
                .admin-shell .navbar-menu,
                .admin-shell .sidebar-toggle,
                .attendance-tabs-scroll,
                #notificationContainer {
                    display: none !important;
                }

                .attendance-doc,
                .attendance-doc * {
                    color: #000 !important;
                    box-shadow: none !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                .attendance-doc .header-table {
                    margin: 0;
                }

                .attendance-doc .logo-cell img {
                    width: 35px;
                    height: 35px;
                }

                .attendance-doc .school-name {
                    font-size: 13px;
                    line-height: 1.1;
                }

                .attendance-doc .school-address,
                .attendance-doc .receipt-caption,
                .attendance-doc .receipt-date {
                    margin-top: 1px;
                    font-size: 7pt;
                    line-height: 1.05;
                }

                .attendance-doc .receipt-title {
                    margin-top: 2px;
                    font-size: 9pt;
                }

                .attendance-doc .divider {
                    margin: 2px 0 4px;
                    border-bottom: 1px solid #000;
                }

                .attendance-register-scroll {
                    display: none !important;
                }

                .attendance-print-register {
                    display: grid !important;
                    width: 100%;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 4mm;
                }

                .attendance-print-register table {
                    width: 100%;
                    table-layout: fixed;
                    border-collapse: collapse;
                    font-size: 8pt;
                    line-height: 1;
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                .attendance-print-register th:first-child,
                .attendance-print-register td:first-child {
                    width: 20mm;
                    max-width: 20mm;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .attendance-print-register .attendance-print-day {
                    width: 2.7mm;
                    max-width: 2.7mm;
                    text-align: center;
                }

                .attendance-print-register .attendance-print-total {
                    width: 7mm;
                    max-width: 7mm;
                    text-align: center;
                }

                .attendance-print-register th,
                .attendance-print-register td {
                    height: 3mm;
                    padding: 0.2mm !important;
                    border-color: #555 !important;
                    font-size: 8pt;
                    line-height: 1;
                }

                .attendance-print-register thead tr {
                    background: #fff !important;
                }

                .attendance-print-register thead {
                    display: table-header-group;
                }

                .attendance-print-register tr {
                    page-break-inside: avoid;
                    break-inside: avoid;
                }

                .attendance-doc .footer-contact {
                    margin-top: 2mm;
                    padding: 1mm 0 0;
                    border-color: #777;
                }

                .attendance-doc .footer-table td,
                .attendance-doc .footer-label {
                    font-size: 6pt;
                }

                .attendance-doc .footer {
                    margin-top: 1mm;
                    padding: 0;
                    font-size: 7pt;
                }

                .attendance-doc .section {
                    margin: 2mm 0 !important;
                }

                .attendance-doc .signature-section {
                    margin-top: 1mm;
                }

                .attendance-doc .signature-box {
                    font-size: 7pt;
                }

                .attendance-doc .signature-line {
                    margin-top: 2mm;
                    margin-bottom: 1mm;
                }

                .attendance-print-by {
                    display: block !important;
                    margin-top: 1mm;
                    text-align: center;
                    font-size: 7pt;
                    color: #000 !important;
                }

                .attendance-doc .border,
                .attendance-doc [class*="border-"] {
                    border-radius: 0 !important;
                }

                .attendance-doc .overflow-x-auto,
                .attendance-doc .overflow-hidden {
                    overflow: visible !important;
                }
            }
        </style>
    @endif
</div>
