<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function receiver()
    {
        $this->belongsTo(User::class, 'receiver');
    }
    public function sender()
    {
        $this->belongsTo(User::class, 'sender');
    }
}
