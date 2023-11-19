<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    //
    function create() {
        return view('admission.create');
    }

    public function store()
    {
        $data = \request()->validate([
            'full_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'previous_school' => 'required',
            'applying_program' => 'required',
            'medical_condition' => '',
            'father_name' => 'required',
            'mother_name' => 'required',
            'additional_info' => '',
            'phone' => 'required',
            'email' => 'email',
            'address' => 'required',
        ]);

        $admission = Admission::create($data);

        if ($admission)
            return redirect()->back()->with('success', 'Admission form submitted successfully ');

        return redirect()->back();
    }

    public function index()
    {
        $admissions = Admission::orderBy('created_at')->get();

        return view('admission.index', compact('admissions'));
    }

    public function show($admission)
    {
        $admission = Admission::findOrFail($admission);

        $admission->update([
           'new' => 0
        ]);

        if (auth()->user()->role == 'school director'){
            $admission->update([
                'checked' => 1
            ]);
        }

        return view('admission.show', compact('admission'));
    }

    public function update($admission)
    {
        $admission = Admission::findOrFail($admission);

        if (auth()->user()->role == 'school director'){
            $admission->update([
                'approved' => \request()->input('approved'),
                'approved_by' => \request()->input('approved_by'),
            ]);
        }elseif(auth()->user()->role == 'reception'){
            $admission->update([
                'forward' => \request()->input('forward'),
                'forwarded_by' => \request()->input('forwarded_by'),
            ]);
        }

        if ($admission)
            return redirect()->back()->with('success', 'Admission updated successfully!');

        return redirect()->back();

    }

    public function destroy($admission)
    {
        $admission = Admission::findOrFail($admission);

        $deletedRows = $admission->destroy();

        if ($deletedRows)
            return redirect('/admission/index')->with('success', 'Admission deleted successfully!');

        return redirect()->back()->with('success', 'Admission deleted successfully!');
    }

    public static function countAdmission(): int
    {
        return count(Admission::all());
    }
}
