<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classrooom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function createdBy()
    {
        return $this->belongsToMany(Staff::class, 'staff_id');
    }
}
