<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FeeReceiptController extends Controller
{
    /**
     * View/print a single payment's receipt in the browser.
     * A receipt is a static document, not an interactive component, so
     * this stays a classic controller+Blade rather than Livewire.
     */
    public function show(FeePayment $payment): View
    {
        $this->authorize('view fee details');

        $payment->load(['feeAssignment.student', 'feeAssignment.feeCategory', 'recordedBy']);

        return view('admin.fees.receipt', [
            'payment' => $payment,
            'forPdf' => false,
        ]);
    }

    /**
     * Download the same receipt as a PDF.
     * Requires: composer require barryvdh/laravel-dompdf
     */
    public function downloadPdf(FeePayment $payment): Response
    {
        $this->authorize('view fee details');

        $payment->load(['feeAssignment.student', 'feeAssignment.feeCategory', 'recordedBy']);

        $pdf = Pdf::loadView('admin.fees.receipt', [
            'payment' => $payment,
            'forPdf' => true,
        ]);

        return $pdf->download("Receipt-{$payment->receipt_number}.pdf");
    }

    /**
     * Fee Statement (optional, per the requirements) — a full listing of
     * every assignment/payment/balance for one student, viewable and
     * downloadable the same way as an individual receipt.
     */
    public function statement(Student $student): View
    {
        $this->authorize('view fee details');

        $assignments = $student->feeAssignments()
            ->with(['feeCategory', 'payments'])
            ->orderByDesc('due_date')
            ->get();

        return view('admin.fees.statement', [
            'student' => $student,
            'assignments' => $assignments,
            'forPdf' => false,
        ]);
    }

    public function downloadStatementPdf(Student $student): Response
    {
        $this->authorize('view fee details');

        $assignments = $student->feeAssignments()
            ->with(['feeCategory', 'payments'])
            ->orderByDesc('due_date')
            ->get();

        $pdf = Pdf::loadView('admin.fees.statement', [
            'student' => $student,
            'assignments' => $assignments,
            'forPdf' => true,
        ]);

        return $pdf->download("Fee-Statement-{$student->student_id}.pdf");
    }
}
