<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Profile;
use App\Models\Schedule;
use App\Models\SchoolFee;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        return view('classroom/index', compact('classrooms'));
    }

    public function create()
    {
        return view('classroom/create');
    }

    public function store()
    {
        request()->merge([
            'classroom_name' => request('name') . " / " . request('section'),
            'subjects' => $this->tocsv('subject'),
        ]);

        $data = \request()->validate([
            'classroom_name' => ['required', 'unique:classrooms'],
            'subjects' => 'required',
            'max_capacity' => 'required',
        ]);


        $classroom = Classroom::create($data);
        Schedule::create([
            'classroom_id' => $classroom->id,
        ]);

        $classroomName = trim(
            explode('/', $classroom->classroom_name)[0]);

        if ((SchoolFee::where('classroom', $classroomName)->get()->count()) < 1) {
            (new SchoolFeeController)->create($classroomName);
        }

        return redirect('classroom/create')->with('success', 'Classroom successfully created!');
    }

    public function edit(Classroom $classroom)
    {
        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        return view('classroom/edit', compact('classroom', 'classrooms'));
    }

    public function update(Classroom $classroom)
    {
        request()->merge([
            'classroom_name' => request('name') . " / " . request('section'),
            'subjects' => $this->tocsv('subject'),
        ]);

        $data = \request()->validate([
            'classroom_name' => 'required',
            'subjects' => 'required',
            'max_capacity' => 'required',
        ]);

        $classroom->update($data);

        return redirect()->back()->with('success', 'Classroom successfully updated!');
    }

    public function destroy($classroom)
    {
        Classroom::destroy($classroom);
        return redirect('classroom')->with('success', 'Classroom successfully removed!');
    }

    public function assign($classroom)
    {
        $classroom = Classroom::findOrFail($classroom);
        $teachers = Teacher::all();

        return view('classroom.assign', compact('classroom', 'teachers'));
    }

    public function assigned()
    {
        $data = \request()->validate([
            'classroom_id'=>'',
            'teacher_id'=>''
        ]);

        $teacher = Teacher::findOrFail($data['teacher_id']);

        $teacher->update([
            'classroom_id'=>$data['classroom_id'],
        ]);

        return redirect('/classroom')->with('success', 'Teacher assigned successfully!');
    }

    public function unassigned()
    {
        $data = \request()->validate([
            'classroom_id'=>'',
            'teacher_id'=>''
        ]);

        $teacher = Teacher::findOrFail($data['teacher_id']);

        $teacher->update([
            'classroom_id'=>null,
        ]);

        return redirect()->back()->with('success', 'Teacher unassigned successfully!');
    }

    public function tocsv($keyword)
    {
        $strings = $this->getValuesBySubstring(\request()->all(), $keyword);
        $csv = '';
        for ($i = 0; $i < count($strings); $i++) {
            $csv .= ($i + 1 === count($strings)) ? $strings[$i] : $strings[$i] . ",";
        }

        return $csv;
    }

    public function getValuesBySubstring($array, $substring)
    {
        $filteredValues = [];

        foreach ($array as $key => $value) {
            if (strpos($key, $substring) !== false) {
                $filteredValues[] = $value;
            }
        }

        return $filteredValues;
    }

    public static function countClassrooms(): int
    {
        return count(Classroom::all());
    }

    public static function getClassroomId($classroomName): int
    {
        $classroom = Classroom::where('classroom_name', $classroomName)->get();

        if ($classroom){
            return $classroom[0]->id;
        }
        return -1;
    }
    public static function isReachedMax($classroomName): bool
    {
        $classroom = Classroom::where('classroom_name', $classroomName)->get();
        $childrenNumber = count(Profile::where('classroom_id', $classroom[0]->id)->get());

        return $childrenNumber == $classroom[0]->max_capacity;
    }

    public static function getEnrolledChildren($classroom): int
    {
        $classroom = Classroom::find($classroom);
        $childrenNumber = count(Profile::where('classroom_id', $classroom->id)->get());

        return ($childrenNumber);
    }
}
