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
                        <img src="{{ asset('storage/'.$staff->profile_pic) }}" alt="Student Photo" />
                    </div>
                    <h5 class="center">{{ ucwords($staff->user->role) }}</h5>
                    <h2 class="heading">{{ ucwords($staff->first_name )}} </h2>

                    @if(auth()->user()->staff->role == 'school director')
                        <div class="center">
                            <p class="d-flex justify-content-center m4-2">
                                <a href="/staff/{{ $staff->id }}/edit" class="btn btn-primary"><i class='bx bx-edit-alt'></i> Edit <span class="show-detail">Profile</span></a>
                            </p>
                        </div>
                    @endif
                </div>

                <div class="container nunito">
                    <div class="d-flex justify-content-center flex-wrap">
                    <div class="profile card"  style="height: fit-content">
                        <div class="card-content">
                            <div class="card-detail">
                                <div class="info">
                                    <h3 class="sub-heading">Personal Information</h3>
                                    <p class="capitalize">Full Name: <strong> {{ ucwords($staff->first_name." ".$staff->middle_name) . " " . $staff->last_name }} </strong></p>
                                    <p class="capitalize">First Name: <strong> {{ $staff->first_name  }}</strong></p>
                                    <p class="capitalize">Middle Name: <strong> {{ $staff->middle_name  }}</strong></p>
                                    <p class="capitalize">Last Name: <strong> {{ $staff->last_name  }}</strong></p>
                                    <p class="capitalize">Date of Birth: <strong> {{ $staff->dob  }}</strong></p>
                                    <p class="capitalize">Age: <strong> {{ \Carbon\Carbon::parse($staff->dob)->diffInYears(\Carbon\Carbon::now())  }}</strong></p>
                                    <p class="capitalize">Gender: <strong> {{ $staff->gender  }}</strong></p>
                                    <p class="capitalize">Address <strong> {{ $staff->address }}</strong></p>
                                    <p class="capitalize">Phone <strong> {{ $staff->phone }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile card" style="height: fit-content">
                        <div class="card-content">
                            <div class="card-detail">
                                <div class="info">
                                    <h3 class="sub-heading">{{ ucwords($staff->user->role) }} Information</h3>
                                    <p class="capitalize">{{ucwords($staff->user->role)}} ID: <strong> {{ $staff->user->role."/".$staff->accountant->id }}</strong></p>
                                    <p class="capitalize">Qualification: <strong> {{ $staff->qualification }}</strong></p>
                                    <p class="capitalize">Hired Date: <strong> {{ $staff->date_of_hire }}</strong></p>
                                    @auth()
                                        @if(auth()->user()->role != 'child')
                                            <p class="capitalize">Salary: <strong> {{ $staff->salary  }}</strong></p>
                                        @endif
                                    @endauth
                                    <p class="capitalize">Status: <strong> {{ $staff->status  }}</strong></p>
                                </div>
                                <div class="info">
                                    <h3 class="sub-heading">Certification Image</h3>
                                    <small class="bg-opacity-10 bg-dark p-1 position-absolute mx-1">Click
                                        image to view</small>
                                    <a target="_blank"
                                       class="center"
                                       href="{{ asset('storage/'. $staff->certificate) }}"><img
                                            class="h"
                                            style="height: 350px; object-fit: contain"
                                            src="{{ asset('storage/'. $staff->certificate) }}"
                                            alt="cert image"/></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- MAIN -->

@endsection
