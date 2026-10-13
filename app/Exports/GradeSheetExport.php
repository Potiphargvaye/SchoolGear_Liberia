<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradeSheetExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithCustomValueBinder
{
    private int $rowNumber = 0;

    /**
     * @param Collection $enrollments  Active enrollments shown on the sheet (with student.user loaded)
     * @param Collection $subjects     Subjects shown on the sheet (already Teacher-scoped)
     * @param Collection $grades       StudentGrade records keyed "enrollmentId-subjectId"
     */
    public function __construct(
        private Collection $enrollments,
        private Collection $subjects,
        private Collection $grades,
        private string $gradeLabel,
        private string $academicYearName,
    ) {}

    public function collection()
    {
        return $this->enrollments->values();
    }

    public function headings(): array
    {
        $headings = ['#', 'Student Name', 'Registration ID', 'Grade', 'Academic Year'];

        foreach ($this->subjects as $subject) {
            foreach (['P1', 'P2', 'P3', '1st Exam', '1st Avg', 'P4', 'P5', 'P6', '2nd Exam', '2nd Avg', 'Year Avg'] as $column) {
                $headings[] = $subject->name . ' - ' . $column;
            }
        }

        return $headings;
    }

    public function map($enrollment): array
    {
        $row = [
            ++$this->rowNumber,
            $enrollment->student->name,
            $enrollment->student->user->registration_id ?? '',
            $this->gradeLabel,
            $this->academicYearName,
        ];

        foreach ($this->subjects as $subject) {
            $g = $this->grades->get($enrollment->id . '-' . $subject->id);

            // No grade record saved for this student + subject: leave blank.
            if (! $g) {
                array_push($row, null, null, null, null, null, null, null, null, null, null, null);
                continue;
            }

            // Same formulas as the sheet's live calculation (blank counts as 0).
            $sem1 = round(((($g->period1 + $g->period2 + $g->period3) / 3) + $g->exam1) / 2);
            $sem2 = round(((($g->period4 + $g->period5 + $g->period6) / 3) + $g->exam2) / 2);
            $year = round(($sem1 + $sem2) / 2, 2);

            array_push(
                $row,
                $g->period1,
                $g->period2,
                $g->period3,
                $g->exam1,
                $sem1,
                $g->period4,
                $g->period5,
                $g->period6,
                $g->exam2,
                $sem2,
                $year
            );
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Text is written as a literal string (no formula interpretation);
     * numbers stay numeric so grades remain usable in Excel.
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
