<?php

namespace App\Http\Controllers;

use App\Helpers\NewProfile;
use App\Models\Classroom;
use App\Models\HealthEmergencyInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class HealthEmergInfoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('healthemergeInfo.create');
    }

    public function store()
    {
        $data = request()->validate([
            'blood_type'=>'',
            'allergies'=>'',
            'medications'=>'',
            'special_needs'=>'',
            'contact_name'=>'required',
            'contact_address'=>'required',
            'contact_phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
        ]);

        \session([
            'blood_type'=>\request()->input('blood_type'),
            'allergies'=>\request()->input('allergies'),
            'medications'=>\request()->input('medications'),
            'special_needs'=>\request()->input('special_needs'),
            'contact_name'=>\request()->input('contact_name'),
            'contact_address'=>\request()->input('contact_address'),
            'contact_phone' => \request()->input('contact_phone'),
        ]);

        try {
//            Start Transaction
            DB::beginTransaction();

            $child = User::create([
                'unique_name' => session('unique_name'),
                'email' => session('email'),
                'role' => session('role'),
                'password' => Hash::make('changeme')
            ]);

            $profileData = [
                'profile_pic' => session('profile_pic'),
                'first_name' => session('first_name'),
                'middle_name' => session('middle_name'),
                'last_name' => session('last_name'),
                'dob' => session('dob'),
                'gender' => session('gender'),
                'mother_name' => session('mother_name'),
                'current_guardian' => session('current_guardian'),
                'guardian_address' => session('guardian_address'),
                'guardian_phone' => session('guardian_phone'),
                'classroom_id' => session('classroom_id'),
            ];


            // Setting up profile data
            $profileData['father_name'] =  $profileData['middle_name'] . ' ' .  $profileData['last_name'];

            $classroom = Classroom::where('classroom_name',  $profileData['classroom_id'])->first();

            $profileData['classroom_id'] = $classroom->id;

            $profileData['dob'] = \Carbon\Carbon::createFromFormat('Ymd',
                str_replace('-','', $profileData['dob']))->format('Y-m-d');


            // create profile based on the user created
            $profile = $child->profile()->create($profileData);


            // Generate empty progress report for the newly created child
            NewProfile::generateEmptyReport($profile->id);


            // Create the health information for the profile
            $profile->healthemergencyinfo()->create($data);

            // Clearing values of the session
            \session([
                'unique_name' => '',
                'email' => '',
                'role' => '',
                'profile_pic' => '',
                'first_name' => '',
                'middle_name' => '',
                'last_name' => '',
                'dob' => '',
                'gender' => '',
                'mother_name' => '',
                'current_guardian' => '',
                'guardian_address' => '',
                'guardian_phone' => '',
                'classroom_id' => '',
                'blood_type'=>'',
                'allergies'=>'',
                'medications'=>'',
                'special_needs'=>'',
                'contact_name'=>'',
                'contact_address'=>'',
                'contact_phone' => '',
            ]);


//        Commit the transaction
            DB::commit();

            Session::flash('success', 'Registered Successful!');

        }catch (\Exception $e){
//            If any error happens during registration rollback all the database changes
            DB::rollback();

            Session::flash('error', 'Registration Failed!');
        } finally {

            return redirect('/register');
        }
    }

    public function edit($healthinfo)
    {
        $healthinfo = HealthEmergencyInfo::findOrFail($healthinfo);

        return view('healthemergeinfo/edit', compact('healthinfo'));
    }

    public function update(HealthEmergencyInfo $healthinfo)
    {
        $data = request()->validate([
            'blood_type'=>'required',
            'allergies'=>'required',
            'medications'=>'required',
            'special_needs'=>'required',
            'contact_name'=>'required',
            'contact_address'=>'required',
            'contact_phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
        ]);

        $healthinfo->update($data);

        return view('profiles/index', [
            'user'=> $healthinfo->profile->user,
        ]);

    }
}
