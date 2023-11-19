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
                <a href="/staff/director/{{Auth::user()->staff->id}}" class="btn text-warning mx-2">View</a>
            </div>

        </div>

        @php
            $admission = new \App\Http\Controllers\AdmissionController();
            $children = new \App\Http\Controllers\ProfileController()

        @endphp

        <div class="p-3" style="background: var(--light); border-radius: 5px">
            <ul class="px-0 box-info dashboard">
                <li class="border border-light">
                    <i class="bx bxs-group"></i>
                    <span class="text"> <h1>{{ $children::countAllChildren() }}</h1> <p
                            class="text-dark fs-5">Approved Admission</p></span>
                </li>
                <li class="border border-light">
                    <i class="bx bxs-user-account"></i>
                    <span class="text"> <h1>{{ $admission::countAdmission() }}</h1> <p
                            class="text-dark fs-5">Total Admission</p></span>
                </li>
                <li class="border border-light">
                    <i class="bx bxs-phone"></i>
                    <span class="text"> <h1>3</h1>
                        <p class="text-dark fs-5">Contact Message</p></span>
                </li>
            </ul>
        </div>

        <hr style="width: 75%; margin: 10px auto">

        <div class="items">
            <ul class="grid-view">
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
                <li class="item">
                    <a href="/admission/index" class="top">
                        <div class="box-icon"><i class="bx bxs-user-account"></i></div>
                        <div class="title ">
                            <small class="small">Manage</small>
                            <span class="item-name">Admission</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            Manage new admitting children and assess their pre profile including like thier
                            <span class="desc-strong"> Personal information </span> along
                            with <span class="desc-strong"> Contacts </span> information.
                        </p>
                    </div>
                </li>
                <li class="item">
                    <a href="/contact-message"
                       class="top">
                        <div class="box-icon"><i class="bx bxs-phone"></i></div>
                        <div class="title">
                            <small class="small">Manage</small>
                            <span class="item-name">Contact Message</span>
                        </div>
                    </a>
                    <div class="desc">
                        <p>
                            Manage contact messages from other users which are trying to <span class="desc-strong"> Contact </span>.
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
