<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $guarded = []; // allows mass assignment

    public function replayedBy()
    {
        return $this->belongsTo(Reception::class, 'replayed_by');
    }
}
