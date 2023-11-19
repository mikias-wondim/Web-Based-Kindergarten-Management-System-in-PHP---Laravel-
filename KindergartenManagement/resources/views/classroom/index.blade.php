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
    @elseif(Session::has('error'))
        <div class="bg-transparent d-flex justify-content-center fixed-bottom mb-3 p-3 ">
            <div id="flash-message" class="alert alert-danger">
                {{ Session::get('error') }}
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
                        <h1 class="heading">Classroom Management</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Dashboard</a>
                            </li>
                            <li><i class="bx bx-chevron-right"></i></li>
                            <li>
                                <a class="active" href="#">Classroom Management</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="d-flex justify-content-around">
                    <div class="dropdown">
                        <lable>Filter: </lable>
                        <label>
                            <select id="classroom"
                                    onchange="displayClass()"
                                    class="form-control dropdown-input"
                                    name="classroom" required>
                                <option value="all">All Classroom</option>
                                @php
                                    $class = []
                                @endphp

                                @foreach($classrooms as $classroom)
                                    @if(!in_array(explode(' / ', $classroom->classroom_name)[0], $class))
                                        @php
                                            $class[] = explode(' / ', $classroom->classroom_name)[0]
                                        @endphp
                                        <option
                                            value="{{ explode(' / ', $classroom->classroom_name)[0] }}">
                                            {{ explode(' / ', $classroom->classroom_name)[0]}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <div class="center">
                        <a href="/classroom/create" class="btn btn-primary"> Add <span class="show-detail">Classroom</span> </a>
                    </div>
                </div>

                <hr style="width: 70%; margin: 30px auto 10px auto ">

                <div class="classroom-items">
                    <ul id="class-list" class="p-0 d-flex flex-wrap justify-content-center flex-md-row">
                        @foreach($classrooms as $classroom)
                            <li class="card classroom {{ strtolower(explode(' / ', $classroom->classroom_name)[0])  }} default">
                                <div class="left">
                                    <div class="">
                                        <small class="grey">Classroom / Section</small>
                                        <h2 class="">{{ $classroom->classroom_name }}</h2>
                                    </div>
                                    <div class="">
                                        @php
                                            $classroomController = new \App\Http\Controllers\ClassroomController()
                                        @endphp

                                        <small class="grey">Enrolled Children</small>
                                        <h3 class="text-md-center">{{ $classroomController::getEnrolledChildren($classroom->id) }}</h3>
                                    </div>
                                    <div class="">
                                        <small class="grey">Max Capacity</small>
                                        <h3 class="text-md-center ">{{ $classroom->max_capacity }}</h3>
                                    </div>
                                    <div class="mt-2">
                                        <small class="grey">Assigned Teachers</small>
                                        @if($classroom->teacher->toArray())
                                            @foreach($classroom->teacher as $teacher)
                                                <form class="d-flex" action="/classroom/unassign" method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <h4 class="text-md-center">{{$teacher->staff->first_name ." ". $teacher->staff->middle_name}}
                                                    </h4>
                                                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                    <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                                                    <button type="submit"
                                                            title="Remove Teacher"
                                                            class="border-0 bg-transparent"><i class='bx bx-x-circle' style='color:#ff0000'></i></button>

                                                </form>
                                            @endforeach
                                        @else
                                            <h4 class="text-md-center"><span class="text-warning">Unassigned</span>
                                            </h4>

                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="/classroom/{{ $classroom->id }}/edit" class="btn border-primary text-primary">Edit</a>
                                        <form action="/classroom/{{ $classroom->id }}" method="POST">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn border-danger text-danger">Delete</button>
                                        </form>
                                    </div>
                                    <div class="center mt-2">
                                        <a href="/classroom/{{ $classroom->id }}/assign" class="btn border-warning text-warning bg-opacity-10 bg-white">Assign <span class="show-detail">Teacher</span> </a>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="">
                                        <small class="grey">List of</small>
                                        <h3>Subjects</h3>
                                        <ul class="subjects">
                                            @foreach(explode(',', $classroom->subjects) as $subject)
                                                <li class="rounded-pill">
                                                    {{ $subject }}
                                                </li>
                                            @endforeach
                                        </ul>
                                        <small class="grey">Created At: </small>
                                        <h6 class="text-md-end">{{ Carbon\Carbon::parse($classroom->created_at)->format('l, d-m-Y') }}</h6>
                                    </div>
                                </div>
                            </li>
                        @endforeach


                    </ul>
                </div>

            </main>
            <!-- MAIN -->
        <!-- CONTENT -->
            <script>
                function displayClass(){
                    const classSelection = document.getElementById('classroom');
                    const classList = document.getElementById('class-list');

                    if(classSelection.value === 'all'){
                        classList
                            .querySelectorAll('li.classroom')
                            .forEach((classroom)=>{
                            classroom.classList.remove('collapse')
                        })
                    }else{
                        classList
                            .querySelectorAll('li.classroom')
                            .forEach((classroom)=>{
                            classroom.classList.add('collapse')
                        })

                        const selectedClassrooms = [ ...document.getElementsByClassName(classSelection.value.toLowerCase()) ]

                        selectedClassrooms.forEach((classroom)=>{
                            classroom.classList.remove('collapse')
                        })
                    }
                }
            </script>
@endsection
