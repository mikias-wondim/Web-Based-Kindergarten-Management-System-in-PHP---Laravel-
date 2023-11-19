<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    use HasFactory;

    protected $guarded = []; // to reset the fill-able values to all

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
}
