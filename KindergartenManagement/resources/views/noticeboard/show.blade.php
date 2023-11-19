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
                            <a class="active" href="#">noticeboard</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="center flex-column m-3 p-4" style="background: var(--light)">
                <div class="center">
                    <div class="d-flex border-dark w-fit">
                        <button onclick="show(event, 'all')"
                                class="px-2 py-1 me-2 pointer rounded-0 bg-opacity-75 poppins shadow-sm navigation-btn selected-btn not-active">
                            All
                        </button>
                        <button onclick="show(event, 'assignment')"
                                class="px-2 py-1 me-2 pointer rounded-0 poppins shadow-sm navigation-btn not-active">
                            Assignments
                        </button>
                        <button onclick="show(event, 'notice')"
                                class="px-2 py-1 pointer rounded-0 bg-opacity-75 shadow-sm poppins navigation-btn not-active">
                            Notices
                        </button>
                    </div>
                </div>
                @if(auth()->user()->staff)
                    @if(auth()->user()->staff->teacher)
                        <div class="d-flex justify-content-between flex-wrap mt-3 w-75">
                            <a href="/assignment/{{auth()->user()->staff->teacher->classroom->id}}/create"
                               class="btn btn-primary w-fit m-2"><span class="show-detail">Post </span>Assignment</a>
                            <a href="/notice/create" class="btn btn-primary w-fit m-2"><span
                                    class="show-detail">Post </span>Notice</a>
                        </div>
                    @endif
                @endif
            </div>
            <section id="notice-board">
                <div class="this-week">

                    <h2 class="heading">This week</h2>

                    <div class="notification">
                        @if(empty($thisWeekNotices))
                            No new notifications
                        @endif

                        @foreach($thisWeekNotices as $index => $thisWeekNotice)
                            @if(array_key_exists('due_date', $thisWeekNotice))
                                @php
                                    $assignment = $thisWeekNotice;
                                @endphp
                                @if($assignment['status'] === 'show' && !\Carbon\Carbon::parse($assignment['delete_after'] )->isBefore(\Carbon\Carbon::now()))
                                    <div class="card position-relative assignment">
                                        <small
                                            class="position-absolute mt-1 px-2 py-1 bg-opacity-75 bg-danger text-white rounded-end">Assignment</small>
                                        <div class="title {{ 'bg-'.$index%5 }}">
                                            <h4 class="poppins"><span class="text-dark text-opacity-75"> Title:</span>
                                                <br> {{ $assignment['title']}}</h4>
                                            <h4 class=""><span class="text-dark text-opacity-75"> Subject:</span>
                                                <br> {{ $assignment['subject'] }}</h4>

                                        </div>
                                        <div class="notice-image">
                                            <div class="image-box position-relative {{ 'bg-'.$index%5 }}">
                                                @if($assignment['image'])
                                                    <small class="bg-opacity-25 bg-dark p-1 position-absolute mx-1">Click
                                                        image to view</small>
                                                    <a target="_blank"
                                                       href="{{ asset('storage/'.$assignment['image']) }}"><img
                                                            src="{{ asset('storage/'.$assignment['image']) }}"
                                                            alt="file image"/></a>
                                                @elseif($assignment['pdf'])
                                                    <img
                                                        src="{{ asset('storage/assignments/pdf-image.png') }}"
                                                        alt="file image"/>
                                                @endif

                                            </div>
                                            <div class="p-3">
                                                <p class="poppins">
                                                    <b>Description:</b> <br>
                                                    {{ $assignment['description'] }}
                                                </p>
                                                <h6 class="nunito">Max Score: {{ $assignment['max_score'] }}
                                                </h6>
                                                <h6 class="nunito">Due Date:
                                                    <span
                                                        class="orange-text">{{ \Carbon\Carbon::parse($assignment['due_date'])->format('l').", ".$assignment['due_date'] }}</span>
                                                </h6>
                                                <small>Submit using the chat message</small>
                                                <br>
                                                @if($assignment['pdf'])
                                                    <a href="download/pdf/{{ $assignment['pdf'] }}"
                                                       class="btn btn-warning"><i
                                                            class='bx bx-cloud-download'></i><span
                                                            class="show-detail"> Download</span></a>
                                                @endif
                                                <small
                                                    class="small-heading float-end">From {{ \App\Models\Classroom::findOrFail($assignment['classroom_id'])->teacher[0]->staff->first_name  }}</small>
                                            </div>


                                            @if(auth()->user()->staff)
                                                @if(auth()->user()->staff->teacher)
                                                    <div class="d-flex flex-wrap justify-content-around">
                                                        <a href="/assignment/{{ $assignment['id'] }}/edit"
                                                           style="width: fit-content"
                                                           class="m-2 btn border border-primary text-primary">Edit</a>

                                                        <form action="/assignment/{{$assignment['id']}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" style="width: fit-content"
                                                                    class="m-2 btn border border-danger text-danger ">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                @endif
                            @else
                                @php
                                    $notice = $thisWeekNotice
                                @endphp
                                @if($notice['status'] === 'show' && !\Carbon\Carbon::parse($notice['expired_date'] )->isBefore(\Carbon\Carbon::now()))
                                    <div
                                        class="card notice ">
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
                                                <small
                                                    class="small-heading float-end">From {{ ucwords(\App\Models\Staff::findOrFail($notice['staff_id'])->first_name) }}</small>

                                                @if(auth()->user()->staff)
                                                    @if(auth()->user()->staff->teacher)
                                                        <div class="d-flex flex-wrap justify-content-around">
                                                            <a href="/notice/{{ $notice['id'] }}/edit"
                                                               style="width: fit-content"
                                                               class="m-2 btn border border-primary text-primary">Edit</a>

                                                            <form action="/notice/{{$notice['id']}}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" style="width: fit-content"
                                                                        class="m-2 btn border border-danger text-danger ">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>

                    <hr style="width: 75%; margin: auto"/>

                    <div class="old-notif">
                        @if($olderNotices)
                            <h2 class="heading">Old Notices</h2>
                        @endif
                        <div class="notification">
                            @foreach($olderNotices as $index => $oldNotice)

                                @if(array_key_exists('due_date', $oldNotice))
                                    @php
                                        $assignment = $oldNotice;
                                    @endphp
                                    @if($assignment['status'] === 'show' && !\Carbon\Carbon::parse($assignment['delete_after'] )->isBefore(\Carbon\Carbon::now()))
                                        <div class="card position-relative assignment">
                                            <small
                                                class="position-absolute mt-1 px-2 py-1 bg-opacity-75 bg-danger text-white rounded-end">Assignment</small>
                                            <div class="title {{ 'bg-'.$index%5 }}">
                                                <h4 class="poppins"><span
                                                        class="text-dark text-opacity-75"> Title:</span>
                                                    <br> {{ $assignment['title']}}</h4>
                                                <h4 class=""><span class="text-dark text-opacity-75"> Subject:</span>
                                                    <br> {{ $assignment['subject'] }}</h4>

                                            </div>
                                            <div class="notice-image">
                                                <div class="image-box position-relative {{ 'bg-'.$index%5 }}">
                                                    @if($assignment['image'])
                                                        <small class="bg-opacity-25 bg-dark p-1 position-absolute mx-1">Click
                                                            image to view</small>
                                                        <a target="_blank"
                                                           href="{{ asset('storage/'.$assignment['image']) }}"><img
                                                                src="{{ asset('storage/'.$assignment['image']) }}"
                                                                alt="file image"/></a>
                                                    @elseif($assignment['pdf'])
                                                        <img
                                                            src="{{ asset('storage/assignments/pdf-image.png') }}"
                                                            alt="file image"/>
                                                    @endif

                                                </div>
                                                <div class="p-3">
                                                    <p class="poppins">
                                                        <b>Description:</b> <br>
                                                        {{ $assignment['description'] }}
                                                    </p>
                                                    <h6 class="nunito">Max Score: {{ $assignment['max_score'] }}
                                                    </h6>
                                                    <h6 class="nunito">Due Date:
                                                        <span
                                                            class="orange-text">{{ \Carbon\Carbon::parse($assignment['due_date'])->format('l').", ".$assignment['due_date'] }}</span>
                                                    </h6>
                                                    <small>Submit using the chat message</small>
                                                    <br>
                                                    @if($assignment['pdf'])
                                                        <a href="download/pdf/{{ $assignment['pdf'] }}"
                                                           class="btn btn-warning"><i
                                                                class='bx bx-cloud-download'></i><span
                                                                class="show-detail"> Download</span></a>
                                                    @endif
                                                    <small
                                                        class="small-heading float-end">From {{ \App\Models\Classroom::findOrFail($assignment['classroom_id'])->teacher[0]->staff->first_name  }}</small>
                                                </div>

                                                @if(auth()->user()->staff)
                                                    @if(auth()->user()->staff->teacher)
                                                        <div class="d-flex flex-wrap justify-content-around">
                                                            <a href="/assignment/{{ $assignment['id'] }}/edit"
                                                               style="width: fit-content"
                                                               class="m-2 btn border border-primary text-primary">Edit</a>

                                                            <form action="/assignment/{{$assignment['id']}}"
                                                                  method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" style="width: fit-content"
                                                                        class="m-2 btn border border-danger text-danger ">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @php
                                        $notice = $oldNotice
                                    @endphp
                                    @if($notice['status'] === 'show' && !\Carbon\Carbon::parse($notice['expired_date'] )->isBefore(\Carbon\Carbon::now()))
                                        <div
                                            class="card notice ">
                                            <small
                                                class="position-absolute mt-1 px-2 py-1 bg-opacity-75 bg-success text-white rounded-end">Notice</small>
                                            <div class="title w-100 {{ 'bg-'.$index%5 }}">
                                                <h4 class="poppins"><small class="text-dark text-opacity-75">
                                                        Title:</small><br>
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
                                                <div
                                                    class="image-box position-relative preparatory {{ 'bg-'.$index%5 }}">
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
                                                    <small
                                                        class="small-heading float-end">From {{ ucwords(\App\Models\Staff::findOrFail($notice['staff_id'])->first_name) }}</small>
                                                    <div class="d-flex flex-wrap justify-content-around">

                                                        @if(auth()->user()->staff)
                                                            @if(auth()->user()->staff->teacher)
                                                                <div class="d-flex flex-wrap justify-content-around">
                                                                    <a href="/notice/{{ $notice['id'] }}/edit"
                                                                       style="width: fit-content"
                                                                       class="m-2 btn border border-primary text-primary">Edit</a>

                                                                    <form action="/notice/{{$notice['id']}}"
                                                                          method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" style="width: fit-content"
                                                                                class="m-2 btn border border-danger text-danger ">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                            @endforeach
                                        </div>
                        </div>
                    </div>
            </section>
        </main>
        <!-- MAIN -->
        <!-- CONTENT -->
    </div>

    <script lang="js">
        function show(event, key) {
            const notifications = document.getElementsByClassName('notification');
            let buttonGroup = event.target.parentElement.children;
            for (let i = 0; i < buttonGroup.length; i++) {
                let classList = buttonGroup[i].classList;
                if (classList.contains('selected-btn')) {
                    classList.remove('selected-btn')
                    event.target.classList.add('selected-btn')
                }
            }

            for (let i = 0; i < notifications.length; i++) {
                let childNodes = notifications[i].children;

                for (let j = 0; j < childNodes.length; j++) {
                    let classes = childNodes[j].classList;

                    if (key === 'all') {
                        classes.remove('collapse');
                    } else {
                        classes.toggle('collapse', !classes.contains(key));
                    }
                }
            }
        }
    </script>
@endsection
