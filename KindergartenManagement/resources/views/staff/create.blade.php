@extends('layouts.nav-less')

@section('content')
    <div class="center">
        <div class="card w-auto">
            <div class="card-header text-bg-primary title-header "> Create {{ ucwords(session('role'))  }} / Staff</div>

            <div class="card-body">
                <form method="POST" action="/staff" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="">
                            <div class="row mb-3">
                                <label for="profile_pic" class="col-md-4 col-form-label text-md-end"> Profile
                                    Picture </label>

                                <div class="col-md-6">
                                    <input id="profile_pic" type="file"
                                           class="form-control  @error('profile_pic') is-invalid @enderror"
                                           name="profile_pic" value="{{ old('profile_pic') ?? session('profile_pic')}}"
                                           required
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
                                           class="form-control  text-uppercase  @error('first_name') is-invalid @enderror"
                                           name="first_name" value="{{ old('first_name') ?? session('first_name')}}"
                                           required
                                           autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="middle_name" class="col-md-4 col-form-label text-md-end"> Middle(Father)
                                    Name </label>

                                <div class="col-md-6">
                                    <input id="middle_name" type="text"
                                           class="form-control  text-uppercase  @error('middle_name') is-invalid @enderror"
                                           name="middle_name" value="{{ old('middle_name') ?? session('middle_name') }}"
                                           required autofocus>

                                    @error('middle_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name" class="col-md-4 col-form-label text-md-end"> Last Name </label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                           class="form-control  text-uppercase  @error('last_name') is-invalid @enderror"
                                           name="last_name" value="{{ old('last_name') ?? session('last_name')}}"
                                           required
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
                                           max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
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
                                           class="form-check-input @error('gender') is-invalid @enderror"
                                           name="gender"
                                           value="male" {{ old('gender') == 'male' || session('gender') == 'male' ? 'checked': ''}} >

                                    <label for="female" class="col-md-4 form-check-label text-md-end"> Female </label>
                                    <input id="female" type="radio"
                                           class="form-check-input @error('gender') is-invalid @enderror"
                                           name="gender"
                                           value="female" {{ old('gender') == 'female' || session('gender') == 'female' ? 'checked': ''}} >

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end"> Current
                                    Address </label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                           class="form-control @error('address') is-invalid @enderror"
                                           name="address" value="{{ old('address') ?? session('guardian_address')}}"
                                           required
                                           autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone" class="col-md-4 col-form-label text-md-end"> Phone No. </label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           name="phone" value="{{ old('phone') ?? session('phone')}}" required
                                           autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="">


                            @if(session('role') === 'teacher')
                                <div class="row mb-3">
                                    <label for="classroom_id" class="col-md-4 col-form-label text-md-end">Assigned Class Room (Optional)</label>

                                    <div class="col-md-6">
                                        <div class="dropdown">
                                            <label>
                                                <select id="classroom_id"
                                                        class="form-control dropdown-input @error('classroom_id') is-invalid @enderror"
                                                        name="classroom_id">
                                                    <option disabled selected>Classroom</option>
                                                    @foreach($classrooms as $classroom)
                                                        <option
                                                            value="{{ $classroom->id }}" {{ (old('classroom_id') == $classroom->id || session('classroom_id') == $classroom->id) ? 'selected' : '' }}>
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
                            @endif

                            <div class="row mb-3">
                                <label for="qualification"
                                       class="col-md-4 col-form-label text-md-end">Qualification</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <label>
                                            <select id="qualification"
                                                    class="form-control dropdown-input @error('qualification') is-invalid @enderror"
                                                    name="qualification" required>
                                                <option disabled selected>Qualification</option>

                                                <option
                                                    value="Diploma" {{ old('qualification') == 'Diploma' || session('qualification') == 'Diploma' ? 'selected' : '' }}>
                                                    Diploma
                                                </option>

                                                <option
                                                    value="Degree" {{ old('qualification') == 'Degree' || session('qualification') == 'Degree' ? 'selected' : '' }}>
                                                    Degree
                                                </option>

                                                <option
                                                    value="Masters" {{ old('qualification') == 'Masters' || session('qualification') == 'Masters' ? 'selected' : '' }}>
                                                    Masters
                                                </option>

                                                <option
                                                    value="Ph.D" {{ old('qualification') == 'Ph.D' || session('qualification') == 'Ph.D' ? 'selected' : '' }}>
                                                    Ph.D
                                                </option>

                                            </select>
                                            @error('qualification')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="certificate" class="col-md-4 col-form-label text-md-end"> Certification
                                    Image </label>

                                <div class="col-md-6">
                                    <input id="certificate" type="file"
                                           class="form-control  @error('certificate') is-invalid @enderror"
                                           name="certificate" value="{{ old('certificate') ?? session('certificate')}}"
                                           required autofocus>

                                    @error('certificate')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_of_hire" class="col-md-4 col-form-label text-md-end"> Date of
                                    Hire </label>

                                <div class="col-md-6">
                                    <input id="date_of_hire" type="date"
                                           class="form-control  text-uppercase  @error('dob') is-invalid @enderror"
                                           name="date_of_hire"
                                           value="{{ old('date_of_hire') ?? session('date_of_hire')}}"
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           required autofocus>

                                    @error('date_of_hire')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="salary" class="col-md-4 col-form-label text-md-end"> Salary </label>

                                <div class="col-md-6">
                                    <input id="salary" type="number"
                                           class="form-control text-uppercase @error('salary') is-invalid @enderror"
                                           name="salary" value="{{ old('salary') ?? session('salary')}}" required
                                           min="500"
                                           autofocus>

                                    @error('salary')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="status"
                                       class="col-md-4 col-form-label text-md-end">Status</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <label>
                                            <select id="status"
                                                    class="form-control dropdown-input @error('status') is-invalid @enderror"
                                                    name="status" required>
                                                <option disabled selected>Work Status</option>

                                                <option
                                                    value="Active" {{ old('status') == 'Active' || session('status') == 'Active' ? 'selected' : '' }}>
                                                    Active
                                                </option>

                                                <option
                                                    value="Vacation" {{ old('status') == 'Vacation' || session('status') == 'Vacation' ? 'selected' : '' }}>
                                                    Vacation
                                                </option>

                                                <option
                                                    value="Blocked" {{ old('status') == 'Blocked' || session('status') == 'Blocked' ? 'selected' : '' }}>
                                                    Blocked
                                                </option>


                                            </select>
                                            @error('status')
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

                    <div class="row mt-3">
                        <div class="col-md-6 logo-center">
                            <a href="{{ route('register.staff') }}" class="btn btn-dark">
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
