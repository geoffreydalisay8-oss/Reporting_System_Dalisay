<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
   protected $fillable = ['ticket_id', 'file_name', 'file_path'];

    public function ticket() {
        // Change 'ticket' to 'Ticket' (Uppercase)
        return $this->belongsTo(Ticket::class);
    }
}