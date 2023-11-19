<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Staff;
use App\Models\SystemAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($role)
    {
        $allStaffs = Staff::orderBy('first_name', 'asc')->get();

        $roles = [];
        foreach ($allStaffs as $staff) {
            if ($staff->user->role == $role) {
                $roles[] = $staff;
            }
        }

        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        return view('staff.index', compact('roles', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();
        return view('staff/create', compact('classrooms'));
    }

    public function store()
    {

        $data = request()->validate([
            'profile_pic' => ['required', 'image'],
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
            'qualification' => 'required',
            'certificate' => ['required', 'image'],
            'date_of_hire' => 'required',
            'salary' => 'required',
            'status' => 'required',
        ]);

        try {
//            Start Transaction
            DB::beginTransaction();

            $user = User::create([
                'unique_name' => session('unique_name'),
                'email' => session('email'),
                'role' => session('role'),
                'password' => Hash::make('changeme')
            ]);

            $data['dob'] = \Carbon\Carbon::createFromFormat('Ymd',
                str_replace('-', '', $data['dob']))->format('Y-m-d');

            $data['date_of_hire'] = \Carbon\Carbon::createFromFormat('Ymd',
                str_replace('-', '', $data['date_of_hire']))->format('Y-m-d');

            $profileImagePath = \request('profile_pic')->store('profiles', 'public');
            $data['profile_pic'] = $profileImagePath;

            $certificateImagePath = \request('certificate')->store('certificate', 'public');
            $data['certificate'] = $certificateImagePath;

            $data['role'] = $user->role;

            $staff = $user->staff()->create($data);

            if ($user->role == 'system admin') {
                $staff->schoolAdmin()->create([
                    'staff_id' => $user->id,
                ]);
            } else if ($user->role == 'school director') {
                $staff->schoolDirector()->create([
                    'staff_id' => $user->id,
                ]);
            } else if ($user->role == 'teacher') {
                $staff->teacher()->create([
                    'staff_id' => $user->id,
                    'classroom_id' => \request()->input('classroom_id'),
                ]);
            } else if ($user->role == 'accountant') {
                $staff->accountant()->create([
                    'staff_id' => $user->id,
                ]);
            } else if ($user->role == 'reception') {
                $staff->reception()->create([
                    'staff_id' => $user->id,
                ]);
            }

//                Commit the transaction
            DB::commit();

            // Clearing values of the session
            session([
                'unique_name' => '',
                'email' => '',
                'role' => '',
            ]);

            Session::flash('success', 'Registered Successful!');

        } catch (\Exception $e) {
//            If any error happens during registration rollback all the database changes
            DB::rollback();

            Session::flash('error', 'Registration Failed!');
        } finally {


            return redirect()->route('register.staff');
        }
    }

    public function show($staff)
    {
        $staff = Staff::findOrFail($staff);

        return view('staff.show', compact('staff'));
    }

    public function showAccountant($staff)
    {
        $staff = Staff::findOrFail($staff);

        return view('staff.show-accountant', compact('staff'));
    }

    public function showDirector($staff)
    {
        $staff = Staff::findOrFail($staff);

        return view('staff.show-director', compact('staff'));
    }

    public function edit($staff)
    {
        $staff = Staff::findOrFail($staff);

        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        return view('staff.edit', compact('staff', 'classrooms'));
    }

    public function update($staff)
    {
        $staffId = $staff;
        $staff = Staff::findOrFail($staffId);

        $staffRole = $staff->user->role;

        $data = request()->validate([
            'profile_pic' => \request()->has('profile_pic') ? 'image|max:2048' : '',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone' => ['required', 'regex:/^(?:\+251|0)\d{9}$/'],
            'qualification' => 'required',
            'certificate' => \request()->has('certificate') ? 'image|max:2048' : '',
            'date_of_hire' => 'required',
            'salary' => 'required',
            'status' => 'required',
        ]);

        try {
//            Start Transaction
            $data['dob'] = \Carbon\Carbon::createFromFormat('Ymd',
                str_replace('-', '', $data['dob']))->format('Y-m-d');

            $data['date_of_hire'] = \Carbon\Carbon::createFromFormat('Ymd',
                str_replace('-', '', $data['date_of_hire']))->format('Y-m-d');

            if (\request()->has('profile_pic')) {
                $profileImagePath = \request('profile_pic')->store('profiles', 'public');
                $data['profile_pic'] = $profileImagePath;
            }

            if (\request()->has('certificate')) {
                $certificateImagePath = \request('certificate')->store('certificate', 'public');
                $data['certificate'] = $certificateImagePath;
            }

            DB::beginTransaction();

            $staff->update($data);

            DB::commit();

            Session::flash('success', 'Registered Successful!');

        } catch (\Exception $e) {
//            If any error happens during registration rollback all the database changes
            DB::rollback();

            Session::flash('error', 'Registration Failed!');
        } finally {

            $returnTo = match ($staffRole) {
                'teacher' => '/staff/show',
                'school director' => '/staff/director/',
                'reception' => '/staff/reception',
                'accountant' => '/staff/accountant',
                'system admin' => '/staff/admin',
            };

            return redirect($returnTo . $staffId);
        }
    }

    public function destroy($staff)
    {
        $deletedRows = Staff::destroy($staff);
        if ($deletedRows > 0) {
            return redirect()->back()->with('success', 'Deleted Successfully!');
        } else {
            return redirect()->back()->with('error', 'Deletion Failed!');
        }
    }

    public static function countAllStaff(): int
    {
        return count(Staff::all());
    }

    public static function countActiveStaff(): int
    {
        $allStaff = Staff::all();
        $activeStaffs = 0;
        foreach ($allStaff as $staff) {
            if ($staff->user->status == 'active')
                $activeStaffs++;
        }
        return $activeStaffs;
    }

    public static function countAllTeachers()
    {
        return count(User::where('role', 'teacher')->get());
    }
}
