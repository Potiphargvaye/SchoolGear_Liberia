<?php

namespace App\Livewire\Public;

use App\Mail\DemoRequestAdminAlert;
use App\Mail\DemoRequestReceived;
use App\Models\DemoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Component;

class BookDemo extends Component
{
    public string $full_name = '';
    public string $email = '';
    public string $school_name = '';
    public string $whatsapp_number = '';
    public string $city = '';
    public string $school_category = '';
    public string $school_address = '';
    public string $preferred_date = '';
    public string $preferred_time = '';
    public string $message = '';

    /** Honeypot: hidden from people, bots tend to fill it in. */
    public string $website = '';

    public bool $submitted = false;
    public bool $emailSent = false;
    public array $summary = [];

    protected function rules(): array
    {
        return [
            'full_name'       => ['required', 'string', 'max:120'],
            'email'           => ['required', 'email:rfc', 'max:150'],
            'school_name'     => ['required', 'string', 'max:150'],
            'whatsapp_number' => ['required', 'string', 'regex:/^\+?[0-9\s\-()]{7,20}$/'],
            'city'            => ['required', 'string', 'max:100'],
            'school_category' => ['required', Rule::in(array_keys(DemoRequest::CATEGORIES))],
            'school_address'  => ['required', 'string', 'max:255'],
            'preferred_date'  => [
                'required',
                'date',
                'after:today',
                'before_or_equal:' . now()->addDays(90)->toDateString(),
            ],
            'preferred_time'  => ['required', Rule::in(array_keys(DemoRequest::TIME_SLOTS))],
            'message'         => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'full_name'       => 'full name',
            'school_name'     => 'school name',
            'whatsapp_number' => 'WhatsApp number',
            'city'            => 'city',
            'school_category' => 'school category',
            'school_address'  => 'school address',
            'preferred_date'  => 'preferred date',
            'preferred_time'  => 'preferred time',
        ];
    }

    protected function messages(): array
    {
        return [
            'whatsapp_number.regex'  => 'Enter a valid WhatsApp number with the country code, for example +231 77 000 0000.',
            'preferred_date.after'   => 'Choose a date from tomorrow onward.',
            'preferred_date.before_or_equal' => 'Choose a date within the next 90 days.',
            'school_category.in'     => 'Choose Primary or Secondary.',
            'preferred_time.in'      => 'Choose one of the available time slots.',
        ];
    }

    public function submit(): void
    {
        // Real visitors never see this field. Drop bot submissions silently.
        if ($this->website !== '') {
            return;
        }

        $this->validate();

        $limiterKey = 'book-demo:' . request()->ip();

        if (RateLimiter::tooManyAttempts($limiterKey, 5)) {
            $this->addError('form', 'Too many requests from this device. Try again later, or message us on WhatsApp.');

            return;
        }

        RateLimiter::hit($limiterKey, 3600);

        $demo = DemoRequest::create([
            'full_name'       => trim($this->full_name),
            'email'           => trim($this->email),
            'whatsapp_number' => trim($this->whatsapp_number),
            'school_name'     => trim($this->school_name),
            'city'            => trim($this->city),
            'school_category' => $this->school_category,
            'school_address'  => trim($this->school_address),
            'preferred_date'  => $this->preferred_date,
            'preferred_time'  => $this->preferred_time,
            'message'         => trim($this->message) !== '' ? trim($this->message) : null,
            'status'          => 'pending',
        ]);

        // The request is already saved. A mail failure must never lose it.
        $this->emailSent = $this->sendMail($demo->email, new DemoRequestReceived($demo));
        $this->sendMail(config('mail.demo_notify_address'), new DemoRequestAdminAlert($demo));

        $this->summary = [
            'reference' => $demo->reference,
            'school'    => $demo->school_name,
            'date'      => $demo->preferred_date->format('l, j F Y'),
            'time'      => $demo->time_label . ' (GMT)',
            'email'     => $demo->email,
        ];

        $this->submitted = true;
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->resetErrorBag();
    }

    private function sendMail(?string $to, $mailable): bool
    {
        if (! $to) {
            return false;
        }

        try {
            Mail::to($to)->send($mailable);

            return true;
        } catch (\Throwable $e) {
            Log::error('Demo request email failed', ['to' => $to, 'error' => $e->getMessage()]);

            return false;
        }
    }

    public function render()
    {
        return view('livewire.public.book-demo', [
            'timeSlots'  => DemoRequest::TIME_SLOTS,
            'categories' => DemoRequest::CATEGORIES,
        ]);
    }
}
