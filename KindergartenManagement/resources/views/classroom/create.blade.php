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
                      <a class="active" href="#">Classroom Create</a>
                  </li>
              </ul>
          </div>
      </div>

      <div class="center">
        <div class="card w-auto" style="max-width: 700px">
          <div class="card-header text-bg-primary title-header "> Create Classroom</div>

          <div class="card-body">
            <form method="POST" action="/classroom" enctype="multipart/form-data">
              @csrf

              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end"> Classroom Name </label>

                <div class="col-md-6">
                  <input id="name" type="text"
                         class="form-control  text-uppercase  @error('classroom_name') is-invalid @enderror"
                         name="name" value="{{ old('name') }}" required autofocus>

                  @error('classroom_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="section" class="col-md-4 col-form-label text-md-end"> Section </label>

                <div class="col-md-6">
                  <input id="section" type="text"
                         class="form-control  text-uppercase  @error('classroom_name') is-invalid @enderror"
                         name="section" value="{{ old('section') }}" required autofocus>

                  @error('classroom_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="subject1" class="col-md-4 col-form-label text-md-end"> Subjects</label>

                <div class="col-md-6">
                  <ul id="subject-list">
                    <li><input id="subject1" type="text"
                               class="form-control  text-uppercase  mb-2 @error('subjects') is-invalid @enderror"
                               name="subject1" value="{{ old('subjects') }}" required autofocus></li>

                  </ul>
                  <li id="addSubject" class="btn btn-success float-end" onclick="addSubject()">Add Subject</li>
                  @error('subjects')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="max_capacity" class="col-md-4 col-form-label text-md-end"> Maximum Capacity </label>

                <div class="col-md-6">
                  <input id="max_capacity" type="number"
                         min="1" max="100"
                         class="form-control  text-uppercase @error('max_capacity') is-invalid @enderror"
                         name="max_capacity" value="{{ old('max_capacity') }}" required autofocus>

                  @error('max_capacity')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 logo-center mb-2">
                  <a href="/classroom" class="btn btn-dark">
                    Cancel
                  </a>
                </div>
                <div class="col-md-6 logo-center mb-2">
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  <script>
    let count = 1;
    function addSubject(){
      const subjectList = document.querySelector('ul#subject-list');
      const newSubjectList = document.createElement('li');
      newSubjectList.style.display = 'inline-flex';
      newSubjectList.style.alignItems = 'center';
      newSubjectList.id= `subject${++count}`;

      newSubjectList.innerHTML = ` <input type="text" class="form-control  text-uppercase mb-2"
                                    name="subject${count}" required autofocus>
                                   <div onclick="removeSubject('subject${count}')" class="btn btn-danger ms-1 mb-2"> <i class='bx bx-trash'></div>`
      subjectList.appendChild(newSubjectList);
    }

    function removeSubject(listID){
      const subjectList = document.querySelector('ul#subject-list');
      const subjectInput = subjectList.querySelector(`li#${listID}`);

      subjectList.removeChild(subjectInput);
    }
  </script>
@endsection
