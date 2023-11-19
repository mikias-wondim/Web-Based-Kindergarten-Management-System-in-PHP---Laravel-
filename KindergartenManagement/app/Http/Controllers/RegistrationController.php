<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @throws ValidationException
     */
    public function store()
    {
        $data = \request()->validate([
            'unique_name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required', 'string'],
        ]);

        $username = explode('.', $data['unique_name']);


        if ((count($username) !== 3) || (strlen($username[0]) !== 3 || strlen($username[1]) !== 3 || strlen($username[2]) < 2)){
            $message = 'The username is not valid, please use first three letters of child name, father name then mother name all separated by dot(.)';
            throw ValidationException::withMessages([
                'unique_name' => [$message],
            ]);
        }

        session([
            'unique_name' => strtolower(\request()->input('unique_name')),
            'email' => \request()->input('email'),
            'role' => \request()->input('role'),
        ]);

        if (session('role') === 'child'){
            return redirect('/profile/create');
        }else{
            return redirect('/staff/create');
        }
    }
}
