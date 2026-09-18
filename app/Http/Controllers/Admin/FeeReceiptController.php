<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeePayment;
use App\Models\Student;
use App\Services\SchoolDocumentBranding;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FeeReceiptController extends Controller
{
    public function show(FeePayment $payment): View
    {
        $this->authorize('view fee details');

        $payment->load(['feeAssignment.enrollment.student.user', 'feeAssignment.feeCategory', 'recordedBy']);

        $this->assertSameSchool($payment->feeAssignment->school_id);

        $branding = SchoolDocumentBranding::for($payment->feeAssignment->school_id);

        return view('admin.fees.receipt', [
            'payment' => $payment,
            'branding' => $branding,
            'documentTitle' => SchoolDocumentBranding::title($branding, 'receipt', 'OFFICIAL STUDENT FEE RECEIPT'),
            'documentCaption' => SchoolDocumentBranding::caption($branding, 'receipt', ''),   // NEW
            'forPdf' => false,
        ]);
    }

    public function downloadPdf(FeePayment $payment): Response
    {
        $this->authorize('view fee details');

        $payment->load(['feeAssignment.enrollment.student.user', 'feeAssignment.feeCategory', 'recordedBy']);

        $this->assertSameSchool($payment->feeAssignment->school_id);

        $branding = SchoolDocumentBranding::for($payment->feeAssignment->school_id);

        $pdf = Pdf::loadView('admin.fees.receipt', [
            'payment' => $payment,
            'branding' => $branding,
            'documentTitle' => SchoolDocumentBranding::title($branding, 'receipt', 'OFFICIAL STUDENT FEE RECEIPT'),
            'documentCaption' => SchoolDocumentBranding::caption($branding, 'receipt', ''),   // NEW
            'forPdf' => true,
        ]);

        return $pdf->download("Receipt-{$payment->receipt_number}.pdf");
    }

    public function statement(Student $student): View
    {
        $this->authorize('view fee details');

        $this->assertSameSchool($student->school_id);

        $student->load('enrollment.grade');

        $assignments = $student->enrollment
            ? \App\Models\FeeAssignment::where('enrollment_id', $student->enrollment->id)
            ->with(['feeCategory', 'payments'])
            ->orderByDesc('due_date')
            ->get()
            : collect();

        $branding = SchoolDocumentBranding::for($student->school_id);

        return view('admin.fees.statement', [
            'student' => $student,
            'assignments' => $assignments,
            'branding' => $branding,
            'documentTitle' => SchoolDocumentBranding::title($branding, 'statement', 'STUDENT FEE STATEMENT'),
            'documentCaption' => SchoolDocumentBranding::caption($branding, 'statement', ''),   // NEW
            'forPdf' => false,
        ]);
    }

    public function downloadStatementPdf(Student $student): Response
    {
        $this->authorize('view fee details');

        $this->assertSameSchool($student->school_id);

        $student->load('enrollment.grade');

        $assignments = $student->enrollment
            ? \App\Models\FeeAssignment::where('enrollment_id', $student->enrollment->id)
            ->with(['feeCategory', 'payments'])
            ->orderByDesc('due_date')
            ->get()
            : collect();

        $branding = SchoolDocumentBranding::for($student->school_id);

        $pdf = Pdf::loadView('admin.fees.statement', [
            'student' => $student,
            'assignments' => $assignments,
            'branding' => $branding,
            'documentTitle' => SchoolDocumentBranding::title($branding, 'statement', 'STUDENT FEE STATEMENT'),
            'documentCaption' => SchoolDocumentBranding::caption($branding, 'statement', ''),   // NEW
            'forPdf' => true,
        ]);

        return $pdf->download("Fee-Statement-{$student->user->registration_id}.pdf");
    }

    /**
     * Tenant guard — a school admin may only ever view/print/download
     * documents belonging to their own school_id. Platform Admins
     * all (the UI hides the link for them), but this still fails safe
     * rather than silently trusting the URL.
     */
    protected function assertSameSchool(?int $documentSchoolId): void
    {
        $userSchoolId = auth()->user()->school_id;

        if ($userSchoolId !== null && $documentSchoolId !== $userSchoolId) {
            abort(403);
        }
    }
}
