<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\SchoolFee;
use Illuminate\Http\Request;

class SchoolFeeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classrooms = Classroom::all();

        $classroomList = [];

        foreach ($classrooms as $classroom){
            $classroomName = trim(
                explode('/', $classroom->classroom_name)[0]);

            if (!in_array($classroomName, $classroomList)){
                $classroomList[] = $classroomName;
            }
        }

        $schoolFee = [];

        foreach ($classroomList as $classroomName){
            $schoolFee[$classroomName] = SchoolFee::where('classroom', $classroomName)->get()->toArray();
        }

        $months= [
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
        ];

        return view('schoolfee/index', compact('classroomList', 'schoolFee',  'months'));
    }

    public function create($classroom)
    {
        $months= [
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
        ];

        foreach ($months as $month){
            $programFee = [
                'classroom' => $classroom,
                'year' => date('Y'),
                'month' => $month,
                'amount' => 1000,
            ];

            SchoolFee::create($programFee);
        }
    }

    public function update()
    {
        $data = \request()->validate(
            [
                'id' => 'required',
                'classroom' => 'required',
                'month' => 'required',
                'amount' => 'required',
                'due_date' => 'required',
                'late_payment' => 'required',
            ]
        );

        $monthlyFee = SchoolFee::findOrFail($data['id']);

        $monthlyFee->update($data);

        return redirect()->back()->with('success', 'Successfully Updated !');
    }
}
