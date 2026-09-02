<?php

namespace App\Mail;

use App\Models\DisciplinaryRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisciplinaryCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DisciplinaryRecord $disciplinaryRecord)
    {
    }

    public function build(): self
    {
        return $this->subject('Disciplinary Notice - Case Closed')
            ->view('emails.disciplinary.cancelled');
    }
}
