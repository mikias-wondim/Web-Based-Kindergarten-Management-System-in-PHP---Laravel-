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

                <div class="bank-info center mb-2 center flex-wrap">
                        <div class="img-view">
                            <img class="rounded-circle"
                                src="{{ asset('image/alert-img.jpg') }}" height="250" alt="">
                        </div>
                        <div class="text mx-md-2">
                            <h1 class="text-center">You haven't assigned a classroom !</h1>
                        </div>
                </div>
                <div class="center">
                    <a href="/teacher-dashboard" class="btn btn-primary">
                        Return <span class="show-detail"> To Dashboard</span>
                    </a>
                </div>

            </main>
            <!-- MAIN -->
        <!-- CONTENT -->
            <script>
            </script>
@endsection
