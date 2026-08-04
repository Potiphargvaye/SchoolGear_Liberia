<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithHeadings, WithMapping
{


    protected $status;
    protected $search;
    protected $intake;
    protected $shift;

    public function __construct($status = null, $search = null, $intake = null, $shift = null)
    {
        $this->status = $status;
        $this->search = $search;
        $this->intake = $intake;
        $this->shift = $shift;
    }

    public function collection()
    {
        $query = Student::query();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('student_id', 'like', "%{$this->search}%");
            });
        }

        if ($this->intake) {
            $query->where('intake', $this->intake);
        }

        if ($this->shift) {
            $query->where('shift', $this->shift);
        }

        return $query->get();
    }

    
    /**
     * Define the Excel header row
     */
    public function headings(): array
    {
        return [
            'Student ID',
            'Image',
            'Name',
            'Age',
            'Gender',
            'Parent Phone',
            'Transcript',
            'Recommendation Letter',
            'Class Applying For',
            'Date of Admission',
            'Status',
            'Shift',
            'Intake',
            'Grade ID',
            'Last School Attended',
            'Student Type'
        ];
    }

    /**
     * Map each student to the Excel row
     */
    public function map($student): array
    {
        return [
            $student->student_id,
            $student->image, // or just basename($student->image)
            $student->name,
            $student->age,
            $student->gender,
            $student->parent_phone,
            $student->transcript, // filename or URL
            $student->recommendation_letter, // filename or URL
            $student->class_applying_for,
            $student->date_of_admission,
            $student->status,
            $student->shift,
            $student->intake,
            $student->grade_id,
            $student->last_school_attended,
            $student->student_type
        ];
    }
}
