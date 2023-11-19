<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title and Icon Logo-->
    <title>Kids Club</title>
    <link rel="icon" href="{{ asset('image/image-logo.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Shantell+Sans:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet"
    />


    <!-- Box Icons -->
    <link
        href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
        rel="stylesheet"
    />


    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])

    <script>
        const isDarkMode = localStorage.getItem('darkMode');
        const isMinimizeMode = localStorage.getItem('minimizeMode');

        window.addEventListener('DOMContentLoaded', function () {
            if (isDarkMode === 'dark') {
                this.document.body.classList.add('dark');
            } else if (isDarkMode === 'light') {
                this.document.body.classList.add('remove');
            }

            if (isMinimizeMode === 'on') {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.add('hide');
            }
        });

    </script>
</head>
<body>
<!-- SIDEBAR -->
<section id="sidebar">
    <a href="/" class="brand-logo">
        <img src="{{ asset('image/image-logo.png') }}" alt="logo-img"/>
    </a>

    <ul class="side-menu top nunito">
        @unless(Hash::check('changeme', auth()->user()->password))
            @if(auth()->user()->role == 'child')
                <li class="active">
                    <a href="/home">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/profile/{{ auth()->user()->profile->id }}">
                        <i class="bx bxs-user-account"></i>
                        <span class="text">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="/noticeboard/{{ auth()->user()->profile->classroom->id }}">
                        <i class="bx bxs-bell"></i>
                        <span class="text">Notice</span>
                    </a>
                </li>
                <li>
                    <a href="/progress/{{ auth()->user()->profile->progress->id }}">
                        <i class="bx bx-line-chart"></i>
                        <span class="text">Progress Report</span>
                    </a>
                </li>
                <li>
                    <a href="/bill-record/{{ auth()->user()->profile->id }}">
                        <i class="bx bx-dollar-circle"></i>
                        <span class="text">Billing</span>
                    </a>
                </li>
                <li>
                    <a href="/chat">
                        <i class="bx bxs-message-dots"></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="/schedule/{{ auth()->user()->profile->classroom->schedule->id }}">
                        <i class="bx bxs-calendar"></i>
                        <span class="text">Class Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('password.change') }}">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'teacher')
                @php
                    $teacher = auth()->user()->staff->teacher;
                @endphp
                <li class="active">
                    <a href="/teacher-dashboard">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                @if(auth()->user()->staff->teacher->classroom)
                    <li>
                        <a href="/register">
                            <i class='bx bxs-add-to-queue'></i>
                            <span class="text">New Registration</span>
                        </a>
                    </li>
                    <li>
                        <a href="/profile/classroom/{{ $teacher->classroom->id  }}">
                            <i class="bx bxs-user-account"></i>
                            <span class="text">Children Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="/profile/classroom/{{ $teacher->classroom->id  }}">
                            <i class="bx bx-line-chart"></i>
                            <span class="text">Progress Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="/noticeboard/{{ $teacher->classroom->id }}">
                            <i class="bx bxs-bell"></i>
                            <span class="text">Notice Board</span>
                        </a>
                    </li>
                    <li>
                        <a href="/schedule/{{ $teacher->classroom->schedule->id }}">
                            <i class="bx bxs-calendar"></i>
                            <span class="text">Class Schedule</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="/chat">
                        <i class="bx bxs-message-dots"></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('password.change') }}">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'accountant')
                <li class="active">
                    <a href="/accountant-dashboard">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/profile">
                        <i class="bx bxs-user-account"></i>
                        <span class="text">Children Bill Record</span>
                    </a>
                </li>
                <li>
                    <a href="/schoolfee">
                        <i class='bx bxs-book-content'></i>
                        <span class="text">School Fee</span>
                    </a>
                </li>
                <li>
                    <a href="/bank-info">
                        <i class='bx bxs-bank'></i>
                        <span class="text">Bank Information</span>
                    </a>
                </li>
                <li>
                    <a href="/chat">
                        <i class="bx bxs-message-dots"></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('password.change') }}">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'school director')
                <li class="active">
                    <a href="/director-dashboard">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/staff-register">
                        <i class='bx bxs-add-to-queue'></i>
                        <span class="text">New Registration</span>
                    </a>
                </li>
                <li>
                    <a href="/admission/index">
                        <i class='bx bxs-user'></i>
                        <span class="text">Admission</span>
                    </a>
                </li>
                <li>
                    <a href="/profile">
                        <i class="bx bxs-user-account"></i>
                        <span class="text">Children Management</span>
                    </a>
                </li>
                <li>
                    <a href="/staff/teacher">
                        <i class="bx bxs-group"></i>
                        <span class="text">Teacher Management</span>
                    </a>
                </li>
                <li>
                    <a href="/noticeboard">
                        <i class="bx bxs-bell"></i>
                        <span class="text">Notice Board</span>
                    </a>
                </li>
                <li>
                    <a href="/classroom">
                        <i class='bx bxs-door-open'></i>
                        <span class="text">Classroom Management</span>
                    </a>
                </li>
                <li>
                    <a href="/chat">
                        <i class="bx bxs-message-dots"></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('password.change') }}">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            @elseif(auth()->user()->role == 'system admin')
                <li class="active">
                    <a href="/admin-dashboard">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/all-users">
                        <i class='bx bxs-user-circle'></i>
                        <span class="text">User Account Management</span>
                    </a>
                </li>
                <li>
                    <a href="/chat">
                        <i class="bx bxs-message-dots"></i>
                        <span class="text">Message</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('password.change') }}">
                        <i class="bx bx-transfer-alt"></i>
                        <span>Change Password</span>
                    </a>
                </li>
            @endif
        @elseif(auth()->user()->role == 'reception')
            <li class="active">
                <a href="/reception-dashboard">
                    <i class="bx bxs-dashboard"></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/register">
                    <i class='bx bxs-add-to-queue'></i>
                    <span class="text">Register</span>
                </a>
            </li>
            <li>
                <a href="/admission/index">
                    <i class='bx bxs-user-circle'></i>
                    <span class="text">Admission</span>
                </a>
            </li>
            <li>
                <a href="/contact-message">
                    <i class='bx bxs-envelope'></i>
                    <span class="text">Contact Message</span>
                </a>
            </li>
            <li>
                <a href="/chat">
                    <i class="bx bxs-message-dots"></i>
                    <span class="text">Message</span>
                </a>
            </li>
            <li>
                <a href="{{ route('password.change') }}">
                    <i class="bx bx-transfer-alt"></i>
                    <span>Change Password</span>
                </a>
            </li>
        @endif
        <li>
            <a class="text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class="bx bx-log-out"></i>
                <span class="active">Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->
<!-- CONTENT -->
<section id="content">
    <!-- NAVBAR -->
    <nav class="flex justify-content-between">
        <div class="left-nav-bar">

        </div>
        <i class="bx bx-menu" style="font-size: 25px"></i>
        <a href="/" class="nav-link"><img src="{{ asset('image/kids-club-logo.png') }}" alt="logo-word"></a>
        <form action="#" style="visibility: hidden;">
            <div class="form-input">
                <label>
                    <input type="search" placeholder="Search..."/>
                </label>
                <button type="submit" class="search-btn">
                    <i class="bx bx-search"></i>
                </button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden/>
        <label for="switch-mode" class="switch-mode"></label>
        @if($staff = auth()->user()->staff)
            @if($teacher = $staff->teacher)
                @if($staff->teacher->classroom)
                    <a href="/noticeboard/{{ $teacher->classroom->id }}" class="bell">
                        <i class="bx bxs-bell"></i>
                        {{--            <span class="num">4</span>--}}
                    </a>
                @endif
            @elseif($director = $staff->schoolDirector)
                <a href="/noticeboard" class="bell">
                    <i class="bx bxs-bell"></i>
                    {{--            <span class="num">4</span>--}}
                </a>
            @endif
        @elseif($child = auth()->user()->profile)
            <a href="/noticeboard/{{ $child->classroom->id }}" class="bell">
                <i class="bx bxs-bell"></i>
                {{--            <span class="num">4</span>--}}
            </a>
        @endif

        @php
            if(Auth::user()->unique_name === 'admin'){
                $profileLink = '#';
            }else{
                $profileLink = match (Auth::user()->role){
                    'child' => '/profile/'.Auth::user()->profile->id,
                    'teacher' => '/staff/show/'.Auth::user()->staff->id,
                    'accountant' => '/staff/accountant/'.Auth::user()->staff->id,
                    'school director' => '/staff/director/'.Auth::user()->staff->id,
                    'system admin' => '/staff/admin/'.Auth::user()->staff->id,
                    'reception' => '/staff/reception/'.Auth::user()->staff->id,

                };
            }

            if(Auth::user()->unique_name === 'admin'){
                $imagePath = asset('image/No-profile.png');
                $userName = 'admin';
            }
            elseif(Auth::user()->role === 'child'){
                $imagePath = asset('storage/'.Auth::user()->profile->profile_pic);
                $userName = Auth::user()->profile->first_name;
            }
            else{
                $imagePath = asset('storage/'.Auth::user()->staff->profile_pic);
                $userName = Auth::user()->staff->first_name;
            }
        @endphp
        @auth()
            <a href="{{ $profileLink }}" class="profile">
                <img
                    src="{{ $imagePath }}"
                    alt="profile picture"/>

            </a>
        @endauth
        <div class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="/profile" role="button"
               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ $userName }}
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

    </nav>
    <!-- NAVBAR -->

    @yield('content')

</section>
<script>
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

    allSideMenu.forEach(item => {
        const li = item.parentElement;

        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            })
            li.classList.add('active');
        })
    });

    // TOGGLE SIDEBAR
    const menuBar = document.querySelector('#content nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');

    menuBar.addEventListener('click', toggleSidebar)

    // When screen width reaches certain limits
    let fired = false;
    let minimized = false;
    window.addEventListener('resize', function () {
        if (window.innerWidth < 768) {
            if (!fired && !sidebar.classList.contains('hide')) {
                fired = true;
                toggleSidebar();
            }
        } else {
            fired = false;
        }
    });

    // Sidebar toggle function
    function toggleSidebar() {
        sidebar.classList.toggle('hide');
        let menuBarValue = localStorage.getItem('minimizeMode') === 'on' ? 'off' : 'on';
        localStorage.setItem('minimizeMode', menuBarValue);
    }

    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');

    searchButton.addEventListener('click', function (e) {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if (searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    })


    if (window.innerWidth < 768) {
        sidebar.classList.add('hide');
    } else if (window.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }


    window.addEventListener('resize', function () {
        if (this.innerWidth > 576) {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
            searchForm.classList.remove('show');
        }
    })


    const switchMode = document.getElementById('switch-mode');

    switchMode.addEventListener('change', function () {
        if (this.checked) {
            document.body.classList.add('dark');
            localStorage.setItem('darkMode', 'dark');
        } else {
            document.body.classList.remove('dark');
            localStorage.setItem('darkMode', 'light');
        }
    })

    if (isDarkMode === 'dark') {
        switchMode.click();
    }
</script>
</body>
</html>
