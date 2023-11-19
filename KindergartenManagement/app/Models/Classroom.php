<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class, 'classroom_id')->latest();
    }

    public function notice()
    {
        return $this->hasMany(Notice::class, 'classroom_id')->latest();
    }

    public function schoolFee(){
        return $this->hasMany(SchoolFee::class, 'classroom_id');
    }

    public function teacher()
    {
        return $this->hasMany(Teacher::class, 'classroom_id')->latest();
    }
}
