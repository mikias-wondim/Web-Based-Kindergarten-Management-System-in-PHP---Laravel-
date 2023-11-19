<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Classroom;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    //


    public function create()
    {
        $classrooms = Classroom::all();

        if (!$classrooms->toArray())
            return redirect()->back()->with('error', 'There is no classroom to post to !');

        return view('noticeboard/create', compact('classrooms'));
    }

    public function store()
    {
        $recipient = Helper::tocsv(request()->all(), 'class');

        $data = \request()->validate([
            'title' => 'required',
            'message'=>'required',
            'image'=>'image|max:2048',
            'pdf'=>'mimes:doc,docx,pdf|max:2048',
            'status'=>'required',
            'expired_date'=>'required',
        ]);

        $data['recipient'] = $recipient;

        $data['staff_id'] = Auth::user()->staff->id;

        if (request()->file('pdf')) {
            $file = request()->file('pdf');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/notice', $filename);

            $data['pdf'] = $filename;
        }

        if (\request('image')){
            $imagePath = request('image')->store('notice', 'public');
            $data['image'] = $imagePath;
        }

        Notice::create($data);

        if (\auth()->user()->role == 'teacher'){
            return redirect('/noticeboard/'.\auth()->user()->staff->teacher->classroom->id)->with('success', 'Notice uploaded successfully!');
        }
        elseif (\auth()->user()->role == 'school director')
            return redirect('/noticeboard')->with('success', 'Notice uploaded successfully!');
        else
            return redirect()->back()->with('success', 'Notice uploaded successfully!');

    }

    public function edit(Notice $notice)
    {
        $selectedClassrooms = explode(',', $notice->recipient);

        $classrooms = Classroom::all();
        return view('noticeboard/edit', compact('classrooms', 'notice', 'selectedClassrooms'));
    }

    public function update(Notice $notice)
    {
        $recipient = Helper::tocsv(request()->all(), 'class');

        $data = \request()->validate([
            'title' => 'required',
            'message'=>'required',
            'image'=>'image|max:2048',
            'pdf'=>'mimes:doc,docx,pdf|max:2048',
            'status'=>'required',
            'expired_date'=>'required',
        ]);

        $data['recipient'] = $recipient;

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

        $notice->update($data);

        if (\auth()->user()->role == 'teacher'){
            return redirect('/noticeboard/'.\auth()->user()->staff->teacher->classroom->id)->with('success', 'Notice uploaded successfully!');
        }
        elseif (\auth()->user()->role == 'school director')
            return redirect('/noticeboard')->with('success', 'Notice uploaded successfully!');
        else
            return redirect()->back()->with('success', 'Notice uploaded successfully!');
    }

    public function destroy($notice)
    {
        $deletedRows = Notice::destroy($notice);
        if ($deletedRows > 0){
            return redirect('/noticeboard')->with('success', 'Deleted Successfully!');
        }else {
            return redirect('/noticeboard')->with('error', 'Deletion Failed!');
        }
    }
}
