<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($profile)
    {
        $profile = Profile::findOrFail($profile);

        return view('progress/index', [
            'profile'=>$profile,
            'grades'=>$profile->progress->grade,
            'attendances'=>$profile->progress->attendance,
        ]);
    }

    public function edit(Profile $profile)
    {
        $grades = $profile->progress->grade;
        return view('progress/edit', compact('profile', 'grades'));
    }

    public function update(Profile $profile)
    {
        $data = \request()->validate([
            'behavior' => 'required',
            'participation' => 'required',
            'teamwork' => 'required',
            'strength' => '',
            'weakness' => '',
            'comment' => '',
        ]);

        $profile->progress->update($data);

        $grades = $profile->progress->grade;

        return view('progress/edit', compact('profile', 'grades'));
    }
}
