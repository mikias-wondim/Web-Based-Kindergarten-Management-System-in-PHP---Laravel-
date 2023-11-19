@extends('layouts.nav-less')

@section('content')
    <div class="center">
        <div class="card w-auto">
            <div class="card-header text-bg-primary title-header "> Edit Staff</div>

            <div class="card-body">
                <form method="POST" action="{{ route('staff.update', ['staff'=>$staff->id]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="">
                            <div class="row mb-3">
                                <div class="avatar center mb-2">
                                    <a href="{{ asset('storage/'.$staff->profile_pic) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$staff->profile_pic) }}" style="height: 60px;"
                                             alt="Student Photo"/></a>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="profile_pic" class="col-md-4 col-form-label text-md-end"> Profile
                                    Picture </label>

                                <div class="col-md-6">
                                    <input id="profile_pic" type="file"
                                           class="form-control  @error('profile_pic') is-invalid @enderror"
                                           name="profile_pic" value="{{ old('profile_pic') ?? $staff->profile_pic}}"
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
                                           name="first_name" value="{{ old('first_name') ?? $staff->first_name}}"
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
                                           name="middle_name" value="{{ old('middle_name') ?? $staff->middle_name}}"
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
                                           name="last_name" value="{{ old('last_name') ?? $staff->last_name}}"
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
                                           name="dob" value="{{ old('dob') ?? $staff->dob}}"
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
                                           value="male" {{ old('gender') == 'male' || $staff->gender == 'male' ? 'checked': ''}} >

                                    <label for="female" class="col-md-4 form-check-label text-md-end"> Female </label>
                                    <input id="female" type="radio"
                                           class="form-check-input @error('gender') is-invalid @enderror"
                                           name="gender"
                                           value="female" {{ old('gender') == 'female' || $staff->gender == 'female' ? 'checked': ''}} >

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
                                <label for="address" class="col-md-4 col-form-label text-md-end"> Current
                                    Address </label>

                                <div class="col-md-6">
                                    <input id="address" type="text"
                                           class="form-control @error('address') is-invalid @enderror"
                                           name="address" value="{{ old('address') ?? $staff->address}}"
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
                                           name="phone" value="{{ old('phone') ?? $staff->phone}}" required
                                           autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @if($staff->user->role === 'teacher')
                                <div class="row mb-3">
                                    <label for="classroom_id" class="col-md-4 col-form-label text-md-end">Assigned Class
                                        Room (Optional) {{ dump($staff->classroom_id) }} </label>

                                    <div class="col-md-6">
                                        <div class="dropdown">
                                            <label>
                                                <select id="classroom_id"
                                                        class="form-control dropdown-input @error('classroom_id') is-invalid @enderror"
                                                        name="classroom_id">
                                                    <option disabled selected>Classroom</option>
                                                    @foreach($classrooms as $classroom)
                                                        <option
                                                            value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->classroom_id || $staff->classroom_id == $classroom->classroom_id ? 'selected' : '' }}>
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
                                                    value="Diploma" {{ old('qualification') == 'Diploma' || $staff->qualification == 'Diploma' ? 'selected' : '' }}>
                                                    Diploma
                                                </option>

                                                <option
                                                    value="Degree" {{ old('qualification') == 'Degree' || $staff->qualification == 'Degree' ? 'selected' : '' }}>
                                                    Degree
                                                </option>

                                                <option
                                                    value="Masters" {{ old('qualification') == 'Masters' || $staff->qualification == 'Masters' ? 'selected' : '' }}>
                                                    Masters
                                                </option>

                                                <option
                                                    value="Ph.D" {{ old('qualification') == 'Ph.D' || $staff->qualification == 'Ph.D' ? 'selected' : '' }}>
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

                            @if(trim($staff->certificate))
                                <div class="row mb-3">
                                    <div class="avatar center mb-2">
                                        <a href="{{ asset('storage/'.$staff->certificate) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$staff->certificate) }}" style="height: 60px;"
                                                 alt="Certificate Image"/></a>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="certificate" class="col-md-4 col-form-label text-md-end"> Certification
                                    Image </label>

                                <div class="col-md-6">
                                    <input id="certificate" type="file"
                                           class="form-control  @error('certificate') is-invalid @enderror"
                                           name="certificate"
                                           autofocus>

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
                                           value="{{ old('date_of_hire') ?? $staff->date_of_hire}}"
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
                                           name="salary" value="{{ old('salary') ?? $staff->salary}}" required
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
                                                    value="Active" {{ old('status') == 'Active' || $staff->status == 'Active' ? 'selected' : '' }}>
                                                    Active
                                                </option>

                                                <option
                                                    value="Vacation" {{ old('status') == 'Vacation' || $staff->status == 'Vacation' ? 'selected' : '' }}>
                                                    Vacation
                                                </option>

                                                <option
                                                    value="Blocked" {{ old('status') == 'Blocked' || $staff->status == 'Blocked' ? 'selected' : '' }}>
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
                            @php
                                $returnTo = match($staff->user->role){
                                    'teacher' => '/staff/show',
                                    'school director' => '/staff/director/',
                                    'reception' => '/staff/reception',
                                    'accountant' => '/staff/accountant',
                                    'system admin' => '/staff/admin',
                                };
                            @endphp

                            <a href="{{ $returnTo }}{{ $staff->id  }}" class="btn btn-dark">
                                Cancel
                            </a>
                        </div>
                        <div class="col-md-6 logo-center">
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
