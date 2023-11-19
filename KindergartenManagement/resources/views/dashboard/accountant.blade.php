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
                        <ul class="px-0 box-info dashboard">
                            <li class="border border-light">
                                <i class="bx bxs-user-account"></i>
                                @php
                                    $profile = new \App\Http\Controllers\ProfileController()
                                @endphp
                                <span class="text"> <h1>{{ $profile::countAllChildren() }}</h1> <p class="text-dark fs-5">Total Children</p></span>
                            </li>
                            <li class="border border-light">
                                <i class="bx bxs-group"></i>
                                @php
                                    $bankInfo = new \App\Http\Controllers\BillRecordController()
                                @endphp
                                <span class="text"> <h1>{{ $bankInfo::countBankInfos() }}</h1> <p class="text-dark fs-5">Bank Information</p></span>
                            </li>
                        </ul>

                </div>

                <hr style="width: 75%; margin: 10px auto">

                <div class="items">
                    <ul class="grid-view">
                        <li class="item">
                            <a href="/profile" class="top">
                                <div class="box-icon"><i class='bx bxs-dollar-circle' ></i></div>
                                <div class="title ">
                                    <small class="small">Track</small>
                                    <span class="item-name">Bill Information</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage children financial information including updating and deleting of
                                    <span class="desc-strong"> Monthly Payment Records </span>.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/schoolfee" class="top">
                                <div class="box-icon"><i class='bx bxs-book-content'></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">School Fee Information</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage <span class="desc-strong"> School Fee Information</span> for each program and for each month including <span class="desc-strong">Due Date and Amount</span>.
                                </p>
                            </div>
                        </li>
                        <li class="item">
                            <a href="/bank-info" class="top">
                                <div class="box-icon"><i class='bx bxs-bank'></i></div>
                                <div class="title">
                                    <small class="small">Manage</small>
                                    <span class="item-name">Bank Information</span>
                                </div>
                            </a>
                            <div class="desc">
                                <p>
                                    Manage <span class="desc-strong"> Bank Account Information</span> like account numbers and holder names,.
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
