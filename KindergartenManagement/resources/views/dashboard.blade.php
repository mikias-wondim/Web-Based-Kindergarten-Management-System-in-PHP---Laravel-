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
                     src="{{ asset('storage/'.Auth::user()->profile->profile_pic) }}" alt="profile-pic">
            </div>
            <div class="center flex-column w-fit">
                <div class="center flex-column">
                    <h2 class="mb-0 dark-text">
                        {{ucwords(Auth::user()->profile->first_name) }}
                    </h2>
                    <small class="text-center orange-text w-100">{{ucwords(Auth::user()->role)}}</small>
                </div>
                <a href="/profile/{{Auth::user()->profile->id}}" class="btn text-warning mx-2">View</a>
            </div>

        </div>

        <div class="items">
            <ul class="grid-view">
                <li class="item">
                    <a href="/profile/{{auth()->user()->profile->id}}" class="top">
                        <div class="box-icon"><i class="bx bxs-user-account"></i></div>
                        <div class="title">
                            <small class="small">View</small>
                            <span class="item-name">Profile</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            View profile including
                            <span class="desc-strong">Personal information </span> along
                            with
                            <span class="desc-strong">health and emergency</span> contacts
                            information.
                        </p>
                    </div>
                </li>
                <li class="item">
                    <a href="/progress/{{auth()->user()->profile->id}}" class="top">
                        <div class="box-icon"><i class="bx bx-line-chart"></i></div>
                        <div class="title">
                            <small class="small">View</small>
                            <span class="item-name">Progress Report </span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            In the page you can see
                            <span class="desc-strong">Academic, Behavioural</span> progress
                            and <span class="desc-strong"> Attendance report</span>.
                        </p>
                    </div>
                </li>
                <li class="item">
                    <a href="/noticeboard/classroom/{{ auth()->user()->profile->classroom->id }}" class="top">
                        <div class="box-icon"><i class="bx bxs-bell"></i></div>
                        <div class="title">
                            <small class="small">View</small>
                            <span class="item-name">Notices</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            Upcoming <span class="desc-strong">events</span>,
                            <span class="desc-strong">assignment</span>, and other
                            notification from the home room teacher or the school principal.
                        </p>
                    </div>
                </li>
                <li class="item">
                    <a href="/bill-record/{{auth()->user()->profile->id}}" class="top">
                        <div class="box-icon"><i class="bx bx-dollar-circle"></i></div>
                        <div class="title">
                            <small class="small">View</small>
                            <span class="item-name">Billing Report</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            Tuition payment and
                            <span class="desc-strong">bill report</span>, and as well
                            <span class="desc-strong">deadline</span> checking panel
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
                            with Teacher, School Director Accountants in real time.
                        </p>
                    </div>
                </li>
                <li class="item">
                    <a href="/schedule/{{auth()->user()->profile->classroom->id }}" class="top">
                        <div class="box-icon"><i class='bx bxs-calendar'></i></div>
                        <div class="title">
                            <small class="small">View</small>
                            <span class="item-name">Class Schedule</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            See this week's class <span class="desc-strong">schedule</span>  prepared by the homeroom teacher and prepare you child for the upcoming lessons.
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </main>
    <!-- MAIN -->
    <!-- CONTENT -->
@endsection
