<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Classroom;
use App\Models\Profile;
use App\Models\User;
use App\Helpers\NewProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        $childrenInClassroom = [];

        foreach ($classrooms as $classroom){
            $childrenInClassroom[$classroom->classroom_name] = Profile::where('classroom_id', $classroom->id)->orderBy('first_name', 'asc')->get();
        }


        $firstClassChildren = [];
        if ($classrooms->toArray())
            $firstClassChildren = $childrenInClassroom[$classrooms[0]->classroom_name];

        return view('profiles.index', compact('classrooms', 'childrenInClassroom', 'firstClassChildren'));
    }

    public function indexSpecific($classroom)
    {   $classrooms = [];

        if ($classroom == 0){

            return view('classroom/unassigned');
        }

        $classrooms[] = Classroom::findOrFail($classroom);

        foreach ($classrooms as $classroom){
            $childrenInClassroom[$classroom->classroom_name] = Profile::where('classroom_id', $classroom->id)->orderBy('first_name', 'asc')->get();
        }

        $firstClassChildren = $childrenInClassroom[$classrooms[0]->classroom_name];

        return view('profiles.index', compact('classrooms', 'childrenInClassroom', 'firstClassChildren'));
    }

    public function show(Profile $profile)
    {
        return view('profiles.show', [
             'user'=> $profile->user,
        ]);
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        if (!$classrooms->toArray())
            return redirect()->back()->with('error', 'There is no classroom to register the child !');

        return view('profiles.create', compact('classrooms'));
    }

    /**
     * @throws ValidationException
     */
    public function store()
    {
        $data = request()->validate([
            'profile_pic' => ['required', 'image'],
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'mother_name' => 'required',
            'current_guardian' => 'required',
            'guardian_address' => 'required',
            'guardian_phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
            'classroom_id' => 'required',
        ]);

        session([
            'profile_pic' => \request('profile_pic')->store('profiles', 'public'),
            'first_name' => \request()->input('first_name'),
            'middle_name' => \request()->input('middle_name'),
            'last_name' => \request()->input('last_name'),
            'dob' => \request()->input('dob'),
            'gender' => \request()->input('gender'),
            'mother_name' => \request()->input('mother_name'),
            'current_guardian' => \request()->input('current_guardian'),
            'guardian_address' => \request()->input('guardian_address'),
            'guardian_phone' => \request()->input('guardian_phone'),
            'classroom_id' => \request()->input('classroom_id'),
        ]);


        if (!(auth()->user()->role == 'school director')){
            $admissions = Admission::where('approved', 1)->get();

            $approved = false;
            foreach ($admissions as $admission){
                $fullName = explode(' ', $admission->full_name);
                $fullName[1] = $fullName[1] ?? '';

                if ( strtolower($fullName[0]) == strtolower($data['first_name'])
                    && strtolower($fullName[1]) == strtolower($data['middle_name'])){
                    $approved = true;
                    break;
                }
            }

            if (!($approved)){
                $message = 'The selected child name is not approved to be registered by the school director!';
                throw ValidationException::withMessages([
                    'first_name' => [$message],
                    'middle_name' => ' ',
                ]);
            }
        }

        $classControl = new ClassroomController();

        if($classControl->isReachedMax($data['classroom_id'])){
            $message = 'The selected classroom has reached it\'s maximum capacity!';
            throw ValidationException::withMessages([
                'classroom_id' => [$message],
            ]);
        }

        return redirect('/healthemergeinfo/create');
    }

    public function edit(Profile $profile)
    {
        return view('profiles/edit', compact('profile'));
    }

    public function update(Profile $profile)
    {
        $data = request()->validate([
            'profile_pic' => 'image|max:2048',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'mother_name' => 'required',
            'current_guardian' => 'required',
            'guardian_address' => 'required',
            'guardian_phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
            'classroom' => 'required',
        ]);

        if (\request('profile_pic')){
            $imagePath = request('profile_pic')->store('profiles', 'public');
            $data['profile_pic'] = $imagePath;
        }

        $profile->update($data);

        return view('profiles/show', [
            'user'=> $profile->user,
        ]);
    }

    public function destroy($profile)
    {
        $deletedRows = Profile::destroy($profile);
        if ($deletedRows > 0){
            return redirect()->back()->with('success', 'Deleted Successfully!');
        }else {
            return redirect()->back()->with('error', 'Deletion Failed!');
        }
    }

    public static function countAllChildren(): int
    {
        return count(Profile::all());
    }

    public static function countActiveChildren(): int
    {
        $allChildren = Profile::all();
        $activeChildren = 0;
        foreach ($allChildren as $staff){
            if ($staff->user->status == 'active')
                $activeChildren ++;
        }
        return $activeChildren;
    }
}
