<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $guarded = []; // to reset the fill-able values to all

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function systemAdmin()
    {
        return $this->hasOne(SystemAdmin::class);
    }
    public function schoolDirector()
    {
        return $this->hasOne(SchoolDirector::class);
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }
    public function accountant()
    {
        return $this->hasOne(Accountant::class);
    }
    public function reception()
    {
        return $this->hasOne(Reception::class);
    }

    public function notices()
    {
        return $this->hasOne(Notice::class, 'staff_id');
    }

    public function assignments()
    {
        return $this->hasOne(Assignment::class, 'staff_id');
    }
}
