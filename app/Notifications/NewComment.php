<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewComment extends Notification
{
    use Queueable;

    protected $ticket;
    protected $comment;

    public function __construct(Ticket $ticket, Comment $comment)
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Forces Laravel to write to the 'notifications' table
    }

    public function toArray(object $notifiable): array
    {
        // This array gets converted to JSON and stored in the database row
        return [
          'ticket_id'      => $this->ticket->id,
        'comment_id'     => $this->comment->id,
        'commenter_name' => auth()->user()->name, 
        'type'           => 'comment', // Use 'comment', 'assigned', 'escalated', or 'resolved'
        'message'        => auth()->user()->name . ' added a comment to your report',
        ];
    }
}