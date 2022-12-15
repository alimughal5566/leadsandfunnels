<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $info;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientInfo, $token)
    {
        $this->info = $clientInfo;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgot-password')->subject(config('app.name').' - Password Reset')
            ->with(array("client"=>$this->info, 'token'=>$this->token));
    }
}
