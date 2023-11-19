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

    <div class="">
        <!-- CONTENT -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1 class="heading">Notice Board</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="/home" class="active">Dashboard</a>
                        </li>
                        <li><i class="bx bx-chevron-right"></i></li>
                        <li>
                            <a class="active" href="#">Noticeboard</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card p-4">
                <div class="d-flex justify-content-around w-auto">
                    <div class="center flex-wrap">
                        <label class="me-2" for="classroom">Filter on Classroom: </label>
                        <div class="dropdown">
                            <label>
                                <select id="classroom"
                                        onchange="selectClass()"
                                        class="form-control dropdown-input @error('classroom_id') is-invalid @enderror"
                                        name="classroom">
                                    <option value="all" selected>All Classroom</option>
                                    @foreach($classrooms as $classroom)
                                        <option
                                            value="{{ $classroom->classroom_name }}">
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
                    <div class="ms-2 center">
                        <a href="/notice/create" class="btn btn-primary" style="width: 100px">Post <span
                                class="show-detail">Notice</span></a>
                    </div>
                </div>
            </div>

            <section id="notice-board">
                @if(empty($thisWeekNotices) && empty($olderNotices))
                    <div class="center flex-wrap`">
                        <img style="height: 50px" src="{{ asset('image/no-notification-2.png') }}" alt="no-notice">
                        <p class="dark-text ms-3 mb-0 fs-4">No notices posted</p>
                    </div>
                @else
                    <div class="this-week">
                        <h2 class="heading">This week</h2>

                        <div class="notification">

                            @if(empty($thisWeekNotices))
                                <div class="center flex-wrap`">
                                    <img style="height: 50px" src="{{ asset('image/no-notification-2.png') }}"
                                         alt="no-notice">
                                    <p class="dark-text ms-3 mb-0 fs-4">No new notices this week</p>
                                </div>
                            @endif

                            @foreach($thisWeekNotices as $index => $thisWeekNotice)
                                @php
                                    $notice = $thisWeekNotice;
                                     $noticeClass = '';
                                        if(strtolower($notice['recipient'])  == 'all'){
                                            foreach($classrooms as $classroom){
                                                $noticeClass .= ' '. $classroom->classroom_name;
                                            }
                                        }else{
                                            foreach (explode(',', $notice['recipient']) as $recipient ){
                                                $noticeClass .= ' '.$recipient;
                                            }
                                        }
                                @endphp
                                @if($notice['status'] === 'show' && !\Carbon\Carbon::parse($notice['expired_date'] )->isBefore(\Carbon\Carbon::now()))
                                    <div
                                        class="card notice {{ $noticeClass }} ">
                                        <small
                                            class="position-absolute mt-1 px-2 py-1 bg-opacity-75 bg-success text-white rounded-end">Notice</small>
                                        <div class="title w-100 {{ 'bg-'.$index%5 }}">
                                            <h4 class="poppins"><small class="text-dark text-opacity-75"> Title:</small><br>
                                                <span class="{{ 'bg-'.$index%5 }}">
                                                    {{ $notice['title']}}
                                                </span>
                                                </h4>
                                            <div class="">
                                                <small class="update-date">Last Update</small>
                                                <p>{{ Carbon\Carbon::parse($classroom->updated_at)->format('l, d-m-Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="notice-image">
                                            <div class="image-box position-relative preparatory {{ 'bg-'.$index%5 }}">
                                                @if($notice['image'])
                                                    <small class="bg-opacity-25 bg-dark p-1 position-absolute ">Click
                                                        image to view</small>
                                                    <a target="_blank"
                                                       href="{{ asset('storage/'.$notice['image']) }}"><img
                                                            src="{{ asset('storage/'.$notice['image']) }}"
                                                            alt="file image"/></a>
                                                @elseif($notice['pdf'])
                                                    <img
                                                        src="{{ asset('storage/assignments/pdf-image.png') }}"
                                                        alt="file image"/>
                                                @endif

                                            </div>
                                            <div class="p-3">
                                                <p class="poppins">
                                                    <b>Message:</b> <br>
                                                    {{ $notice['message'] }}
                                                </p>

                                                @if($notice['pdf'])
                                                    <a href="download/pdf/{{ $notice['pdf'] }}"
                                                       class="btn btn-warning"><i
                                                            class='bx bx-cloud-download'></i><span
                                                            class="show-detail"> Download</span></a>
                                                @endif
                                                <small class="small-heading float-end">From {{ ucwords($notice->staff->first_name) }}</small>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="/notice/{{ $notice['id'] }}/edit" style="width: fit-content" class="m-2 btn border border-primary text-primary">Edit</a>

                                                    <form action="/notice/{{$notice['id']}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" style="width: fit-content" class="m-2 btn border border-danger text-danger ">Delete</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <hr/>

                        <div class="old-notif">
                            @if($olderNotices)
                                <h2 class="heading">Old Notices</h2>
                            @endif

                            <div class="notification">
                                @foreach($olderNotices as $index => $oldNotice)
                                    @php
                                        $notice = $oldNotice;
                                        $noticeClass = '';
                                        if(strtolower($notice['recipient'])  == 'all'){
                                            foreach($classrooms as $classroom){
                                                $noticeClass .= ' '. $classroom->classroom_name;
                                            }
                                        }else{
                                            foreach (explode(',', $notice['recipient']) as $recipient ){
                                                $noticeClass .= ' '.$recipient;
                                            }
                                        }
                                    @endphp
                                    @if($notice['status'] === 'show')
                                        <div
                                            class="card notice {{ $noticeClass }}">
                                            <small
                                                class="position-absolute mt-1 px-2 py-1 bg-opacity-75 bg-success text-white rounded-end">Notice</small>
                                            <div class="title w-100 {{ $index%5 }}">
                                                <h1 class="sub-heading"><span class="dark-text"> Title:</span>
                                                    <br> {{ $notice['title']}}</h1>
                                                <div class="">
                                                    <small class="update-date">Last Update</small>
                                                    <p>{{ Carbon\Carbon::parse($classroom->updated_at)->format('l, d-m-Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="notice-image">
                                                <div class="position-relative">
                                                    @if($notice['image'])
                                                        <small class="bg-opacity-10 bg-dark p-1 position-absolute mx-1">Click
                                                            image to view</small>
                                                        <a target="_blank"
                                                           href="{{ asset('storage/'.$notice['image']) }}"><img
                                                                src="{{ asset('storage/'.$notice['image']) }}"
                                                                alt="file image"/></a>
                                                    @elseif($notice['pdf'])
                                                        <img
                                                            src="{{ asset('storage/assignments/pdf-image.png') }}"
                                                            alt="file image"/>
                                                    @endif

                                                </div>
                                                <p class="poppins">
                                                    <b>Message:</b> <br>
                                                    {{ $notice['message'] }}
                                                </p>

                                                @if($notice['pdf'])
                                                    <a href="download/pdf/{{ $notice['pdf'] }}"
                                                       class="btn btn-primary"><i
                                                            class='bx bx-cloud-download'></i><span
                                                            class="show-detail"> Download</span></a>
                                                @endif
                                                <small class="small-heading float-end">From {{ ucwords($notice->staff->first_name) }}</small>
                                                <div class="d-flex flex-wrap justify-content-around">
                                                    <a href="/notice/{{ $notice['id'] }}/edit" style="width: fit-content" class="m-2 btn border border-primary text-primary">Edit</a>

                                                    <form action="/notice/{{$notice['id']}}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" style="width: fit-content" class="m-2 btn border border-danger text-danger ">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </section>
        </main>
        <!-- MAIN -->
        <!-- CONTENT -->
    </div>

    <script lang="js">

        function selectClass(){
            const classroomSelect = document.getElementById('classroom');
            const selectedClass = classroomSelect.value;
            const allNotices = document.querySelectorAll('.card.notice');

            if(selectedClass.toLowerCase() === 'all'){
                allNotices.forEach((noticeCard)=>{
                    noticeCard.style.display = 'block';
                })
            }else{
                allNotices.forEach((noticeCard)=>{
                    noticeCard.style.display = 'none';
                })

                const selectedClassNotices = [...document.getElementsByClassName(classroomSelect.value)];
                selectedClassNotices.forEach((selectedNoticeCard) => {
                    selectedNoticeCard.style.display = 'block';
                });

            }

        }

    </script>
@endsection
