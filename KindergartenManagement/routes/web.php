<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BillRecordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HealthEmergInfoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeboardController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchoolFeeController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where web routes for your application are register. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', function () {
    return view('auth/login');
});

Auth::routes();

//Dashboard Redirect
Route::get('/home', [HomeController::class, 'index']
)->name('home');

Route::get('/director-dashboard', function (){
    return view('dashboard/school-director');
})->name('dashboard.director');

Route::get('/teacher-dashboard', function (){
    return view('dashboard/teacher');
})->name('dashboard.teacher');

Route::get('/accountant-dashboard', function (){
    return view('dashboard/accountant');
})->name('dashboard.accountant');

Route::get('/reception-dashboard', function (){
    return view('dashboard/reception');
})->name('dashboard.reception');

Route::get('/admin-dashboard', function (){
    return view('dashboard/system-admin');
})->name('dashboard.admin');

// Registration
Route::get('/register', function () {
    return view('register/child-register');
})->name('register.show');

Route::post('/register', [RegistrationController::class, 'store']
)->name('register.create');

Route::get('/staff-register', function () {
    return view('register/staff-register');
})->name('register.staff');


// Account Management Route
Route::get('/all-users', [AccountController::class, 'index'])->name('account.show');

Route::patch('/accounts/{user}', [AccountController::class, 'update'])->name('account.update');

// Password Change
Route::get('password/change', [ChangePasswordController::class, 'show'])->name('password.change');

Route::post('password/change', [ChangePasswordController::class, 'update'])->name('password.update');

// Password Reset
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::post('password/reset', [ResetPasswordController::class, 'reset']);


// Staff Routes
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');

Route::get('/staff/{role}', [StaffController::class, 'index'])->name('staff.index');

Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

Route::get('/staff/show/{staff}', [StaffController::class, 'show'])->name('staff.show');

Route::get('/staff/accountant/{staff}', [StaffController::class, 'showAccountant'])->name('staff.showAccountant');

Route::get('/staff/reception/{staff}', [StaffController::class, 'showDirector'])->name('staff.showReception');

Route::get('/staff/director/{staff}', [StaffController::class, 'showDirector'])->name('staff.showDirector');

Route::get('/staff/admin/{staff}', [StaffController::class, 'showDirector'])->name('staff.showAdmin');

Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');

Route::patch('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');

Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');


// Child Profile Routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');

Route::get('/profile/classroom/{classroom}', [ProfileController::class, 'indexSpecific'])->name('profile.index.classroom');

Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

Route::get('/profile/{profile}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::patch('/profile/{profile}', [ProfileController::class, 'update'])->name('profile.update');

Route::delete('/profile/{profile}', [ProfileController::class, 'destroy'])->name('profile.destroy');


// Health and Emergency Information Routes
Route::post('/healthemergeinfo', [HealthEmergInfoController::class, 'store'])->name('healthemergeinfo.store');

Route::get('/healthemergeinfo/create', [HealthEmergInfoController::class, 'create'])->name('healthemergeinfo.create');

Route::get('/healthemergeinfo/{profile}/edit', [HealthEmergInfoController::class, 'edit'])->name('healthemergeinfo.edit');

Route::patch('/healthemergeinfo/{healthinfo}', [HealthEmergInfoController::class, 'update'])->name('healthemergeinfo.update');


// Progress Report Routes
Route::get('/progress/{profile}', [ProgressController::class, 'show'])->name('progress.show');

Route::get('/progress/{profile}/edit', [ProgressController::class, 'edit'])->name('progress.edit');

Route::patch('/progress/{profile}', [ProgressController::class, 'update'])->name('progress.update');

Route::patch('/grade/{grade}/update', [GradeController::class, 'update'])->name('grade.update');


// Attendance Routes
Route::patch('/attendance/{attendance}/update', [AttendanceController::class, 'update'])->name('attendance.update');

Route::post('/attendance/{profile}/create', [AttendanceController::class, 'create'])->name('attendance.create');

Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');


// Classroom Routes
Route::get('/classroom', [ClassroomController::class, 'index'])->name('classroom.index');

Route::get('/classroom/create', [ClassroomController::class, 'create'])->name('classroom.create');

Route::get('/classroom/{classroom}/assign', [ClassroomController::class, 'assign'])->name('classroom.assign');

Route::post('/classroom/assign', [ClassroomController::class, 'assigned'])->name('classroom.assigned');

Route::patch('/classroom/unassign', [ClassroomController::class, 'unassigned'])->name('classroom.unassigned');

Route::post('/classroom', [ClassroomController::class, 'store'])->name('classroom.store');

Route::patch('/classroom/{classroom}', [ClassroomController::class, 'update'])->name('classroom.update');

Route::get('/classroom/{classroom}/edit', [ClassroomController::class, 'edit'])->name('classroom.edit');

Route::delete('/classroom/{classroom}', [ClassroomController::class, 'destroy'])->name('classroom.destroy');


// Schedule Routes
Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');

Route::get('/schedule/{schedule}', [ScheduleController::class, 'show'])->name('schedule.show');

Route::patch('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');


// Assignment Routes
Route::get('/assignment/{classroom}/create', [AssignmentController::class, 'create'])->name('assignment.create');

Route::post('/assignment/{classroom}', [AssignmentController::class, 'store'])->name('assignment.store');

Route::get('/assignment/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignment.edit');

Route::patch('/assignment/{assignment}', [AssignmentController::class, 'update'])->name('assignment.update');

Route::delete('/assignment/{assignment}', [AssignmentController::class, 'destroy'])->name('assignment.destroy');


// Noticeboard
Route::get('/noticeboard', [NoticeBoardController::class, 'index'])->name('noticeboard.index');

Route::get('/noticeboard/{classroom}', [NoticeboardController::class, 'show'])->name('noticeboard.show');

Route::get('/notice/create', [NoticeController::class, 'create'])->name('notice.create');

Route::post('/notice', [NoticeController::class, 'store'])->name('notice.store');

Route::get('/notice/{notice}/edit', [NoticeController::class, 'edit'])->name('notice.edit');

Route::patch('/notice/{notice}', [NoticeController::class, 'update'])->name('notice.update');

Route::delete('/notice/{notice}', [NoticeController::class, 'destroy'])->name('notice.destroy');


//Billing Records and Bank Information
Route::get('/bill-record', [BillRecordController::class, 'index'])->middleware('auth')->name('bill-record.index');

Route::get('/bank-info', [BillRecordController::class, 'index'])->middleware('auth')->name('bill-record.index');

Route::get('/bill-record/{profile}', [BillRecordController::class, 'show'])->middleware('auth')->name('bill-record.show');

Route::get('/bill-record/{profile}/edit', [BillRecordController::class, 'edit'])->middleware('auth')->name('bill-record.edit');

Route::patch('/bill-record/{bill}', [BillRecordController::class, 'update'])->middleware('auth')->name('bill-record.update');

Route::patch('/bankinformation', [BillRecordController::class, 'updateBankInfo'])->name('bill-record.bankinfo.update');

Route::delete('/bankinformation/{id}', [BillRecordController::class, 'deleteBankInfo'])->name('bill-record.bankinfo.delete');


// School Fee Information
Route::patch('/schoolfee', [SchoolFeeController::class, 'update'])->name('schoolfee.update');

Route::get('/schoolfee', [SchoolFeeController::class, 'index'])->name('schoolfee.index');


// Admission
Route::get('/admission', [AdmissionController::class,  'create'])->name('admission');

Route::post('/admission', [AdmissionController::class,  'store'])->name('admission.store');

Route::get('/admission/index', [AdmissionController::class,  'index'])->name('admission.index');

Route::get('/admission/{admission}', [AdmissionController::class,  'show'])->name('admission.show');

Route::post('/admission/{admission}', [AdmissionController::class,  'update'])->name('admission.update');

Route::delete('/admission/{admission}', [AdmissionController::class,  'destroy'])->name('admission.destroy');


// Contact Message
Route::get('/contact-message', [ContactMessageController::class, 'index'])->name('contact.index');

Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::delete('/contact-message/{contact}', [ContactMessageController::class, 'destroy'])->name('contact.destroy');


// Chat Messages
Route::get('/chat', [ChatMessageController::class, 'index'])->middleware('auth')->name('chat.index');

Route::get('/chat/{chat}', [ChatMessageController::class, 'show'])->middleware('auth')->name('chat.show');

Route::get('/get-users/{role}', [ChatMessageController::class, 'getUsers'])->middleware('auth')->name('chat.get.users');

Route::get('/chat/user/{user}', [ChatMessageController::class, 'getChat'])->middleware('auth')->name('chat.get.chat');

Route::post('/search', [ChatMessageController::class, 'search'])->middleware('auth')->name('chat.search');

Route::post('/chat', [ChatMessageController::class, 'store']);

Route::post('/chat/message-file', [ChatMessageController::class, 'storeFile']);


// Download a file
Route::get('noticeboard/download/pdf/{filename}', [NoticeboardController::class, 'download'])->name('download.file');

Route::get('message/download/file/{filename}', [ChatMessageController::class, 'download'])->name('download.file');
