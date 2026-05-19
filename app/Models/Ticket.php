<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
   protected $fillable = [
    'user_id',
    'title',
    'description',
    'type',      
    'priority',
    'status',
    'assigned_to',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function attachments()
{
    return $this->hasMany(Attachment::class, 'ticket_id');
}

    public function creator() 
{
    return $this->belongsTo(User::class, 'user_id');
}

public function histories()
{
    return $this->hasMany(TicketHistory::class)->latest();
}
}