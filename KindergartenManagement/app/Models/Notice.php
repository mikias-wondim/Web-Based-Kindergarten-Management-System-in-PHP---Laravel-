<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
