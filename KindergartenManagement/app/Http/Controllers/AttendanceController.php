<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Attendance $attendance)
    {
        $data = \request()->validate([
            'date' => '',
            'reason' => '',
            'permission' => '',
            'remark' => '',
        ]);

        $attendance->update($data);

        return redirect()->back();
    }

    public function create(Profile $profile)
    {
        $data = \request()->validate([
            'date' => '',
            'reason' => '',
            'permission' => '',
            'remark' => '',
        ]);

        $data['progress_id'] = $profile->progress->id;

        Attendance::create($data);

        return redirect()->back();
    }

    public function destroy($attendance)
    {
        Attendance::destroy($attendance);

        Session::flash('success', 'Record deleted successfully.');

        // Redirect back to the appropriate page
        return redirect()->back();
    }
}
