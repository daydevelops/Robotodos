<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMentioned extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $copmment;
    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comment,$type,$data)
    {
        $this->comment = $comment;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(lang('Someone Mentioned', ['type' => strtolower($this->type), 'title' => $this->comment->commentable->title]))
        ->markdown('mail.mention.user', $this->data);
    }
}
