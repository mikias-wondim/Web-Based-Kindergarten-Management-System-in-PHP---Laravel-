<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function grade(){
        return $this->hasMany(Grade::class)->orderBy('quarter');
    }

    public function attendance(){
        return $this->hasMany(Attendance::class)->latest();
    }
}
