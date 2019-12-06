<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Overtime;

class OtInformation extends Mailable
{
    use Queueable, SerializesModels;
    public $overtime;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ids)
    {
        $this->overtime = Overtime::find($ids);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Emails.ot_information')->with(['overtime' => $this->overtime]);
    }
}