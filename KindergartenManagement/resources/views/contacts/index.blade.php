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

    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Contact Messages</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Contact Messages</a>
                    </li>
                </ul>
            </div>
        </div>


        <hr style="width: 70%; margin: 30px auto 10px auto ">

        <div class="classroom-items">
            <ul id="class-list" class="p-0 d-flex flex-wrap justify-content-center flex-md-row">
                @foreach($contacts as $index => $contact)
                    <li class="card classroom default d-flex">
                        <div class="left">
                            @if($contact->new)
                                <i class="bg-primary text-white rounded-pill px-2 float-end">new</i>
                            @endif
                            <div class="">
                                <small class="grey">Name</small>
                                <h2 class="">{{ ucwords($contact->name) }}</h2>
                            </div>
                            <div class="">
                                <small class="grey">Email</small>
                                <p class="text-dark">{{ $contact->email }}</p>
                            </div>
                            <div class="">
                                <small class="grey">Actions</small>
                                <div class="my-2 center justify-content-around">
                                    <button class="px-2 btn btn-warning">Replay</button>
                                    <form action="/contact-message/{{$contact->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="px-2 btn border border-danger text-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="msg-card-{{ $index }}" style="max-height: 170px; overflow: hidden;">
                                <small class="grey">Contact</small>
                                <h3>Message</h3>
                                <p>{{ $contact->message }}</p>
                                <small class="grey">Send At: </small>
                                <h6 class="text-md-end">{{ Carbon\Carbon::parse($contact->created_at)->format('l, d-m-Y') }}</h6>
                            </div>
                            @if(strlen($contact->message) > 130)
                                <strong id="dot-{{$index}}" class="fs-4" style="letter-spacing: 4px">...</strong>
                                <button id="btn-{{$index}}" class="btn text-primary" onclick="show({{$index}})">Show More</button>
                            @endif

                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </main>
    <!-- MAIN -->
    <!-- CONTENT -->

    <script>
        let hidden = true;
        function show(index) {
            const messageCard = document.getElementById(`msg-card-${index}`);
            const dot = document.getElementById(`dot-${index}`);
            const showBtn = document.getElementById(`btn-${index}`);
            if(hidden){
                messageCard.style.maxHeight = 'fit-content';
                dot.style.display = 'none';
                showBtn.textContent= 'Show Less';
                hidden = !hidden
            }else{
                messageCard.style.maxHeight = '150px';
                dot.style.display = 'inline';
                showBtn.textContent= 'Show More';
                hidden = !hidden
            }
        }
    </script>
@endsection
