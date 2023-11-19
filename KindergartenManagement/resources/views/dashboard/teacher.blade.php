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
                    <small class="text-center orange-text w-100">{{ucwords(Auth::user()->role)}}</small>
                </div>
                <a href="/staff/show/{{Auth::user()->staff->id}}" class="btn text-warning mx-2">View</a>
            </div>

        </div>

        <div class="p-3" style="background: var(--light); border-radius: 5px">
            @if(auth()->user()->staff->teacher->classroom)
                <ul class="px-0 box-info dashboard">
                    <li class="border border-light">
                        <i class="bx bxs-user-account"></i>
                        <span class="text"> <h1>{{ count(auth()->user()->staff->teacher->classroom->profile) }}</h1> <p
                                class="text-dark fs-5">Enrolled Children</p></span>
                    </li>
                    <li class="border border-light">
                        <i class="bx bxs-group"></i>
                        <span class="text"> <h1>{{ auth()->user()->staff->teacher->classroom->max_capacity }}</h1> <p
                                class="text-dark fs-5">Maximum Capacity</p></span>
                    </li>
                    <li class="border border-light">
                        <i class='bx bxs-door-open'></i>
                        <span class="text"> <h1>
                                        @php
                                            $classroom = auth()->user()->staff->teacher->classroom->id;
                                            $noticeboard = new \App\Http\Controllers\NoticeboardController();
                                        @endphp
                                {{ $noticeboard::countClassNotices($classroom)}}
                                    </h1> <p class="text-dark fs-5">Notices and Assignment Posted</p></span>
                    </li>
                </ul>
            @else
                <div class="center">No Classroom Assigned</div>
            @endif

        </div>

        <hr style="width: 75%; margin: 10px auto">

        <div class="items">
            <ul class="grid-view">

                @if($classroom = auth()->user()->staff->teacher->classroom)

                    <li class="item">
                        <a href="/profile/classroom/{{ $classroom->id }}" class="top">
                            <div class="box-icon"><i class="bx bxs-user-account"></i></div>
                            <div class="title ">
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
                        <a href="/profile/classroom/{{ $classroom->id }}"
                           class="top">
                            <div class="box-icon"><i class="bx bx-line-chart"></i></div>
                            <div class="title">
                                <small class="small">Manage</small>
                                <span class="item-name">Progress Report</span>
                            </div>
                        </a>
                        <div class="desc">
                            <p>
                                Manage children's progress report including subject <span
                                    class="desc-strong">Grades</span>,
                                <span class="desc-strong"> Academical and Behavioural Performance</span> and deleting of
                                <span class="desc-strong"> Teacher Information </span>.
                            </p>
                        </div>
                    </li>

                    <li class="item">
                        <a href="/noticeboard/{{ $classroom->id }}" class="top">
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
                                notification to different classroom and modify posted <span
                                    class="desc-strong">Notices</span>.
                            </p>
                        </div>
                    </li>

                    <li class="item">
                        <a href="/schedule/{{ auth()->user()->staff->teacher->classroom->schedule->id }}" class="top">
                            <div class="box-icon"><i class='bx bxs-calendar'></i></div>
                            <div class="title">
                                <small class="small">Manage</small>
                                <span class="item-name">Class Schedule</span>
                            </div>
                        </a>
                        <div class="desc">
                            <p>
                                Create and Edit weekly
                                <span class="desc-strong">Classroom Schedule</span>, for five
                                <span class="desc-strong">days of the week</span>.
                            </p>
                        </div>
                    </li>

                    <li class="item">
                        <a href="/register" class="top">
                            <div class="box-icon"><i class='bx bxs-add-to-queue'></i></div>
                            <div class="title">
                                <small class="small">New</small>
                                <span class="item-name">Register</span>
                            </div>
                        </a>
                        <div class="desc">
                            <p>
                                Manage registration of <span class="desc-strong"> New Children </span> to the teacher
                                class by filling out all necessary information.
                            </p>
                        </div>
                    </li>
                @endif
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
