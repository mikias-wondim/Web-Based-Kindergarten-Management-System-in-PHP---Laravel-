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

  <div class="center">
      <div class="card w-fit" style="max-width: 700px">
          <div class="card-header text-bg-primary title-header"> Edit Classroom</div>

          <div class="card-body">
            <form method="POST" action="/classroom/{{$classroom->id}}" enctype="multipart/form-data">
              @csrf
              @method('patch')

              <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end"> Classroom Name </label>

                <div class="col-md-6">
                  <input id="name" type="text"
                         class="form-control  text-uppercase  @error('classroom_name') is-invalid @enderror"
                         name="name" value="{{ old('name') ?? explode(" / ", $classroom->classroom_name)[0] }}" required
                         autofocus>

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
                         name="section" value="{{ old('section') ?? explode(" / ", $classroom->classroom_name)[1]}}"
                         required autofocus>

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
                    @foreach(explode(',', $classroom->subjects) as $subject)
                      <li id="subject{{$loop->index}}" class="d-inline-flex align-items-center">
                        <input type="text"
                                 class="form-control  text-uppercase  mb-2 @error('subjects') is-invalid @enderror"
                                 name="subject{{$loop->index}}" value="{{ old('subject'.$loop->index) ?? $subject}}" required autofocus>
                        <div onclick="removeSubject('subject{{$loop->index}}')" class="btn btn-danger ms-1 mb-2"> <i class='bx bx-trash'></i></div>
                      </li>
                    @endforeach
                  </ul>
                  <li id="addSubject" class="btn btn-success float-end" onclick="addSubject()">Add Subject</li>
                </div>

                @error('subjects')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
              </div>

              <div class="row mb-3">
                <label for="max_capacity" class="col-md-4 col-form-label text-md-end"> Maximum Capacity </label>

                <div class="col-md-6">
                  <input id="max_capacity" type="number"
                         min="1" max="100"
                         class="form-control  text-uppercase @error('max_capacity') is-invalid @enderror"
                         name="max_capacity" value="{{ old('max_capacity') ?? $classroom->max_capacity }}" required
                         autofocus>

                  @error('max_capacity')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="max_capacity" class="col-md-4 col-form-label text-md-end"> Assign Teacher </label>

                <div class="col-md-6 mb-3">
                    <label>
                        <select id="teacher"
                                onchange="displayClassList()"
                                class="form-control dropdown-input"
                                name="classroom" required>
                            <option disabled selected>Select Classroom</option>
                            <option>Unassigned</option>
                            @foreach($classrooms as $classroom)
                                <option
                                    value="{{ $classroom->classroom_name }}">
                                    {{ $classroom->classroom_name }}
                                </option>
                            @endforeach
                        </select>
                    </label>
              </div>
              </div>

              <div class="d-flex justify-content-around">
                <div class="logo-center mb-2 mx-2">
                  <a href="/classroom" class="btn btn-dark">
                    Cancel
                  </a>
                </div>

                <div class="logo-center mb-2 mx-2">
                  <button type="submit" class="btn btn-primary">
                    Update
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
                                   <div onclick="removeSubject('subject${count}')" class="btn btn-danger ms-1 mb-2"><i class='bx bx-trash'></i></div>`
      subjectList.appendChild(newSubjectList);
    }

    function removeSubject(listID){
      const subjectList = document.querySelector('ul#subject-list');
      const subjectInput = subjectList.querySelector(`li#${listID}`);
      if (subjectList.querySelectorAll('li').length > 1)
        subjectList.removeChild(subjectInput);
      else
        alert('Can not remove, one subject is mandatory');
    }
  </script>

@endsection
