<div class="px-2 py-2 space-y-5">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="px-2 py-2 space-y-5">
        @include('partials.notifications')

        <div class="grid grid-cols-1 xl:grid-cols-[340px_1fr] gap-5">

            {{-- ── Report Configuration panel (unchanged) ── --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm self-start">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-800"><i class="fas fa-sliders text-[#155E8A] mr-2"></i>Report
                        Configuration</h2>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase mb-1.5 block">Academic Year</label>
                        <select wire:model="academicYearId"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                            @foreach ($allAcademicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase mb-1.5 block">Grade / Class</label>
                        <select wire:model.live="gradeId"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                            @foreach ($allGrades as $g)
                                <option value="{{ $g->id }}">
                                    {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase mb-1.5 block">Subject</label>
                        <select wire:model="subjectId"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                            @foreach ($allSubjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase mb-1.5 block">Period</label>
                        <select wire:model="periodId"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                            @foreach ($allPeriods as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 uppercase mb-1.5 block">Date Range</label>
                        <input type="date" wire:model="dateFrom"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm mb-2">
                        <input type="date" wire:model="dateTo"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                    </div>
                    <button wire:click="generate"
                        class="w-full py-3 text-sm font-semibold text-white bg-[#155E8A] hover:bg-[#0F4A6E] rounded-xl">
                        <i class="fas fa-wand-magic-sparkles mr-1"></i> Generate Preview
                    </button>
                </div>
            </div>

            {{-- ── Preview area ── --}}
            <div class="space-y-4">
                @if (!$showPreview)
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-16 text-center text-slate-400">
                        <i class="fas fa-file-lines text-3xl mb-3 block"></i> Choose your filters and click Generate
                        Preview.
                    </div>
                @else
                    <div class="flex justify-end no-print">
                        <button onclick="window.print()"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#155E8A] rounded-xl">
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
                                    $period->name,
                                'documentDate' => $documentDate,
                            ])

                            <div class="overflow-x-auto">
                                <table class="w-full text-xs border-collapse">
                                    <thead>
                                        <tr class="bg-[#155E8A] text-white">
                                            <th
                                                class="border border-slate-300 px-2 py-2 text-left sticky left-0 bg-[#155E8A] min-w-[160px]">
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
                                                    <th class="border border-slate-300 px-1 py-1 text-center">
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
                                                                default => 'Null',
                                                            };
                                                            $color = match ($status) {
                                                                'present' => 'text-green-700',
                                                                'absent' => 'text-red-600',
                                                                'late' => 'text-amber-600',
                                                                default => 'text-slate-300',
                                                            };
                                                        @endphp
                                                        <td
                                                            class="border border-slate-300 px-1 py-2 text-center font-bold {{ $color }}">
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

                            <div
                                class="px-8 py-3 bg-slate-50 border-t border-slate-100 flex items-center gap-6 text-xs text-slate-500 flex-wrap">
                                <span><strong class="text-green-700">P</strong> = Present</span>
                                <span><strong class="text-red-600">A</strong> = Absent</span>
                                <span><strong class="text-amber-600">L</strong> = Late</span>
                                <span>— = No record</span>
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

            @media print {
                body * {
                    visibility: hidden;
                }

                #print-preview,
                #print-preview * {
                    visibility: visible;
                }

                #print-preview {
                    position: fixed;
                    inset: 0;
                    padding: 10mm;
                    background: white;
                    overflow: visible;
                }

                .no-print {
                    display: none !important;
                }

                .attendance-doc table {
                    page-break-inside: auto;
                }

                .attendance-doc tr {
                    page-break-inside: avoid;
                }
            }
        </style>
    @endif
</div>
