<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Notice;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NoticeboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notices =  Notice::latest('updated_at')->get();

        $classrooms = Classroom::orderBy('classroom_name', 'asc')->get();

        $now = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $thisWeekNotices = [];
        $olderNotices = [];

        foreach ($notices as $classNoticeBoard){
            $createdAt = Carbon::parse($classNoticeBoard['created_at'])->format('Y-m-d H:i:s');
            if ( $createdAt >= $now)
                $thisWeekNotices[] = $classNoticeBoard;
            else
                $olderNotices[] = $classNoticeBoard;
        }

        return view('noticeboard/index', compact('classrooms', 'thisWeekNotices', 'olderNotices'));
    }


    public function show($classroom)
    {
        $classroom = Classroom::findOrFail($classroom);
        $assignments = $classroom->assignment->toArray();
        $notices = Notice::all();

        $classNotice = [];
        foreach ($notices as $notice){
            if ($notice->recipient === 'all'){
                $classNotice[] = $notice->toArray();
            }else if (in_array($classroom->classroom_name, explode(',', $notice->recipient))){
                $classNotice[] = $notice->toArray() ;
            }
        }
        $now = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $classNoticeBoards = array_merge($classNotice, $assignments);

        usort($classNoticeBoards, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $thisWeekNotices = [];
        $olderNotices = [];

        foreach ($classNoticeBoards as $classNoticeBoard){
            $updatedAt = Carbon::parse($classNoticeBoard['updated_at'])->format('Y-m-d H:i:s');
            if ( $updatedAt >= $now)
                $thisWeekNotices[] = $classNoticeBoard;
            else
                $olderNotices[] = $classNoticeBoard;
        }

        return view('noticeboard/show', compact('classroom', 'thisWeekNotices', 'olderNotices'));
    }

    public static function countClassNotices($classroom): int
    {
        $classroom = Classroom::findOrFail($classroom);
        $assignments = $classroom->assignment->toArray();
        $notices = Notice::all();

        $classNotice = [];
        foreach ($notices as $notice){
            if ($notice->recipient === 'all'){
                $classNotice[] = $notice->toArray();
            }else if (in_array($classroom->classroom_name, explode(',', $notice->recipient))){
                $classNotice[] = $notice->toArray() ;
            }
        }
        $now = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $classNoticeBoards = array_merge($classNotice, $assignments);

        return count($classNoticeBoards);
    }

    public function download($filename)
    {
        $filePath = public_path('storage\\assignments\\' . $filename);
        $dataType = explode('.', $filename)[1];

        // Check if the file exists
        if (file_exists($filePath)) {
            $headers = [
                'Content-Type' => 'application/'.$dataType,
            ];

            return Response::download($filePath, $filename, $headers);
        } else {
            abort(404, 'File not found');
        }
    }
}
