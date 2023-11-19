@extends('layouts.app')

@section('content')
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Profile</h1>
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
                    <img src="{{ asset('storage/'.$user->profile->profile_pic) }}" alt="Student Photo"/>
                </div>
                <h2 class="heading">{{ ucwords($user->profile->first_name )}} </h2>

                @if(auth()->user()->role == 'teacher' || auth()->user()->role == 'school director')

                    <div class="">
                        <p class="d-flex flex-column m4-2">
                            @php
                                $returnTo = (auth()->user()->role == 'teacher') ? '/profile/classroom/'.auth()->user()->staff->teacher->classroom->id : '/profile'
                            @endphp
                            <a href="{{ $returnTo }}" class="btn border border-warning w-fit center my-2"><i
                                    class='bx bx-chevron-left'></i> Return <span
                                    class="show-detail"> To Dashboard</span></a>
                            <span class="center">
                                    <a href="/profile/{{ $user->profile->id }}/edit" class="btn btn-primary w-fit my-2"><i
                                            class='bx bx-edit-alt'></i> Edit <span
                                            class="show-detail">Profile</span></a>
                                </span>
                        </p>
                    </div>
                @endif


            </div>

            <div class="container nunito">
                <div class="profile card">
                    <div class="card-content">
                        <div class="card-detail">
                            <div class="info">
                                <h3 class="sub-heading">Student Information</h3>
                                <p class="capitalize">Full Name:
                                    <strong> {{ ucwords($user->profile->first_name." ".$user->profile->middle_name) . " " . $user->last_name }} </strong>
                                </p>
                                <p class="capitalize">Student ID: <strong> {{ $user->id }}</strong></p>
                                <p class="capitalize">First Name: <strong> {{ $user->profile->first_name  }}</strong>
                                </p>
                                <p class="capitalize">Middle Name: <strong> {{ $user->profile->middle_name  }}</strong>
                                </p>
                                <p class="capitalize">Last Name: <strong> {{ $user->profile->last_name  }}</strong></p>
                                <p class="capitalize">Date of Birth: <strong> {{ $user->profile->dob  }}</strong></p>
                                <p class="capitalize">Age:
                                    <strong> {{ \Carbon\Carbon::parse($user->profile->dob)->diffInYears(\Carbon\Carbon::now())  }}</strong>
                                </p>
                                <p class="capitalize">Gender: <strong> {{ $user->profile->gender  }}</strong></p>
                                <p class="capitalize">Class / Section:
                                    <strong> {{ $user->profile->classroom->classroom_name  }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile card">
                    <div class="card-content">
                        <div class="card-detail">
                            <div class="info">
                                <h3 class="sub-heading">Family Information</h3>
                                <p class="capitalize">Mother Name: <strong> {{ $user->profile->mother_name  }}</strong>
                                </p>
                                <p class="capitalize">Father Name: <strong> {{ $user->profile->father_name  }}</strong>
                                </p>
                                <p class="capitalize">Current Guardian:
                                    <strong> {{ $user->profile->current_guardian }}</strong></p>
                                <p class="capitalize">Guardian Address:
                                    <strong> {{ $user->profile->guardian_address  }}</strong></p>
                                <p class="capitalize">Guardian Phone No:
                                    <strong> {{ $user->profile->guardian_phone  }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="profile card">
                    <div class="card-content">
                        <div class="card-detail">
                            <div class="info">
                                <h3 class="sub-heading">Health and Emergency Information</h3>
                                <p class="capitalize">Allergic to:
                                    <strong> {{ $user->profile->healthemergencyinfo->allergies }}</strong></p>
                                <p class="capitalize">Special Needs:
                                    <strong> {{ $user->profile->healthemergencyinfo->special_needs }}</strong></p>
                                <p class="capitalize">Medications:
                                    <strong> {{ $user->profile->healthemergencyinfo->medications }}</strong></p>
                                <p class="capitalize">Blood Type:
                                    <strong> {{ $user->profile->healthemergencyinfo->blood_type }}</strong></p>
                                <p class="capitalize">Emergency Contact Person:
                                    <strong>{{ $user->profile->healthemergencyinfo->contact_name }}</strong></p>
                                <p class="capitalize">Emergency Contact Address:
                                    <strong>{{ $user->profile->healthemergencyinfo->contact_address }}</strong></p>
                                <p class="capitalize">Emergency Contact Phone No.:
                                    <strong> {{ $user->profile->healthemergencyinfo->contact_phone }}</strong></p>
                                @if(auth()->user()->role == 'teacher' || auth()->user()->role == 'school director')
                                    <p class="d-flex justify-content-center m4-2">
                                        <a href="/healthemergeinfo/{{ $user->profile->healthemergencyinfo->id }}/edit"
                                           class="btn btn-primary"><i class='bx bx-edit-alt'></i> Edit <span
                                                class="show-detail"> Information</span></a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            </div>
            <div class="center">
                <a href="/home" class="btn btn-primary">
                    Back to Dashboard
                </a>
            </div>
        </section>
    </main>
    <!-- MAIN -->

@endsection
