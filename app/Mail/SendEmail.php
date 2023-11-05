<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $message;
    public $subject;
    protected $receiver_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email,$subject, $message,$receiver_name)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
        $this->receiver_name = $receiver_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->from($this->email, $this->name)
                    ->html(view('contenu/emailMessage',[
                        'customMessage' => $this->message,
                        'name' => $this-> receiver_name,
                    ])->render());
    }
}
