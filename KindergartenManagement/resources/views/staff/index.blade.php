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
                <h1 class="heading">List of Teachers</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">List of Teachers</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex">
                <div class="dropdown">
                    <lable>Assigned Classroom:</lable>

                    <label>
                        <select id="classroom"
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

                <div class="dropdown mx-2">
                    <lable>Teacher Status: </lable>

                    <label>
                        <select id="status"
                                onchange="displayStatus()"
                                class="form-control dropdown-input"
                                name="status" required>
                            <option disabled selected>Select Status</option>
                            <option>Active</option>
                            <option>Vacation</option>
                            <option>Blocked</option>
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
                                <th class="text-center">Profile Picture</th>
                                <th class="text-center">Teacher ID</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Middle Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Assigned Class</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody id="children-list">
                            @foreach($roles as $teacher)
                                <tr>
                                    <td class="px-2 center"><img class="rounded-circle"
                                                            src="{{ asset('storage/'.$teacher->profile_pic) }}"
                                                            height="50px"
                                                            alt="profile"></td>
                                    <td class="px-2 text-center">teach/{{ $teacher->teacher->id }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($teacher->first_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($teacher->middle_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($teacher->last_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($teacher->gender) }}</td>
                                    <td class="px-2 text-center">@if($teacher->teacher->classroom)
                                        {{ strtoupper($teacher->teacher->classroom->classroom_name) }} @else UNASSIGNED @endif</td>
                                    <td class="px-2 text-center">{{ strtoupper($teacher->status) }}</td>
                                    <td class="px-2 text-center"><a href="/staff/show/{{ $teacher->id  }}"
                                                               class="btn btn-primary">View</a></td>
                                    <td class="text-center">
                                        <form action="{{ route('staff.destroy', ['staff' => $teacher->id ]) }}"
                                              method="POST">
                                            @csrf
                                            @method('delete')

                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
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
        function displayStatus() {
            const statusSelect = document.getElementById('status');
            const tableBody = document.getElementById('children-list');

            const selectedStatus = statusSelect.value.toUpperCase();

            const rows = tableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const statusCell = row.querySelectorAll('td')[7];

                if (statusCell.textContent.includes(selectedStatus)) {
                    row.style.display = 'table-row';
                }else {
                    row.style.display =  'none';
                }
            }
        }

        function displayClassList() {
            const classSelect = document.getElementById('classroom');
            const tableBody = document.getElementById('children-list');

            const selectedClass = classSelect.value.toUpperCase();

            const rows = tableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const assignedClassCell = row.querySelectorAll('td')[6];

                if (assignedClassCell.textContent.includes(selectedClass)) {
                    row.style.display = 'table-row';
                }else {
                    row.style.display =  'none';
                }
            }
        }

        function searchList(){
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
