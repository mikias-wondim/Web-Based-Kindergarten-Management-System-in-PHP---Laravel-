@extends('layouts.nav-less')

@section('content')

    @if(session('success'))
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

    @if(session('error'))
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

    <div class="center">
        <div class="card w-auto" >
            <div class="card-header text-bg-primary">Register</div>

            <div class="card-body">
                <form method="POST" action="/register">
                    @csrf

                    <div class="row mb-3">
                        <label for="unique_name"
                               class=" col-form-label text-md-start">{{ __('Unique Name') }}</label>

                        <div class="">
                            <input id="unique_name" type="text"
                                   class="form-control @error('unique_name') is-invalid @enderror" name="unique_name"
                                   value="{{ old('unique_name') ?? session('unique_name')}}" required autocomplete="unique_name" autofocus>

                            @error('unique_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-form-label text-md-start">{{ __('Email Address') }}</label>

                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email')?? session('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role" class="col-form-label text-md-start">{{ __('Role of User') }}</label>

                        <div class="">
                            <div class="dropdown">
                                <label class="center">
                                    <select id="role" type="role"
                                            class="form-control dropdown-input w-100 @error('role') is-invalid @enderror"
                                            name="role" required autocomplete="role">
                                        <option disabled selected>Select User's Role</option>
                                        <option value="child" {{ old('role') == "child" || session('role') == "child"? 'selected' : '' }}>
                                            Child/Student
                                        </option>
                                        <option value="teacher" {{ old('role') == "teacher" || session('role') == "teacher"? 'selected' : '' }}>
                                            Teacher
                                        </option>
                                        <option value="accountant" {{ old('role') == "accountant" || session('role') == "accountant"? 'selected' : '' }}>
                                            Accountant
                                        </option>
                                        <option
                                            value="school director" {{ old('role') == "school director" || session('role') == "school director"? 'selected' : '' }}>
                                            School Director
                                        </option>
                                        <option
                                            value="system admin" {{ old('role') == "system admin" || session('role') == "system admin"? 'selected' : '' }}>
                                            System Admin
                                        </option>
                                    </select>
                                </label>
                            </div>

                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    {{--// Password and Confirm Password Fields--}}
                    {{--                        <div class="row mb-3">--}}
                    {{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

                    {{--                            <div class="col-md-6">--}}
                    {{--                                <input id="password" type="hidden" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">--}}

                    {{--                                @error('password')--}}
                    {{--                                    <span class="invalid-feedback" role="alert">--}}
                    {{--                                        <strong>{{ $message }}</strong>--}}
                    {{--                                    </span>--}}
                    {{--                                @enderror--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    {{--                        <div class="row mb-3">--}}
                    {{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>--}}

                    {{--                            <div class="col-md-6">--}}
                    {{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}

                    <div class="center ">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Next') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
