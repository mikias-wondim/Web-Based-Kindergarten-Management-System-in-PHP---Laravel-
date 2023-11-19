@extends('layouts.app')

@section('content')
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Staff</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Profile</a>
                    </li>
                </ul>
            </div>
        </div>

        <section id="student-information">
            <div class="profile-img">
                <div class="avatar">
                    <img src="{{ asset('storage/'.$staff->profile_pic) }}" alt="Student Photo"/>
                </div>
                <h5 class="center">{{ ucwords($staff->user->role) }}</h5>
                <h2 class="heading">{{ ucwords($staff->first_name )}} </h2>


                @if(auth()->user()->staff->user->role == 'school director')
                    <div class="center">
                        <p class="d-flex justify-content-center m4-2">
                            <a href="/staff/{{ $staff->id }}/edit" class="btn btn-primary"><i
                                    class='bx bx-edit-alt'></i> Edit <span class="show-detail">Profile</span></a>
                        </p>
                    </div>
                @endif
            </div>

            <div class="container nunito">
                <div class="d-flex justify-content-center flex-wrap">
                    <div class="profile card w-100" style="height: fit-content">
                        <div class="card-content">
                            <div class="card-detail">
                                <div class="info">
                                    <h3 class="sub-heading">Personal Information</h3>
                                    <div class="section">
                                        <div class="side">
                                            <p class="capitalize d-flex justify-content-between"><span>Full Name: </span> <strong> {{ ucwords($staff->first_name." ".$staff->middle_name) . " " . $staff->last_name }} </strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span>First Name:</span>  <strong> {{ $staff->first_name  }}</strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span>Middle Name:</span> <strong> {{ $staff->middle_name  }}</strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span>Last Name:</span>  <strong> {{ $staff->last_name  }}</strong></p>
                                        </div>
                                        <div class="side">
                                            <p class="capitalize d-flex justify-content-between"><span> Date of Birth: </span> <strong> {{ $staff->dob  }}</strong>
                                            </p>
                                            <p class="capitalize d-flex justify-content-between"><span> Age: </span>
                                                <strong> {{ \Carbon\Carbon::parse($staff->dob)->diffInYears(\Carbon\Carbon::now()) }}</strong>
                                            </p>
                                            <p class="capitalize d-flex justify-content-between"><span> Gender:  </span> <strong> {{ $staff->gender  }}</strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span> Address: </span> <strong> {{ $staff->address }}</strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span> Phone: </span>  <strong> {{ $staff->phone }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile card w-100" style="height: fit-content">
                        <div class="card-content">
                            <div class="card-detail">
                                <div class="info">
                                    <div class="section">
                                        <div class="side">
                                            <h3 class="sub-heading">{{ ucwords($staff->user->role) }} Information</h3>
                                            <p class="capitalize d-flex justify-content-between"><span>{{ucwords($staff->user->role)}} ID: </span>

                                                @if($staff->user->role == 'school director')
                                                    <strong class="text-end"> {{ $staff->user->role."/".$staff->schoolDirector->id }}</strong>
                                                @elseif($staff->user->role == 'reception')
                                                    <strong class="text-end"> {{ $staff->user->role."/".$staff->reception->id }}</strong>
                                                @elseif($staff->user->role == 'system admin')
                                                    <strong class="text-end"> {{ $staff->user->role."/".$staff->systemAdmin->id }}</strong>
                                                @endif

                                            </p>
                                            <p class="capitalize d-flex justify-content-between"><span> Assigned Classroom: </span>  <strong>
                                                    @if($staff->teacher->classroom) {{ $staff->teacher->classroom->classroom_name }} @else Unassigned @endif
                                                </strong></p>
                                            <p class="capitalize d-flex justify-content-between"><span>Qualification: </span>
                                                <strong> {{ $staff->qualification }}</strong>
                                            </p>
                                            <p class="capitalize d-flex justify-content-between"><span> Hired Date: </span>
                                                <strong> {{ $staff->date_of_hire }}</strong></p>
                                            @auth()
                                                @if(auth()->user()->role != 'child')
                                                    <p class="capitalize d-flex justify-content-between"><span> Salary: </span>
                                                        <strong> {{ $staff->salary  }}</strong></p>
                                                @endif
                                            @endauth
                                            <p class="capitalize d-flex justify-content-between"><span> Status: </span>  <strong> {{ $staff->status  }}</strong></p>
                                        </div>
                                        <div class="side">
                                            <h3 class="sub-heading">Certification Image</h3>
                                            <small class="bg-opacity-10 bg-dark p-1 position-absolute mx-1">Click
                                                image to view</small>
                                            <a target="_blank"
                                               class="center"
                                               href="{{ asset('storage/'. $staff->certificate) }}">
                                                <img
                                                    class="h"
                                                    style="height: 350px; object-fit: contain"
                                                    src="{{ asset('storage/'. $staff->certificate) }}"
                                                    alt="cert image"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $role = auth()->user()->role;
                        $dashboard = match ($role) {
                                        'child' => '/home',
                                        'teacher' => '/teacher-dashboard',
                                        'system admin' => '/admin-dashboard',
                                        'accountant' => '/accountant-dashboard',
                                        'school director' => '/director-dashboard',
                                        'reception' => '/reception-dashboard',
                                        default => '/',
                                    };
                    @endphp

                    <div class="center">
                        <a href="{{ $dashboard }}" class="btn btn-primary">
                            Back to Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- MAIN -->

@endsection
