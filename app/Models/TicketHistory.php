<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;class TicketHistory extends Model
{
   protected $fillable = [
        'ticket_id',
        'user_id',
        'field_name',
        'old_value',
        'new_value',
        'status_from',
        'status_to',
        'comment'
    ];

// ADD THIS FUNCTION
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // ALSO ENSURE YOU HAVE THE USER RELATIONSHIP
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}