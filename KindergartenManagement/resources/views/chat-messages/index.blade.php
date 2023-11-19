@extends('layouts.app')

@section('content')

    <main>
        <div class="head-title">
            <div class="left">
                <h1 class="heading">Chat and Messages</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right"></i></li>
                    <li>
                        <a class="active" href="#">Messages</a>
                    </li>
                </ul>
            </div>
        </div>
        <section id="messages" style="height: 70vh">
            @php
                $profile = auth()->user()->staff ?  auth()->user()->staff : auth()->user()->profile;
            @endphp


            <div class="wrapper">
                <section class="users">
                    <header>
                        <div class="content">
                            <img src="{{asset('storage/'.$profile->profile_pic)}}" alt="">
                            <div class="details">
                                <span
                                    class="dark-text">{{ ucwords(strtolower($profile->first_name. ' ' . $profile->middle_name))  }}</span>
                                <small class="text-warning">{{ ucwords($profile->user->role) }}</small>
                                <p>
                                    <small class="dark-text center pe-1">Online
                                        <i class='bx bxs-circle ps-1'
                                           style="font-size: 10px; color: #23f323"></i>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </header>
                    <div id="user-view" class="">
                        <div class="search center">
                            <label for="role">
                                <select name="role" id="role">
                                    <option value="all" selected>All Chats</option>
                                    <option value="child">Child</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="school director">School Director</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="reception">Reception</option>
                                    <option value="system admin">System Admin</option>
                                </select>
                            </label>
                            <button class="" onclick="openSearch()"><i class='bx bx-search-alt-2'>srh</i></button>
                        </div>
                        <div id="users-list" class="">
                            {{-- All users are going to be displayed here --}}

                        </div>
                    </div>

                    <div id="search-view" class="collapse">
                        <div class="search center">
                            <button class="bg-danger" onclick="closeSearch()" style="transform: rotate(180deg)"><i
                                    class='text-white bx bx-search-alt-2'>-></i></button>
                            <label for="role">
                                <select id="filter-role" name="role"
                                        style='border-radius: 0;'
                                        onchange="filterRole()">
                                    <option value="all" selected onchange="">All Roles</option>
                                    <option value="child">Child</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="director">School Director</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="reception">Reception</option>
                                    <option value="admin">System Admin</option>
                                </select>
                            </label>
                            <form action="#" id="search-form" onsubmit="event.preventDefault()">
                                @csrf

                                <input id="user-search" class="" type="text"
                                       name="search-name"
                                       onchange="search()"
                                       placeholder="Enter name to search...">
                                <input id="search-role" type="hidden" name="search-role" value="all">
                            </form>

                            <button class="" onclick="search()"><i class='bx bx-search-alt-2'>srh</i></button>
                        </div>
                        <div id="search-list" class="">
                            {{-- All users are going to be displayed here --}}

                        </div>
                    </div>

                </section>
            </div>

        </section>
    </main>
    <!-- MAIN -->

    <script>

        const usersList = document.getElementById('users-list');
        const userView = document.querySelector('#user-view');
        const searchView = document.querySelector('#search-view');
        const searchList = document.getElementById('search-list');
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('user-search');
        const roleSelection = document.getElementById('filter-role');

        setInterval(() => {
            const selectedRole = document.getElementById('role').value;
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "/get-users/" + selectedRole, true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data.length === 0) {
                            usersList.innerHTML = '<div class="center">No Chats...</div>';
                        } else {
                            usersList.innerHTML = data;
                        }
                    }
                }
            }
            xhr.send();
        }, 500);

        function openSearch() {
            userView.classList.add('collapse')
            searchView.classList.remove('collapse')
        }

        function search() {
            document.getElementById('search-role').value = roleSelection.value;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/search", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (data.length === 0) {
                            searchList.innerHTML = '<div class="center">No Chats Found...</div>';
                        } else {
                            searchList.innerHTML = data;
                        }
                    }
                }
            }
            let form = new FormData(searchForm);
            xhr.send(form);
        }

        function closeSearch() {
            userView.classList.remove('collapse')
            searchView.classList.add('collapse')
            searchInput.value = '';
            searchList.innerHTML = '';
            roleSelection.options[0].selected = true;
        }

        function filterRole() {

            const selectedRole = document.getElementById('filter-role').value;
            const allUsers = searchList.querySelectorAll('li');
            if (selectedRole === 'all') {
                allUsers.forEach((user) => {
                    user.classList.remove('collapse')
                })
            } else {
                allUsers.forEach((user) => {
                    if (user.classList.contains(selectedRole)) {
                        user.classList.remove('collapse')
                    } else {
                        user.classList.add('collapse')
                    }
                })
            }
        }

    </script>

@endsection
