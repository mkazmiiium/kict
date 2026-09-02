<?php

namespace App\Mail;

use App\Models\DisciplinaryRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisciplinaryNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public DisciplinaryRecord $disciplinaryRecord)
    {
    }

    public function build(): self
    {
        return $this->subject('Disciplinary Notice - Action Required Within 14 Days')
            ->view('emails.disciplinary.notice');
    }
}
