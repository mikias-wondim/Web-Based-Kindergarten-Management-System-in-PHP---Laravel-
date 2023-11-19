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
        <div class="card add-form w-auto">
            <div class="card-header text-bg-primary title-header "> Edit Notice </div>

                    <div class="card-body">
                        <form method="POST" action="/notice/{{ $notice->id }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')



                            <div class="row mb-3">
                                <label for="recipient" class=" col-form-label">Recipient
                                    Classroom</label>
                                <div class="dropdown">
                                    <select id="recipient"
                                            class="form-control dropdown-input w-100 @error('recipient') is-invalid @enderror"
                                            name="recipient" autofocus >
                                        <option disabled selected>Classroom</option>
                                        @if(auth()->user()->role = 'teacher')
                                            @php
                                                $classroom = auth()->user()->staff->teacher->classroom;
                                            @endphp
                                            <option  onselect="alert('selected')"
                                                     value="{{ $classroom->classroom_name }}" {{ old('recipient') == $classroom->classroom_name ? 'disabled': ''}}>{{ $classroom->classroom_name }}
                                            </option>
                                        @else

                                            @foreach($classrooms as $classroom)
                                                <option
                                                    onselect="alert('selected')"
                                                    value="{{ $classroom->classroom_name }}" {{ old('recipient') == $classroom->classroom_name ? 'disabled': ''}}>{{ $classroom->classroom_name }}
                                                </option>
                                            @endforeach
                                            <option value="all" {{old('recipient') == 'all' ? 'selected': ''}}>
                                                All
                                            </option>
                                        @endif
                                    </select>
                                    @error('recipient')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="classroom-selected" class="col-form-label"> Classroom Selected
                                </label>

                                <div id="selected-class" class="class-list">
                                    @foreach($classrooms as $classroom)
                                        @if(old('class-'.explode(' / ', $classroom->classroom_name)[0].explode(' / ', $classroom->classroom_name)[1])      || in_array($classroom->classroom_name, $selectedClassrooms))
                                            <div id="{{ explode(' / ', $classroom->classroom_name)[0].explode(' / ', $classroom->classroom_name)[1] }}">
                                                <small
                                                    class="m-2 my-3 py-1 px-2 bg-warning rounded-5">{{$classroom->classroom_name}}
                                                </small><i  onclick="removeClass(event)"
                                                            class='bx bx-x-circle text-danger btn m-0 p-0'></i>
                                                <input
                                                    type="hidden"
                                                    name="class-{{$classroom->classroom_name}}" value="{{$classroom->classroom_name}}">
                                            </div>
                                        @endif
                                    @endforeach
                                    @if(old('class-all') || in_array('all', $selectedClassrooms))
                                            <script >
                                                document.getElementById('recipient').childNodes.forEach(option => {option.disabled = true})
                                            </script>
                                        <div id="all">
                                            <small
                                                class="m-2 my-3 py-1 px-2 bg-warning rounded-5 ">All Classroom
                                            </small>
                                            <i  onclick="removeClass(event)"
                                                class='bx bx-x-circle text-danger btn m-0 p-0'></i>
                                            <input
                                                type="hidden"
                                                name="class-all" value="all">

                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="title" class="col-form-label"> Title
                                </label>

                                <div class="">
                                    <input id="title" type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title') ?? $notice->title}}" required autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="message" class="col-form-label">
                                    Notice Message </label>

                                <div class="">
                                    <textarea id="message" type="text"
                                              rows="5"
                                              class="form-control w-100 @error('message') is-invalid @enderror"
                                              name="message" autofocus>{{ old('message') ?? $notice->message}}</textarea>

                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="upload-file" class="col-md-4 col-form-label text-md-end mx-2"> Upload
                                    File </label>
                                <div class="col-md-6 d-inline-flex justify-content-around">
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

                            @if($notice->image)
                                <div class="center mb-2"><a target="_blank"
                                                       href="{{ asset('storage/'.$notice['image']) }}"><img
                                            src="{{ asset('storage/'.$notice['image']) }}"
                                            height="80"
                                            alt="file image"/></a>
                                </div>
                            @endif

                            <div id="image" class="row mb-3  @unless($errors->has('image') || $notice->image) collapse @endif">
                                <label for="image" class="col-md-4 col-form-label text-md-end"> Image</label>
                                <div class="col-md-6">
                                    <input id="image" type="file"
                                           class="form-control  @error('image') is-invalid @enderror"
                                           name="image" value="{{ old('image') ?? $notice->image}}" autofocus>

                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="pdf" class="row mb-3 @unless($errors->has('pdf')) collapse @endif">
                                <label for="pdf" class="col-md-4 col-form-label text-md-end">PDF/DOC</label>

                                <div class="col-md-6">
                                    <input id="pdf" type="file"
                                           class="form-control  @error('pdf') is-invalid @enderror"
                                           name="pdf" value="{{ old('pdf') ?? $notice->pdf}}" autofocus>

                                    @error('pdf')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status" class="col-md-4 col-form-label text-md-end">
                                    Status </label>

                                <div class="col-md-6">
                                    <label>
                                        <select id="status"
                                                class="form-control dropdown-input @error('status') is-invalid @enderror"
                                                name="status" required>
                                            <option disabled selected>Status</option>
                                            <option value="hide" {{old('status') == 'hide' || $notice->status == 'hide' ? 'selected': ''}}>Hide
                                            </option>
                                            <option value="show" {{old('status') == 'show' || $notice->status == 'show' ? 'selected': ''}}>Show
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
                                <label for="expired_date" class="col-md-4 col-form-label text-md-end">Expire
                                    Date</label>

                                <div class="col-md-6">
                                    <input id="expired_date" type="date"
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           max="{{ \Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                           class="form-control @error('expired_date') is-invalid @enderror"
                                           name="expired_date" value="{{ old('expired_date') ?? $notice->expired_date }}" required
                                           autofocus>

                                    @error('expired_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-6 logo-center">
                                    <a href="/noticeboard" class="btn btn-dark">
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

        const recipient = document.getElementById('recipient');
        const selection = document.getElementById('selected-class');
        let allSelected = false;

        recipient.addEventListener('change', function() {
            let selectedClass = this.value;
            let selectedOption = recipient.options[recipient.selectedIndex];
            selectedOption.disabled = true;

            if(selection.querySelectorAll(`#${selectedClass.split(' / ')[0] + selectedClass.split(' / ')[1]}`).length){
                alert('Already Selected');
            }else if(selectedClass === 'all' ){
                selection.innerHTML = "";
                allSelected = true;
                recipient.childNodes.forEach(option => {option.disabled = true})

                const classroom = document.createElement('div');
                classroom.id = 'all';
                classroom.innerHTML = `
                    <small
                        class="m-2 my-3 py-1 px-2 bg-warning rounded-5 ">All Classroom
                    </small>
                    <i  onclick="removeClass(event)"
                        class='bx bx-x-circle text-danger btn m-0 p-0'></i>
                    <input
                        type="hidden"
                        name="class-all" value="all">
                `;
                selection.appendChild(classroom);
            }
            else if(!allSelected){
                const classroom = document.createElement('div');
                classroom.id = selectedClass.split(' / ')[0] + selectedClass.split(' / ')[1];
                classroom.innerHTML = `
                    <small
                        class="m-2 my-3 py-1 px-2 bg-warning rounded-5">${selectedClass}
                        </small><i  onclick="removeClass(event)"
                            class='bx bx-x-circle text-danger btn m-0 p-0'></i>
                    <input
                        type="hidden"
                        name="class-${selectedClass}" value="${selectedClass}">
                `;
                selection.appendChild(classroom);
            }

        });

        function removeClass(event){
            const removedClass = event.target.parentElement;
            if (removedClass.id === 'all'){
                allSelected = false;
                recipient.childNodes.forEach(option => {option.disabled = option.value === 'Classroom'})
            }else{
                let selectedClass = recipient.options[recipient.selectedIndex];
                selectedClass.disabled = !selectedClass.disabled;
            }
            selection.removeChild(removedClass)

            const children = [ ...recipient.children]
            children.forEach((child, index)=>{
                if(index === 0)
                    child.selected = true;
                else
                    child.selected = false;
            })
        }

    </script>
@endsection
