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

                <div class="bank-info center mb-2">
                    <form action="/classroom/assign" method="POST">
                        @csrf

                        <input type="hidden" name="classroom_id" value="{{ $classroom->id }}">
                        <p class="text-center">Assign teacher for the class</p>
                        <div class="">
                            <label for="teacher_id" class="center"> <h2 class="text-center text-primary">{{ $classroom->classroom_name }}</h2> </label>
                            <select id="teacher_id" name="teacher_id"
                                    class="@error('teacher_id') is-invalid @enderror"
                                    required>
                                <option disabled selected>Select a teacher...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                    @if($classroom->teacher->toArray())
                                        {{ $classroom->teacher[0]['id'] == $teacher->id ? 'selected': '' }}
                                    @endif
                                    >{{ $teacher->staff->first_name ." ". $teacher->staff->middle_name ." ". $teacher->staff->last_name }}</option>
                                @endforeach
                            </select>

                            @error('teacher_id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="center justify-content-around">
                            <a href="/classroom" class="my-2 btn btn-dark">Back</a>

                            <button type="submit" class="my-2 btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>

            </main>
            <!-- MAIN -->
        <!-- CONTENT -->
            <script>
            </script>
@endsection
