<?php

namespace App\Http\Controllers;

use App\Models\BillRecord;
use App\Models\Classroom;
use App\Models\Profile;
use App\Models\Schedule;
use App\Models\SchoolFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BillRecordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classrooms = Classroom::all();

        $bankInfo = $this->getBankInfo();

        $classroomList = [];

        foreach ($classrooms as $classroom){
            $classroomName = trim(
                                explode('/', $classroom->classroom_name)[0]);

            if (!in_array($classroomName, $classroomList)){
                $classroomList[] = $classroomName;
            }
        }

        $schoolFee = [];

        foreach ($classroomList as $classroomName){
            $schoolFee[$classroomName] = SchoolFee::where('classroom', $classroomName)->get()->toArray();
        }

        $months= [
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
        ];

        return view('bank-info/index', compact('classroomList', 'schoolFee',  'bankInfo', 'months'));
    }

    public function create($profile)
    {
        $months= [
            'sep' => 'September',
            'oct' => 'October',
            'nov' => 'November',
            'dec' => 'December',
            'jan' => 'January',
            'feb' => 'February',
            'mar' => 'March',
            'apr' => 'April',
            'may' => 'May',
            'jun' => 'June',
            'jul' => 'July',
            'aug' => 'August',
        ];

        foreach ($months as $month){
            $data = [
                'child_id' => $profile,
                'year' => date('Y'),
                'month' =>   $month,
                'status' => 'Unpaid'
            ];

            BillRecord::create($data);
        }
    }

    public function show($profile)
    {
        $months = BillRecord::where('child_id', $profile)->get();

        $profile = Profile::findOrFail($profile);

        $classroomName = trim(
            explode('/', $profile->classroom->classroom_name)[0]);

        $schoolFee = SchoolFee::where('classroom', $classroomName)->get()->toArray();
        $monthlyFee = [];
        foreach ($schoolFee as $fee){
            $monthlyFee[$fee['month']] = $fee;
        }

        $bankInfos = $this->getBankInfo();

        return view('bill-record/show', compact('months', 'monthlyFee', 'bankInfos'));
    }

    public function edit($profile)
    {
        $bills = BillRecord::where('child_id', $profile)->get();

        if (!count($bills)){
            $this->create($profile);
        }

        $bills = BillRecord::where('child_id', $profile)->get();

        $profile = Profile::findOrFail($profile);

        $bankInfos = $this->getBankInfo();

        $classroomName = trim(
            explode('/', $profile->classroom->classroom_name)[0]);

        $schoolFee = SchoolFee::where('classroom', $classroomName)->get()->toArray();
        $monthlyFee = [];
        foreach ($schoolFee as $fee){
            $monthlyFee[$fee['month']] = $fee;
        }

        return view('bill-record/edit', compact( 'profile', 'bills', 'monthlyFee','bankInfos'));
    }

    public function update($bill)
    {
        $bill = BillRecord::find($bill);

        $data = \request()->validate([
        'month' => '',
        'amount' => '',
        'paid_at' => 'required',
        'date' => '',
        'tranx_no' => '',
        'late_payment' => '',
        'remainder' => '',
        'status' => '',
    ]);

        $bill->update($data);

        return redirect()->back()->with('success', 'Successfully Updated !');
    }

    public function updateBankInfo()
    {
        $data = \request()->validate([
            'bank' => '',
            'account' => '',
            'name' => ''
        ]);

        // Bank information JSON file path
        $jsonFilePath = storage_path('app/bankinfo.json');

        // Get the JSON file to update
        $jsonData = File::get($jsonFilePath);

        $bankInfo = json_decode($jsonData, true);

        $update = false;

        foreach ($bankInfo as $index=>$bank){
                if ($bank['bank'] == $data['bank']){
                    $update = true;
                    $bankInfo[$index] = $data;
                }
        }

        if (!$update){
            // Add the new data to the $bankInfo array
            $bankInfo[] = $data;

            // Write data to the JSON file
            File::put($jsonFilePath, json_encode($bankInfo, JSON_PRETTY_PRINT));

            return redirect()->back()->with('success', 'Successfully Added!');
        }
        else{

            // Write data to the JSON file
            File::put($jsonFilePath, json_encode($bankInfo, JSON_PRETTY_PRINT));

            return redirect()->back()->with('success', 'Successfully Updated!');
        }


    }

    public function getBankInfo()
    {
        // Bank information JSON file path
        $jsonFilePath = storage_path('app/bankinfo.json');

        $jsonData = File::get($jsonFilePath);

        $bankInfo = json_decode($jsonData, true);

        return $bankInfo;
    }

    public function deleteBankInfo($id)
    {
        $bankInfo = $this->getBankInfo();
        unset($bankInfo[$id]);

        $bankInfo = array_values($bankInfo);

        // Bank information JSON file path
        $jsonFilePath = storage_path('app/bankinfo.json');

        // Write data to the JSON file
        File::put($jsonFilePath, json_encode($bankInfo, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Successfully Deleted!');

    }

    public static function countBankInfos(): int
    {
        // Bank information JSON file path
        $jsonFilePath = storage_path('app/bankinfo.json');

        $jsonData = File::get($jsonFilePath);

        $bankInfo = json_decode($jsonData, true);

        return count($bankInfo);
    }
}
