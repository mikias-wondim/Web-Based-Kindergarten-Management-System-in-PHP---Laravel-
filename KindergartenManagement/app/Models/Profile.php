<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = []; // to reset the fill-able values to all

    public function user(){
        return $this->belongsTo(User::class, 'child_id');
    }
    public function healthemergencyinfo()
    {
        return $this->hasOne(HealthEmergencyInfo::class)->latest();
    }
    public function progress()
    {
        return $this->hasOne(Progress::class)->latest();
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function billRecords()
    {
        return $this->hasMany(BillRecord::class, 'profile_id');
    }
}
