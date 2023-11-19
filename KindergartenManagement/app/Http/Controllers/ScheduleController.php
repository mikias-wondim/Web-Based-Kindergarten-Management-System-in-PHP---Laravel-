<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedule/edit', compact('schedule'));
    }

    public function show(Schedule $schedule)
    {
        return view('schedule/show', compact('schedule'));
    }

    public function update(Schedule $schedule)
    {
        $two = Helper::tocsv(\request()->all(), 'two');
        $three = Helper::tocsv(\request()->all(), 'three');
        $four = Helper::tocsv(\request()->all(), 'four');
        $five = Helper::tocsv(\request()->all(), 'five');
        $six = Helper::tocsv(\request()->all(), 'six');
        $seven = Helper::tocsv(\request()->all(), 'seven');
        $eight = Helper::tocsv(\request()->all(), 'eight');
        $comment = \request('comment');

        $data = [
            'two'=>$two,
            'three'=>$three,
            'four'=>$four,
            'five'=>$five,
            'six'=>$six,
            'seven'=>$seven,
            'eight'=>$eight,
            'comment'=>$comment,
        ];

        $schedule->update($data);

        return redirect()->route('schedule.show', ['schedule'=>$schedule->id])->with('success', 'Schedule updated successfully!');
    }
}
