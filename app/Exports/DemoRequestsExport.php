<?php

namespace App\Exports;

use App\Models\DemoRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DemoRequestsExport extends DefaultValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithCustomValueBinder
{
    public function __construct(
        private ?string $search = null,
        private ?string $status = null,
    ) {}

    public function query()
    {
        return DemoRequest::query()
            ->search($this->search)
            ->withStatus($this->status)
            ->orderByDesc('created_at');
    }

    public function headings(): array
    {
        return [
            'Reference',
            'Received',
            'Status',
            'Full name',
            'Email',
            'School',
            'WhatsApp',
            'City',
            'Category',
            'Address',
            'Preferred date',
            'Preferred time (GMT)',
            'Message',
            'Admin notes',
        ];
    }

    public function map($request): array
    {
        return [
            $request->reference,
            $request->created_at?->format('Y-m-d H:i'),
            $request->status_label,
            $request->full_name,
            $request->email,
            $request->school_name,
            $request->whatsapp_number,
            $request->city,
            $request->category_label,
            $request->school_address,
            $request->preferred_date?->format('Y-m-d'),
            $request->time_label,
            $request->message,
            $request->admin_notes,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Write every text value as a literal string. This keeps phone numbers
     * intact (no scientific notation / lost zeros) and, more importantly,
     * stops text typed into the public form (e.g. "=HYPERLINK(...)") from
     * being interpreted as an Excel formula when the admin opens the file.
     */
    public function bindValue(Cell $cell, $value): bool
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
