@extends('layouts.nav-less')

@section('content')
    <div class="center">
        <div class="card w-auto">
                <div class="card-header text-bg-primary title-header "> Add Health and Emergency Information</div>

                <div class="card-body">
                    <form method="POST" action="/healthemergeinfo">
                        @csrf

                        <div class="row mb-3">
                            <label for="blood_type" class="col-md-4 col-form-label text-md-end">Blood Type</label>
                            <div class="dropdown col-md-4">
                                <select id="blood_type"
                                        class="form-control dropdown-input @error('blood_type') is-invalid @enderror"
                                        name="blood_type" autofocus>
                                    <option disabled selected>Blood Type</option>
                                    <option
                                        value="A+" {{ old('blood_type') == "A+" || session('blood_type') == 'A+' ? 'selected' : '' }}>
                                        A+
                                    </option>
                                    <option
                                        value="A-" {{ old('blood_type') == "A-" || session('blood_type') == 'A-'? 'selected' : '' }}>
                                        A-
                                    </option>
                                    <option
                                        value="B+" {{ old('blood_type') == "B+" || session('blood_type') == 'B+'? 'selected' : '' }}>
                                        B+
                                    </option>
                                    <option
                                        value="B-" {{ old('blood_type') == "B-" || session('blood_type') == 'B-'? 'selected' : '' }}>
                                        B-
                                    </option>
                                    <option
                                        value="AB+" {{ old('blood_type') == "AB+" || session('blood_type') == 'AB+'? 'selected' : '' }}>
                                        AB+
                                    </option>
                                    <option
                                        value="AB-" {{ old('blood_type') == "AB-" || session('blood_type') == 'AB-'? 'selected' : '' }}>
                                        AB-
                                    </option>
                                    <option
                                        value="O+" {{ old('blood_type') == "O+" || session('blood_type') == 'O+'? 'selected' : '' }}>
                                        O+
                                    </option>
                                    <option
                                        value="O-" {{ old('blood_type') == "O-" || session('blood_type') == 'O-'? 'selected' : '' }}>
                                        O-
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="allergies" class="col-md-4 col-form-label text-md-end"> Allergies
                                (if any)</label>

                            <div class="col-md-6">
                                <input id="allergies" type="text"
                                       class="form-control @error('allergies') is-invalid @enderror"
                                       name="allergies" value="{{ old('allergies') ?? session('allergies')}}" autofocus>

                                @error('allergies')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="medications" class="col-md-4 col-form-label text-md-end">
                                Medications (if any)</label>

                            <div class="col-md-6">
                                <input id="medications" type="text"
                                       class="form-control @error('medications') is-invalid @enderror"
                                       name="medications" value="{{ old('medications') ?? session('medications') }}"
                                       autofocus>

                                @error('medications')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="special_needs" class="col-md-4 col-form-label text-md-end"> Special
                                Needs (if any) </label>

                            <div class="col-md-6">
                                <input id="special_needs" type="text"
                                       class="form-control @error('special_needs') is-invalid @enderror"
                                       name="special_needs" value="{{ old('special_needs') ?? session('special_needs') }}"
                                       autofocus>

                                @error('special_needs')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_name" class="col-md-4 col-form-label text-md-end"> Emergency
                                Contact Name </label>

                            <div class="col-md-6">
                                <input id="contact_name" type="text"
                                       class="form-control @error('contact_name') is-invalid @enderror"
                                       name="contact_name" value="{{ old('contact_name') ?? session('contact_name')}}" required
                                       autofocus>

                                @error('contact_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_address" class="col-md-4 col-form-label text-md-end">
                                Emergency Contact Address </label>

                            <div class="col-md-6">
                                <input id="contact_address" type="text"
                                       class="form-control @error('contact_address') is-invalid @enderror"
                                       name="contact_address" value="{{ old('contact_address') ?? session('contact_address')}}" required
                                       autofocus>

                                @error('contact_address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contact_phone" class="col-md-4 col-form-label text-md-end">
                                Emergency Contact Phone No. </label>

                            <div class="col-md-6">
                                <input id="contact_phone" type="text"
                                       class="form-control @error('contact_phone') is-invalid @enderror"
                                       name="contact_phone" value="{{ old('contact_phone') ?? session('contact_phone')}}" required
                                       autofocus>

                                @error('contact_phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-6 logo-center">
                                <a href="{{ route('profile.create') }}" class="btn btn-dark">
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
