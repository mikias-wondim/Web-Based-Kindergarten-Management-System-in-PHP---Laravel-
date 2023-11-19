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
                <h1 class="heading">List of Accounts</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="/home" class="active">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">List of Accounts</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex">
                <div class="dropdown">
                    <lable>Filter with:</lable>
                    <label>
                        <select id="role"
                                onchange="filter()"
                                class="form-control dropdown-input"
                                name="role" required>
                            <option
                                value="all" selected>
                                All
                            </option>
                            <option value="child">
                                Child/Student
                            </option>
                            <option value="teacher">
                                Teacher
                            </option>
                            <option value="accountant">
                                Accountant
                            </option>
                            <option value="reception">
                                Reception
                            </option>
                            <option
                                value="director">
                                School Director
                            </option>
                            <option
                                value="admin">
                                System Admin
                            </option>
                        </select>
                    </label>
                    <label>
                        <select id="status"
                                onchange="filter()"
                                class="form-control dropdown-input"
                                name="status" required>
                            <option selected value="all">
                                All
                            </option>
                            <option value="active">
                                Activated
                            </option>
                            <option value="in-active">
                                Deactivated
                            </option>

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
                                <th class="text-center">User ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Middle Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Update</th>
                                <th class="text-center">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="account-list">
                            @foreach($allUsers as $user)
                                @unless($user->unique_name == 'admin')
                                    @php
                                        $userProfile = $user->role == 'child' ? $user->profile: $user->staff;
                                    @endphp
                                    <tr class="{{ strtolower($user->role )}} {{ strtolower($user->status) }}">
                                        <td class="px-2 center"><img class="rounded-circle"
                                                                     src="{{ asset('storage/'.$userProfile->profile_pic) }}"
                                                                     height="50px"
                                                                     alt="profile"></td>
                                        <td class="px-2 text-center">user/{{ $user->id }}</td>
                                        <td class="px-2 text-center">{{ $user->unique_name }}</td>
                                        <td class="px-2 text-center">{{ strtoupper($userProfile->first_name) }}</td>
                                        <td class="px-2 text-center">{{ strtoupper($userProfile->middle_name) }}</td>
                                        <td class="px-2 text-center">{{ strtoupper($userProfile->last_name) }}</td>
                                        <td class="px-2 text-center">{{ ucwords($userProfile->gender) }}</td>
                                        <td class="px-2 text-center">{{ ucwords($user->role) }}</td>
                                        <td class="px-2 text-center">
                                            <form
                                                id="account-form-{{ $user->id }}"
                                                action="/accounts/{{ $user->id }}"
                                                method="POST">
                                                @csrf
                                                @method('patch')
                                                <select name="status"
                                                        onchange="changeStatusBackground(event)"
                                                        class="text-center dark-text form-control btn-outline-light dropdown @if($user->status == 'active') light-success-bg @else light-warning-bg @endif  bg-opacity-50 w-auto">
                                                    <option class="bg-white text-dark"
                                                            value="active" {{ $user->status == 'active'? 'selected': '' }}>
                                                        Activated
                                                    </option>

                                                    <option class="bg-white text-dark"
                                                            value="in-active" {{ $user->status == 'in-active'? 'selected': '' }}>
                                                        Deactivated
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-2 text-center">
                                            <button
                                                onclick="document.getElementById('account-form-{{ $user->id }}').submit()"
                                                class="btn btn-primary">Update
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <form action="/accounts/{{ $user->id }}"
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

        function changeStatusBackground(event) {
            if (event.target.value === 'active') {
                event.target.classList.remove('light-warning-bg')
                event.target.classList.add('light-success-bg')
            } else {
                event.target.classList.remove('light-success-bg')
                event.target.classList.add('light-warning-bg')
            }
        }

        function searchList() {
            const substring = event.target.value.toUpperCase();

            const tableBody = document.getElementById('account-list');
            const rows = tableBody.getElementsByTagName('tr');

            for (const row of rows) {
                const cells = row.getElementsByTagName('td'); // Get all the <td> elements within the current row

                let showRow = false;
                for (const cell of cells) {
                    if (cell.textContent.includes(substring) ) {
                        showRow = true;
                        break; // No need to check further if the substring is found in one of the cells
                    }
                }

                // Show or hide the row based on whether the substring was found
                row.style.display = showRow ? 'table-row' : 'none';
            }
        }

        function filter() {
            const roleSelection = document.getElementById('role').value;
            const statusSelection = document.getElementById('status').value;
            const tableBody = document.getElementById('account-list');
            const rows = tableBody.querySelectorAll('tr');

            if (roleSelection === 'all' && statusSelection === 'all') {
                rows.forEach((row) => {
                    row.style.display = 'table-row';
                })
            } else {
                if (statusSelection === 'all') {
                    rows.forEach((row) => {
                        if (row.classList.contains(roleSelection)) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'none';
                        }
                    })
                }else if(roleSelection === 'all')
                {
                    rows.forEach((row) => {
                        if (row.classList.contains(statusSelection)) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'none';
                        }
                    })
                }
                else{
                    rows.forEach((row) => {
                        if (row.classList.contains(statusSelection) && row.classList.contains(roleSelection)) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'none';
                        }
                    })
                }
            }
        }

    </script>

@endsection
