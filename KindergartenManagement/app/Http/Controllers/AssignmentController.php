<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Classroom $classroom)
    {
        return view('assignment/create', compact('classroom'));
    }

    public function store(Classroom $classroom)
    {
        $data = \request()->validate([
            'subject'=>'required',
            'title'=>'required',
            'description'=>'',
            'image'=>'image|max:2048',
            'pdf'=>'mimes:doc,docx,pdf|max:2048',
            'due_date'=>'required',
            'max_score'=>'required',
            'status'=>'required',
            'delete_after'=>'required',
        ]);

        if (request()->file('pdf')) {
            $file = request()->file('pdf');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('assignments', $filename);

            $data['pdf'] = $filename;
        }

        if (\request('image')){
            $imagePath = request('image')->store('assignments', 'public');
            $data['image'] = $imagePath;
        }

        $data['classroom_id'] = $classroom->id;
        $data['staff_id'] = $classroom->teacher[0]->id;

        Assignment::create($data);

        return redirect()->route('noticeboard.show', ['classroom'=>$classroom->id])->with('success', 'Assignment uploaded successfully!');
    }

    public function edit(Assignment $assignment)
    {
        $classroom = Classroom::find($assignment->classroom_id);

        return view('assignment/edit', compact('assignment', 'classroom'));
    }

    public function update(Assignment $assignment)
    {
        $data = \request()->validate([
            'subject'=>'required',
            'title'=>'required',
            'description'=>'',
            'image'=>'image|max:2048',
            'pdf'=>'mimes:doc,docx,pdf|max:2048',
            'due_date'=>'required',
            'max_score'=>'required',
            'status'=>'required',
            'delete_after'=>'required',
        ]);

        if (request()->file('pdf')) {
            $file = request()->file('pdf');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/assignments', $filename);

            $data['pdf'] = $filename;
        }

        if (\request('image')){
            $imagePath = request('image')->store('assignments', 'public');
            $data['image'] = $imagePath;
        }

        $assignment->update($data);

        $classroom = Classroom::findOrFail($assignment->classroom_id);

        return redirect()->route('noticeboard.show', ['classroom'=>$classroom->id])->with('success', 'Assignment uploaded successfully!');
    }

    public function destroy($assignment)
    {
        $isDeleted = Assignment::destroy($assignment);

        $classroom = auth()->user()->staff->teacher->classroom;

        if ($isDeleted)
            return redirect()->route('noticeboard.show', ['classroom'=>$classroom->id])->with('success', 'Assignment deleted successfully!');
        else
            return redirect()->route('noticeboard.show', ['classroom'=>$classroom->id])->with('error', 'Assignment deletion failed!');
    }
}
