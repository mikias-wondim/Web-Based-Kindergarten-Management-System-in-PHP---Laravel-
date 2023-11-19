@extends('layouts.nav-less')

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
    @endif

    <div class="container d-flex justify-content-center align-items-center">
        <div class="justify-content-center">
                <div class="card add-form">
                    <div class="card-header text-bg-primary title-header "> Add Assignment</div>

                    <div class="card-body">
                        <form method="POST" action="/assignment/{{ $classroom->id }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="subject" class=" col-form-label text-md-start">Subject</label>
                                <div class="dropdown ">
                                    <select id="subject"
                                            class="form-control dropdown-input @error('subject') is-invalid @enderror"
                                            name="subject" required autofocus>
                                        <option disabled selected>Subject</option>
                                        @foreach(explode(',', $classroom->subjects) as $subject)
                                            <option
                                                value="{{ $subject }}" {{ old('subject') == $subject ? 'selected': ''}}>{{ $subject }}</option>
                                        @endforeach
                                        <option value="general" {{old('subject') == 'general' ? 'selected': ''}}>
                                            General
                                        </option>
                                    </select>
                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="title" class=" col-form-label text-md-start"> Title
                                </label>

                                <div class="">
                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title') }}" required autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class=" col-form-label text-md-start">
                                    Description </label>

                                <div class="">
                                    <textarea id="description" type="text"
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description" autofocus>{{ old('description') }}</textarea>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="upload-file" class=" col-form-label text-md-start">Upload
                                    File </label>
                                <div class=" d-inline-flex justify-content-around">
                                    <div class="">
                                        <input id="upload-pdf-file" name="upload-file" class="form-check-input ms-1"
                                               type="radio" onclick="showInput('pdf')">
                                        <label for="upload-pdf-file">PDF/DOC</label>
                                    </div>
                                    <div class="">
                                        <input id="upload-image-file" name="upload-file" class="form-check-input ms-3"
                                               type="radio" onclick="showInput('image')">
                                        <label for="upload-image-file">IMAGE</label>
                                    </div>
                                </div>
                            </div>

                            <div id="image" class="row mb-3  @unless($errors->has('image')) collapse @endif">
                                <label for="image" class=" col-form-label text-md-start"> Image</label>
                                <div class="">
                                    <input id="image" type="file"
                                           class="form-control  @error('image') is-invalid @enderror"
                                           name="image" value="{{ old('image') }}" autofocus>

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="pdf" class="row mb-3 @unless($errors->has('pdf')) collapse @endif">
                                <label for="pdf" class=" col-form-label text-md-start">PDF/DOC</label>

                                <div class="">
                                    <input id="pdf" type="file"
                                           class="form-control  @error('pdf') is-invalid @enderror"
                                           name="pdf" value="{{ old('pdf') }}" autofocus>

                                    @error('pdf')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="due_date" class="col-md-6 col-form-label text-md-start">Due Date</label>

                                <div class="col-md-6">
                                    <input id="due_date" type="date"
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           max="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           name="due_date" value="{{ old('due_date') }}" required
                                           autofocus>

                                    @error('due_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="max_score" class="col-md-6 col-form-label text-md-start"> Max<span
                                        class="show-detail">imum</span> Score </label>

                                <div class="col-md-6">
                                    <input id="max_score" type="number"
                                           max="20" min="0"
                                           class="form-control @error('max_score') is-invalid @enderror"
                                           name="max_score" value="{{ old('max_score') }}" required
                                           autofocus>

                                    @error('max_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-md-6 col-form-label text-md-start">
                                    Status </label>

                                <div class="col-md-6">
                                    <label>
                                        <select id="status"
                                                class="form-control dropdown-input @error('status') is-invalid @enderror"
                                                name="status" required>
                                            <option disabled selected>Status</option>
                                            <option value="hide" {{old('status') == 'hide' ? 'selected': ''}}>Hide
                                            </option>
                                            <option value="show" {{old('status') == 'show' ? 'selected': ''}}>Show
                                            </option>
                                        </select>
                                    </label>

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="delete_after" class="col-md-6 col-form-label text-md-start">Deleting
                                    Date</label>

                                <div class="col-md-6">
                                    <input id="delete_after" type="date"
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           max="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                           class="form-control @error('delete_after') is-invalid @enderror"
                                           name="delete_after" value="{{ old('delete_after') }}" required
                                           autofocus>

                                    @error('delete_after')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-6 logo-center">
                                    <a href="/noticeboard/{{ auth()->user()->staff->teacher->classroom->id }}" class="btn btn-dark mb-2">
                                        Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 logo-center">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>

    <script>
        const pdfInput = document.getElementById('pdf');
        const imageInput = document.getElementById('image');

        function showInput(inputType) {
            if (inputType === 'image') {
                pdfInput.classList.add('collapse');
                imageInput.classList.remove('collapse');
            } else if (inputType === 'pdf') {
                pdfInput.classList.remove('collapse');
                imageInput.classList.add('collapse');
            }
        }
    </script>
@endsection
