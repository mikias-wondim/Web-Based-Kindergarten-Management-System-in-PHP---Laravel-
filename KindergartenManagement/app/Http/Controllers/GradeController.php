<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    //
    public function update(Grade $grade)
    {
        $midterm = $this->tocsv('midterm');
        $assignment = $this->tocsv('assignment');
        $final = $this->tocsv('final');
        $status = \request('status');

        $grade->update([
            'midterm' => $midterm,
            'assignment' => $assignment,
            'final' => $final,
            'status' => $status,
        ]);

        $profile = Profile::findorFail($grade->progress->profile->id);

        $grades = $profile->progress->grade;

        return view('progress/edit', compact('profile', 'grades'));

    }

    public function tocsv($keyword)
    {
        $strings = $this->getValuesBySubstring(\request()->all(), $keyword);
        $csv = '';
        for ($i = 0; $i < count($strings); $i++) {
            $csv .= ($i + 1 === count($strings)) ? $strings[$i] : $strings[$i].",";
        }

        return $csv;
    }

    public function getValuesBySubstring($array, $substring) {
        $filteredValues = [];

        foreach ($array as $key => $value) {
            if (strpos($key, $substring) !== false) {
                $filteredValues[] = $value;
            }
        }

        return $filteredValues;
    }
}
