@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('content')

    @if(Session::has('success'))
        <div class="bg-transparent d-flex justify-content-center fixed-bottom mb-3 p-3">
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
                <h1 class="heading">Schedule</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="">Schedule</a>
                    </li>
                </ul>
            </div>
        </div>
    </main>
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card report">
                    <div class="card-body">
                        <div class="table-data">
                            <div class="grade">
                                <div class="headline mb-4 d-flex justify-content-between align-items-baseline">
                                    <h3 class="heading">Class Schedule (Weekly)</h3>
                                    <h5 class="blue-text">{{ Carbon::now()->monthName }}, {{ Carbon::now()->year }}</h5>
                                </div>
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="ps-1">Time(LT)</th>
                                        <th class="">Mon<span class="show-detail">day</span></th>
                                        <th class="">Tue<span class="show-detail">sday</span></th>
                                        <th class="">Wed<span class="show-detail">nesday</span></th>
                                        <th class="">Thu<span class="show-detail">rsday</span></th>
                                        <th class="">fri<span class="show-detail">day</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="pe-1">2:00 <span class="show"> – </span> 3:00</td>
                                        @foreach(explode(',', $schedule->two) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">3:00 <span class="show"> – </span> 4:00</td>
                                        @foreach(explode(',', $schedule->three) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">4:00 <span class="show"> – </span> 5:00</td>
                                        @foreach(explode(',', $schedule->four) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">5:00 <span class="show"> – </span> 6:00</td>
                                        @foreach(explode(',', $schedule->five) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">6:00 <span class="show"> – </span> 7:00</td>
                                        @foreach(explode(',', $schedule->six) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">7:00 <span class="show"> – </span> 8:00</td>
                                        @foreach(explode(',', $schedule->seven) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="pe-1">8:00 <span class="show"> – </span> 9:00</td>
                                        @foreach(explode(',', $schedule->eight) as $activity)
                                            <td class="px-1">
                                                {{trim($activity) == 'none' ? 'Free': trim($activity)}}
                                            </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->staff)
                @if(auth()->user()->staff->teacher->classroom->schedule->id == $schedule->id)
                    <div class="center justify-content-between w-50">
                        <a href="/teacher-dashboard" class="btn btn-warning w-fit">Return <span class="show-detail">To Dashboard</span></a>
                        <a href="/schedule/{{$schedule->id}}/edit" class="btn btn-primary w-fit">Edit <span class="show-detail">Schedule</span></a>
                    </div>
                @endif
            @elseif(auth()->user()->profile->classroom->schedule->id == $schedule->id)
                <div class="center w-50">
                    <a href="/home" class="btn btn-warning w-fit">Return <span class="show-detail">To Dashboard</span></a>
                </div>
            @endif
        </div>
    </div>
    <main class="mt-0">
        <div class="table-data">
            <div class="grade">
                <div class="head center justify-content-between">
                    <div>
                        <h1 class="heading">Comment</h1>
                        <p class="text">
                            {{$schedule->comment}}
                        </p>
                    </div>

                    <p class=" fs-5">From
                        <a href="/staff/show/{{$schedule->classroom->teacher[0]->staff->id}}">
                            {{ $schedule->classroom->teacher[0]->staff->first_name }}</a></p>
                </div>
            </div>
        </div>
    </main>

@endsection
