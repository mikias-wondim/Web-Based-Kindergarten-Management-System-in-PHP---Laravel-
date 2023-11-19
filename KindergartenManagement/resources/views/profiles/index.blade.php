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
                <h1 class="heading">List of Children</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">List of Children</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex">
                <div class="dropdown">
                    <lable>Class Room:</lable>
                    <label>
                        <select id="classroom"
                                onchange="displayClassList()"
                                class="form-control dropdown-input"
                                name="classroom" required>
                            <option disabled selected>Select Classroom</option>
                            @foreach($classrooms as $classroom)
                                <option
                                    value="{{ $classroom->classroom_name }}" {{  $classrooms[0]->classroom_name == $classroom->classroom_name ? 'selected' : '' }}>
                                    {{ $classroom->classroom_name }}
                                </option>
                            @endforeach
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
                                <th class="text-center">Child ID</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Middle Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Gender</th>
                                @if(auth()->user()->role == 'teacher')
                                    <th class="text-center">Progress</th>
                                @endif
                                @if(auth()->user()->role == 'accountant')
                                    <th class="text-center">Bill Record</th>
                                @else
                                    <th class="text-center">Profile</th>
                                @endif
                                @if(auth()->user()->role == 'teacher' || auth()->user()->role == 'school director')
                                    <th class="text-center">Remove</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="children-list">
                            @foreach($firstClassChildren as $child)
                                <tr>
                                    <td class="px-2 center"><img class="rounded-circle"
                                                                 src="{{ asset('storage/'.$child->profile_pic) }}"
                                                                 height="50px"
                                                                 alt="profile"></td>
                                    <td class="px-2 text-center">stud/{{ $child->id }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($child->first_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($child->middle_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($child->last_name) }}</td>
                                    <td class="px-2 text-center">{{ strtoupper($child->gender) }}</td>
                                    @if(auth()->user()->role == 'teacher')
                                        <td class="px-2 text-center"><a
                                                href="/progress/{{ $child->progress->id  }}/edit"
                                                class="btn btn-success">Edit</a></td>
                                    @endif
                                    @if(auth()->user()->role == 'accountant')
                                        <td class="px-2 text-center">
                                            <a href="/bill-record/{{ $child->id  }}/edit/"
                                               class="btn btn-warning">Edit</a>
                                        </td>
                                    @else
                                        <td class="px-2 text-center">
                                            <a href="/profile/{{ $child->id  }}"
                                               class="btn btn-warning">View</a>
                                        </td>
                                    @endif

                                    @if(auth()->user()->role == 'teacher' || auth()->user()->role == 'school director')
                                        <td class="text-center">
                                            <form action="{{ route('profile.destroy', ['profile' => $child->id ]) }}"
                                                  method="POST">
                                                @csrf
                                                @method('delete')

                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    @endif
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

        const childrenInClassroom = {!! json_encode($childrenInClassroom) !!};

        function displayClassList() {
            const classSelect = document.getElementById('classroom');
            const tableBody = document.getElementById('children-list');

            tableBody.innerHTML = ''; // clear all the previous children list

            childrenInClassroom[classSelect.value].forEach((childProfile) => {

                // Create the <tr> element
                const tableRow = document.createElement('tr');

                const tdProfilePic = document.createElement('td');
                tdProfilePic.classList.add('center');
                tdProfilePic.classList.add('px-2');

                const profilePic = document.createElement('img');
                profilePic.src = 'storage/' + childProfile['profile_pic'];
                profilePic.classList.add('rounded-circle');
                profilePic.style.height = '50px';

                tdProfilePic.appendChild(profilePic);
                tableRow.appendChild(tdProfilePic);

                const tdID = document.createElement('td');
                tdID.classList.add('text-center');
                tdID.classList.add('px-2');
                tdID.textContent = 'stud' + childProfile['id'];
                tableRow.appendChild(tdID);

                const tdFirstName = document.createElement('td');
                tdFirstName.classList.add('text-center');
                tdFirstName.classList.add('px-2');
                tdFirstName.textContent = childProfile['first_name'].toUpperCase();
                tableRow.appendChild(tdFirstName);

                const tdMiddleName = document.createElement('td');
                tdMiddleName.classList.add('text-center');
                tdMiddleName.classList.add('px-2');
                tdMiddleName.textContent = childProfile['middle_name'].toUpperCase();
                tableRow.appendChild(tdMiddleName);

                const tdLastName = document.createElement('td');
                tdLastName.classList.add('text-center');
                tdLastName.classList.add('px-2');
                tdLastName.textContent = childProfile['last_name'].toUpperCase();
                tableRow.appendChild(tdLastName);

                const tdGender = document.createElement('td');
                tdGender.classList.add('text-center');
                tdGender.classList.add('px-2');
                tdGender.textContent = childProfile['gender'].toUpperCase();
                tableRow.appendChild(tdGender);

                const tdEdit = document.createElement('td');
                tdEdit.classList.add('text-center');
                tdEdit.classList.add('px-2');

                const editAnchor = document.createElement('a');
                editAnchor.href = `\\profile\\${childProfile['id']}`
                editAnchor.classList.add('btn');
                editAnchor.classList.add('btn-primary');
                editAnchor.textContent = 'View';
                tdEdit.appendChild(editAnchor);
                tableRow.appendChild(tdEdit);

                const tdDelete = document.createElement('td');
                tdDelete.classList.add('text-center');
                tdDelete.classList.add('px-2');
                tdDelete.innerHTML = `
                    <form action="/profile/${childProfile['id']}" method="POST">
                                            @csrf
                @method('delete')

                <button class="btn btn-danger">Delete</button>
        </form>
`
                tableRow.appendChild(tdDelete);
                tableBody.appendChild(tableRow);
            })
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
