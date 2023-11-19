@extends('layouts.app')

@section('content')
    @if(Session::has('success'))
        <div class="bg-transparent d-flex justify-content-center fixed-bottom mb-3 p-3 ">
            <div id="flash-message" class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            <script>
                setTimeout(function () {
                    document.getElementById('flash-message').classList.add('collapse');
                }, 3000);
            </script>
        </div>
    @endif
            <!-- MAIN -->
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1 class="heading">Dashboard</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="profile center flex-column my-4">
                    <div class="avatar">
                        <img class="rounded-circle"
                             height="75px"
                             src="{{ asset('storage/'.Auth::user()->staff->profile_pic) }}" alt="profile-pic">
                    </div>
                    <div class="center flex-column w-fit">
                        <div class="center flex-column">
                            <h2 class="mb-0 dark-text">
                                {{ucwords(Auth::user()->staff->first_name) }}
                            </h2>
                            <small class="text-center orange-text w-100" >{{ucwords(Auth::user()->role)}}</small>
                        </div>
                        <a href="/staff/director/{{Auth::user()->staff->id}}" class="btn text-warning mx-2">View</a>
                    </div>

                </div>

                <div class="p-3" style="background: var(--light); border-radius: 5px">
                    <ul class="box-info dashboard">
                        <li class="border border-light">
                            <i class="bx bxs-user-account"></i>
                            @php
                                $profile = new \App\Http\Controllers\ProfileController()
                            @endphp
                            <span class="text"> <h3>{{$profile::countAllChildren()}}</h3> <p>Children/Students</p></span>
                        </li>
                        <li class="border border-light">
                            <i class="bx bxs-group"></i>
                            @php
                                $teacher = new \App\Http\Controllers\StaffController()
                            @endphp
                            <span class="text"> <h3>{{ $teacher::countAllTeachers() }}</h3> <p>Teachers</p></span>
                        </li>
                        <li class="border border-light">
                            <i class='bx bxs-door-open'></i>
                            @php
                                $classroom = new \App\Http\Controllers\ClassroomController()
                            @endphp
                            <span class="text"> <h3>{{ $classroom::countClassrooms() }}</h3> <p>Classrooms</p></span>
                        </li>
                    </ul>
                </div>

                <div class="items">
                    <ul class="grid-view">
                        <li class="item">
                            <a href="/profile" class="top">
                                <div class="box-icon"><i class="bx bxs-user-account"></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">Children</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage children profile including registering, editing and deleting of
                                    <span class="desc-strong"> Personal information </span> along
                                    with
                                    <span class="desc-strong"> Health and Emergency </span> contacts
                                    information.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/staff/teacher" class="top">
                                <div class="box-icon"><i class="bx bxs-group"></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">Teachers</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage Teacher information including registering, editing and deleting of
                                    <span class="desc-strong"> Teacher Information </span>.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/noticeboard" class="top">
                                <div class="box-icon"><i class="bx bxs-bell"></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">Notice Board</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Post upcoming <span class="desc-strong">Events</span>,
                                    <span class="desc-strong">Occasions</span>, and other
                                    notification to different classroom and modify posted <span class="desc-strong">Notices</span>.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/classroom" class="top">
                                <div class="box-icon"><i class='bx bxs-door-open'></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">Class Rooms</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage classrooms all over the institute including creating and modifying of
                                    <span class="desc-strong">Classroom</span>, and as well
                                    <span class="desc-strong">Assign Teachers</span>.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/staff-register" class="top">
                                <div class="box-icon"><i class='bx bxs-add-to-queue'></i></div>
                                <div class="title">
                                    <small class="small">New</small>
                                    <span class="item-name">Register</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage registration of <span class="desc-strong"> New Children </span>, and <span class="desc-strong">New Staffs</span> by filling out all necessary information.

                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/chat" class="top">
                                <div class="box-icon"><i class="bx bxs-message-dots"></i></div>
                                <div class="title">
                                    <small class="small">Chat</small>
                                    <span class="item-name">Message Chatting</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Live <span class="desc-strong">Messaging</span> to communicate
                                    with other staffs and child guardians in real time.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </main>
            <!-- MAIN -->
        <!-- CONTENT -->
@endsection
