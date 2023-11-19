@extends('layouts.nav-less')

@section('content')
    <div class="center">
        <div class="card w-auto">
            <div class="card-header text-bg-primary title-header "> Create Profile</div>

            <div class="card-body">
                <form method="POST" action="/profile" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="">
                            <div class="row mb-3">
                                <label for="profile_pic" class="col-md-4 col-form-label text-md-end"> Profile Picture </label>

                                <div class="col-md-6">
                                    <input id="profile_pic" type="file"
                                           class="form-control  @error('profile_pic') is-invalid @enderror"
                                           name="profile_pic" value="{{ old('profile_pic') ?? session('profile_pic')}}" required
                                           autofocus>

                                    @error('profile_pic')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="first_name" class="col-md-4 col-form-label text-md-end"> First Name </label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                           class="form-control  text-uppercase   @error('first_name')  is-invalid @enderror"
                                           name="first_name" value="{{ old('first_name') ?? session('first_name')}}" required
                                           autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror

                                    @if(session()->has('error'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('errors') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-end"> Middle(Father)
                                    Name </label>

                                <div class="col-md-6">
                                    <input id="middle_name" type="text"
                                           class="form-control  text-uppercase  @if(session()->has('error')) is-invalid @endif @error('middle_name') is-invalid @enderror"
                                           name="middle_name" value="{{ old('middle_name') ?? session('middle_name') }}"
                                           required autofocus>

                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @if(session()->has('error'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('errors') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end"> Last Name </label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                           class="form-control  text-uppercase  @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ old('last_name') ?? session('last_name')}}" required
                                           autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="dob" class="col-md-4 col-form-label text-md-end"> Date of Birth </label>

                                <div class="col-md-6">
                                    <input id="dob" type="date"
                                           class="form-control  text-uppercase  @error('dob') is-invalid @enderror"
                                           name="dob" value="{{ old('dob') ?? session('dob')}}"
                                           max="{{ \Carbon\Carbon::now()->subYear()->format('Y-m-d') }}"
                                           required autofocus>

                                    @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gender" class="col-md-4 form-check text-md-end"> Gender </label>

                                <div class="col-md-6 ">
                                    <label for="male" class="col-md-4 form-check-label text-md-end"> Male </label>
                                    <input id="male" type="radio"
                                           class="form-check-input @error('last_name') is-invalid @enderror" name="gender"
                                           value="male" {{ old('gender') == 'male' || session('gender') == 'male' ? 'checked': ''}} >

                                    <label for="female" class="col-md-4 form-check-label text-md-end"> Female </label>
                                    <input id="female" type="radio"
                                           class="form-check-input @error('last_name') is-invalid @enderror" name="gender"
                                           value="female" {{ old('gender') == 'female' || session('gender') == 'female' ? 'checked': ''}} >

                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <div class="row mb-3">
                                <label for="mother_name" class="col-md-4 col-form-label text-md-end"> Mother Full Name </label>

                                <div class="col-md-6">
                                    <input id="mother_name" type="text"
                                           class="form-control  text-uppercase @error('mother_name') is-invalid @enderror"
                                           name="mother_name" value="{{ old('mother_name') ?? session('mother_name')}}" required
                                           autofocus>

                                    @error('mother_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="current_guardian" class="col-md-4 col-form-label text-md-end"> Current Guardian
                                    Name </label>

                                <div class="col-md-6">
                                    <input id="current_guardian" type="text"
                                           class="form-control text-uppercase @error('current_guardian') is-invalid @enderror"
                                           name="current_guardian"
                                           value="{{ old('current_guardian') ?? session('current_guardian')}}" required
                                           autofocus>

                                    @error('current_guardian')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="guardian_address" class="col-md-4 col-form-label text-md-end"> Current Guardian
                                    Address </label>

                                <div class="col-md-6">
                                    <input id="guardian_address" type="text"
                                           class="form-control @error('guardian_address') is-invalid @enderror"
                                           name="guardian_address"
                                           value="{{ old('guardian_address') ?? session('guardian_address')}}" required
                                           autofocus>

                                    @error('guardian_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="guardian_phone" class="col-md-4 col-form-label text-md-end"> Current Guardian Phone
                                    No. </label>

                                <div class="col-md-6">
                                    <input id="guardian_phone" type="text"
                                           class="form-control @error('guardian_phone') is-invalid @enderror"
                                           name="guardian_phone" value="{{ old('guardian_phone') ?? session('guardian_phone')}}"
                                           required autofocus>

                                    @error('guardian_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="classroom_id" class="col-md-4 col-form-label text-md-end">Class Room</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <label>
                                            <select id="classroom_id"
                                                    class="form-control dropdown-input @error('classroom_id') is-invalid @enderror"
                                                    name="classroom_id" required>
                                                <option disabled selected>Child's Classroom</option>
                                                @foreach($classrooms as $classroom)
                                                    <option
                                                        value="{{ $classroom->classroom_name }}" {{ old('classroom_id') == $classroom->classroom_name || session('classroom_id') == $classroom->classroom_name ? 'selected' : '' }}>
                                                        {{ $classroom->classroom_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom_id')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-md-6 logo-center">
                            <a href="{{ route('register.show') }}" class="btn btn-dark">
                                Back
                            </a>
                        </div>
                        <div class="col-md-6 logo-center">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
