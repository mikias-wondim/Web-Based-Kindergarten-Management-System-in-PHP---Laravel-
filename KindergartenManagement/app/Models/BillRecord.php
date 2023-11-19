<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillRecord extends Model
{
    use HasFactory;

    protected $guarded = []; // to reset the fill-able values to all

    public function profile(){
        return $this->belongsTo(Profile::class, 'child_id');
    }

}
