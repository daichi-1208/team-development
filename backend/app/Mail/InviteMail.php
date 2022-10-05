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
    public function __construct($user,$group,$invite_url,$group_owner)
    {
        $this->user = $user;
        $this->owner = $group_owner;
        $this->group = $group;
        $this->invite_url = $invite_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
        ->subject('招待メール')
        ->view('inviteMail')
        ->with([
            'name' => $this->user->first_name,
            'group_owner' => $this->owner->first_name,
            'group_name' => $this->group->name,
            'invite_url' => $this->invite_url,
        ]);
    }
}
