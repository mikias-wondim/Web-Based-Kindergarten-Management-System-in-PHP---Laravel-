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
                <h1 class="heading">Admitted Child</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Admitted Child</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container nunito">
            <div class="d-flex justify-content-center flex-wrap">
                <div class="profile card w-100" style="height: fit-content">
                    <div class="card-content">
                        <div class="card-detail">
                            <div class="info d-flex flex-wrap justify-content-between">
                                <div class="" style="@media screen and (max-width: 500px){
                                    width: 100%;
                                    justify-content: center;
                                }; ">
                                    <h3 class="sub-heading">Personal Information</h3>
                                    <p class="capitalize">Full Name:
                                        <strong> {{ ucwords($admission->full_name) }} </strong></p>
                                    <p class="capitalize">Date of Birth: <strong> {{ $admission->dob }}</strong></p>
                                    <p class="capitalize">Age:
                                        <strong></strong>{{ \Carbon\Carbon::parse($admission->dob)->diffInYears(\Carbon\Carbon::now()) }}
                                    </p>
                                    <p class="capitalize">Gender: <strong> {{ $admission->gender  }}</strong></p>
                                    <p class="capitalize">Father Name: <strong> {{ $admission->father_name  }}</strong>
                                    </p>
                                    <p class="capitalize">Mother Name: <strong> {{ $admission->mother_name  }}</strong>
                                    </p>
                                    <p class="capitalize">Phone: <strong> {{ $admission->phone  }}</strong></p>
                                    @if($admission->email)
                                        <p class="capitalize">Email: <strong> {{ $admission->email }}</strong></p>
                                    @endif
                                    <p class="capitalize">Address: <strong> {{ $admission->address }}</strong></p>
                                </div>

                                <div class="">
                                    <h3 class="sub-heading">Admission Information</h3>
                                    <p class="capitalize">Request Date:
                                        <strong> {{ Carbon\Carbon::parse($admission->created_at)->format('l, d-m-Y') }} </strong>
                                    </p>
                                    <p class="capitalize">Applying Program:
                                        <strong> {{ $admission->applying_program }}</strong></p>
                                    @if($admission->previous_school)
                                        <p class="capitalize" style="max-width: 350px">Previous School:
                                            <strong> {{ $admission->previous_school }}</strong></p>
                                    @endif
                                    @if($admission->medical_condition)
                                        <p class="capitalize" style="max-width: 350px">Medical Condition:
                                            <strong> {{ $admission->medical_condition }}</strong></p>
                                    @endif
                                    @if($admission->additional_info)
                                        <p class="capitalize" style="max-width: 350px">Additional Information:
                                            <strong> {{ $admission->additional_info }}</strong></p>
                                    @endif

                                    <h3 class="sub-heading">Admission Status</h3>
                                    @if($admission->forward)
                                        <form action="/admission/{{ $admission->id }}" method="POST">
                                            @csrf
                                            <p class="capitalize">
                                                <strong class="text-success">Forwarded, </strong>
                                                <strong> by {{ $admission->reception->staff->first_name }}</strong>

                                                @if(auth()->user()->role == 'reception')
                                                    <input type="hidden" name="forward" value="0">
                                                    <input type="hidden" name="forwarded_by"
                                                           value="{{ auth()->user()->staff->reception->id }}">
                                                    <button class="btn btn-warning ms-2">Un-Forward</button>
                                                @endif
                                            </p>
                                        </form>
                                    @else
                                        <form action="/admission/{{ $admission->id }}" method="POST">
                                            @csrf

                                            <p class="capitalize">
                                                <strong class="text-danger"> Not Forwarded</strong>

                                                @if(auth()->user()->role == 'reception')
                                                    <input type="hidden" name="forward" value="1">
                                                    <input type="hidden" name="forwarded_by"
                                                           value="{{ auth()->user()->staff->reception->id }}">
                                                    <button class="btn btn-primary ms-2">Forward</button>
                                                @endif
                                            </p>
                                        </form>
                                    @endif

                                    @if($admission->approved)
                                        <form action="/admission/{{ $admission->id }}" method="POST">
                                            @csrf

                                            <p class="capitalize">
                                                <strong class="text-success">Approved, </strong>
                                                <strong> by {{ $admission->schoolDirector->staff->first_name }}</strong>
                                                @if(auth()->user()->role == 'school director')

                                                    <input type="hidden" name="approved" value="0">
                                                    <input type="hidden" name="approved_by"
                                                           value="{{ auth()->user()->staff->schoolDirector->id }}">
                                                    <button class="btn btn-warning ms-2">Dis-Approve</button>
                                                @endif
                                            </p>
                                        </form>
                                    @else
                                        <form action="/admission/{{ $admission->id }}" method="POST">
                                            @csrf

                                            <p class="capitalize">
                                                <strong class="text-success">Not Approved</strong>
                                                @if(auth()->user()->role == 'school director')

                                                    <input type="hidden" name="approved" value="1">
                                                    <input type="hidden" name="approved_by"
                                                           value="{{ auth()->user()->staff->schoolDirector->id }}">
                                                    <button class="btn btn-primary ms-2">Approve</button>
                                                @endif
                                            </p>
                                        </form>
                                    @endif


                                    <p class="capitalize"> @if($admission->registered)
                                            <strong class="text-success">Registered</strong>
                                        @else
                                            <strong class="text-danger"> Not Registered</strong>
                                        @endif</p>
                                    <form action="{{ route('admission.destroy', ['admission' => $admission->id ]) }}"
                                          method="POST">
                                        @csrf
                                        @method('delete')
                                        <p>
                                            <button class="btn btn-danger">Decline and Delete</button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="center">
                    <a href="/admission/index" class="mb-3 btn btn-primary">
                        Return to list
                    </a>
                </div>

            </div>
        </div>
    </main>
    <!-- MAIN -->

    <script>

        function searchList() {
            const substring = event.target.value.toUpperCase();

            const tableBody = document.getElementById('children-list');
            const rows = tableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const cells = row.getElementsByTagName('td'); // Get all the <td> elements within the current row

                let showRow = false;
                for (const cell of cells) {
                    if (cell.textContent.includes(substring)) {
                        showRow = true;
                        break; // No need to check further if the substring is found in one of the cells
                    }
                }

                // Show or hide the row based on whether the substring was found
                row.style.display = showRow ? 'table-row' : 'none';
            }
        }

    </script>

@endsection
