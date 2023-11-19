<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schoolDirector()
    {
        return $this->belongsTo(SchoolDirector::class, 'approved_by');
    }

    public function reception()
    {
        return $this->belongsTo(Reception::class, 'forwarded_by');
    }
}
