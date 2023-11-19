<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contacts = ContactMessage::all();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = \request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:15',
        ]);

        $contact = ContactMessage::create($data);
        if ($contact)
            return redirect()->back()->with('success', 'Message delivered sucessfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($contact)
    {
        $deletedRows = ContactMessage::destroy($contact);

        if ($deletedRows)
            return redirect()->back()->with('success', 'Contact message deleted successfully');

        return redirect()->back();
    }
}
