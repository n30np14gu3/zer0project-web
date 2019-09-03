<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompleteRegister extends Mailable
{
    use Queueable, SerializesModels;

    private $_confirm_link;
    private $_title;
    private $_header;

    /**
     * Create a new message instance.
     *
     *
     * @param $confirm_link
     * @param $title
     * @param $header
     */
    public function __construct($confirm_link, $title, $header)
    {
        $this->_confirm_link = $confirm_link;
        $this->_title = $title;
        $this->_header = $header;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ЗАВЕРШЕНИЕ РЕГИСТРАЦИИ')->from(env('MAIL_USERNAME'), env('MAIL_NAME'))->view('emails.register-complete')->with([
            'mail_title' => $this->_title,
            'mail_header' => $this->_header,
            'confirm_link' => $this->_confirm_link
        ]);
    }
}
