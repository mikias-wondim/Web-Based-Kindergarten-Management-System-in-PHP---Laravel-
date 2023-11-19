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
                <h1 class="heading">List of Admitted Children</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">List of Admitted Children</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex">
                <div class="dropdown">
                    <lable>Status Filter:</lable>
                    <label>
                        <select id="status"
                                onchange="filterStatus()"
                                class="form-control dropdown-input"
                                required>
                            <option disabled selected>Select Status</option>
                            <option value="all">All</option>
                            <option value="approved">Approved</option>
                            <option value="not approved">Not Approved</option>
                        </select>
                    </label>
                </div>
                <div class="search-list ms-auto">
                    <div class="form-input">
                        <input id="search-input"
                               onkeydown="searchList()"
                               type="search" placeholder="Search..."/>
                        <button onchange="searchList()" class="search-btn">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-data">
                    <div class="grade p-0">
                        <table>
                            <thead class="sticky-top" style="background: var(--light);">
                            <tr>
                                <th class="text-center">Admission ID</th>
                                <th class="text-center">Full Name</th>
                                <th class="text-center">Age</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Request Date</th>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="children-list">


                            @foreach($admissions as $admission)
                                @if(auth()->user()->role == 'reception' || $admission->forward)
                                    <tr>
                                        <td class="px-2 text-center my-auto">
                                            @if(auth()->user()->role == 'reception' && $admission->new)
                                                <i class="bg-primary rounded-pill px-2 text-light"> new </i>
                                            @endif
                                            @if(auth()->user()->role == 'school director' && !$admission->checked)
                                                <i class="bg-primary rounded-pill px-2 text-light"> not checked </i>
                                            @endif
                                                <p class="">admit/{{ $admission->id }}</p>
                                        </td>
                                        <td class="px-2 text-center">{{ strtoupper($admission->full_name) }}</td>
                                        <td class="px-2 text-center">{{ \Carbon\Carbon::parse($admission->dob)->diffInYears(\Carbon\Carbon::now())  }}</td>
                                        <td class="px-2 text-center">{{ strtoupper($admission->gender) }}</td>
                                        <td class="status px-2 text-center fw-bold @if(strtoupper($admission->approved)) text-success @else text-warning @endif ">
                                            @if(strtoupper($admission->approved)) Approved @else Not Approved @endif
                                        </td>
                                        <td class="px-2 text-center">{{ Carbon\Carbon::parse($admission->created_at)->format('l, d-m-Y') }}</td>
                                        <td class="px-2 text-center"><a
                                                href="/admission/{{ $admission->id  }}"
                                                class="btn btn-warning">Detail</a></td>

                                        <td class="text-center">
                                            <form
                                                action="{{ route('admission.destroy', ['admission' => $admission->id ]) }}"
                                                method="POST">
                                                @csrf
                                                @method('delete')

                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- MAIN -->

    <script>


        function filterStatus() {
            const selectStatus = document.getElementById('status');
            const tableBody = document.getElementById('children-list');
            const rows = tableBody.getElementsByTagName('tr');


            for (const row of rows) {
                const status = row.querySelector('td.status').textContent;

                if (selectStatus.value === 'all') {
                    row.style.display = 'table-row';
                } else {
                    console.log(selectStatus.value)
                    console.log(status.toLowerCase())
                    if (selectStatus.value === status.toLowerCase().trim())
                        row.style.display = 'table-row';
                    else
                        row.style.display = 'none';
                }
            }

        }

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
