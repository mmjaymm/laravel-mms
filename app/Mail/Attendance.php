<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Attendance extends Mailable
{
    use Queueable, SerializesModels;

    public $attendances;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Emails.attendance')->with(['attendances', $this->attendances]);
        ;
    }
}