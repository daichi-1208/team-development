<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name,$user_email,$group_name,$invite_url)
    {
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->group_name = $group_name;
        $this->invite_url = $invite_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user_email)
        ->subject('email send success')
        ->view('inviteMail')
        ->with([
            'name' => $this->user_name,
            'group_name' => $this->group_name,
            'invite_url' => $this->invite_url,
        ]);
    }
}
