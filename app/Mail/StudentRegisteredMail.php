<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public Student $student;
    public string $qrCode;

    public function __construct(Student $student, string $qrCode)
    {
        $this->student = $student;
        $this->qrCode = $qrCode;
    }

    public function build()
    {
        return $this->subject('Welcome to Our Institute - Registration Successful')
            ->view('emails.student-registered')
            ->attachData($this->qrCode, 'student-qrcode.png', [
                'mime' => 'image/png',
                'as'   => 'qrcode',
            ]);
    }
}