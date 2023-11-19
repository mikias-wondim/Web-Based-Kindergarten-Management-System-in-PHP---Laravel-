<?php

namespace App\Helpers;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\Progress;

class NewProfile
{

    public static function generateEmptyReport($profile)
    {
        $profile = Profile::findOrFail($profile);

        $classroom = Classroom::find($profile->classroom_id);
        $count = count(explode(',', $classroom->subjects));

        $progress = Progress::create([
            'profile_id'=>$profile->id
        ]);


        for ($i = 1; $i <= 4; $i++) {
            $grade = [
              'progress_id'=>$progress->id,
              'quarter'=>$i,
              'subjects'=>$classroom->subjects,
              'midterm'=>self::zeroGrade($count),
              'assignment'=>self::zeroGrade($count),
              'final'=>self::zeroGrade($count),
              'status'=>'hide',
            ];

            Grade::create($grade);
        }

    }

    public static function zeroGrade($num){
        $zeros = '0';
        for ($i = 0; $i < $num-1; $i++) {
            $zeros .= ',0';
        }
        return $zeros;
    }
}
