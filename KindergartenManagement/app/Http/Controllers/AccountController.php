<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $allUsers = User::all();

        return view('accounts.index', compact('allUsers'));
    }

    public function update($user)
    {
        $user = User::findOrFail($user);

        $status = \request()->validate([
            'status' => 'required'
        ]);

        $completed = $user->update($status);

        if ($completed)
            return redirect()->back()->with('success', 'Status updated successfully');
        else
            return redirect()->back()->with('error', 'Status update failed');
    }
}
