<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Kids Club</title>
    <link rel="icon" href="{{ asset('image/image-logo.png') }}">

    <!-- Styles and Scripts -->
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])
    <!-- CSS and Script Resource -->
    @vite(['resources/css/homepage.css', 'resources/js/homepage.js', 'resources/js/login.js'])


    <!-- Box Icons -->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    />

    <!-- Google Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;1,200;1,400&family=Poppins:ital,wght@0,500;1,300&family=Shantell+Sans:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet"
    />

    <style>
        /* Add your general styling here */

        body{
            background: var(--light)!important;
        }

        .login-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 999;
        }
        .log-img{
            height: 100px;
        }

        img.login-img{
            height: 70px;
            padding-bottom: 20px;
        }

        .popup-content {
            margin: 40px 10px;
            width: 400px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .popup-content h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .popup-content form {
            display: flex;
            flex-direction: column;
        }

        .popup-content label {
            margin-bottom: 10px;
        }

        @media (max-width: 765px) {
            .popup-content{
                width: fit-content;
            }
        }

    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <img src="{{ asset('image/logo-colorful.png') }}" alt="logo" />
        </div>

        <div class="nav-list center small-screen-hide">
            <ul class="nav-bar">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('admission') }}">Admission</a></li>
                <li><a href="{{ route('welcome') }}#about-us">About Us</a></li>
                <li><a href="{{ route('welcome') }}#services">Services</a></li>
                <li><a href="{{ route('welcome') }}#programs">Programs</a></li>
                <li><a href="{{ route('welcome') }}#testimony">Testimony</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="{{ route('welcome') }}#contacts">Contact</a></li>
            </ul>
        </div>

        <!-- Hamburger menu for mobile -->
        <div class="menu">
            <div class="hamburger-menu" onclick="toggleMobileMenu('show')">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="close-menu" onclick="toggleMobileMenu('close')">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Mobile menu content -->
        <div id="mobile-menu" class="mobile-menu">
            <ul>
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('admission') }}">Admission</a></li>
                <li><a href="{{ route('welcome') }}#about-us">About Us</a></li>
                <li><a href="{{ route('welcome') }}#services">Services</a></li>
                <li><a href="{{ route('welcome') }}#programs">Programs</a></li>
                <li><a href="{{ route('welcome') }}#testimony">Testimony</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="{{ route('welcome') }}#contacts">Contact</a></li>
            </ul>
        </div>
    </nav>
</header>

    @yield('content')


<section id="footer">
    <footer class="footer-section ">
        <div class="footer-container center">
            <div class="footer-logo center">
                <a href="#home"><img src="{{ asset('image/logo-black.png') }}" alt="Logo"></a>
            </div>
            <ul class="footer-links">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('admission') }}">Admission</a></li>
                <li><a href="{{ route('welcome') }}#about-us">About Us</a></li>
                <li><a href="{{ route('welcome') }}#services">Services</a></li>
                <li><a href="{{ route('welcome') }}#programs">Programs</a></li>
                <li><a href="{{ route('welcome') }}#testimony">Testimony</a></li>
                <li><a href="#">Blog</a></li>
                <li><a style="cursor: pointer" onclick="openPopup()">Log in</a></li>
                <li><a href="{{ route('welcome') }}#contacts">Contact</a></li>
            </ul>
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p>Location: University of Gondar, Gondar City</p>
                <p>Email: info@kidsclub.com</p>
                <p>Phone: +251 987 654 321</p>
                <div class="footer-social">
                    <a href="www.facebook.com/kidsclub" class="social-icon" title="facebook"><i class='bx bxl-facebook-circle' style='color:#2c71f9'  ></i></a>
                    <a href="www.instagram.com//kidsclub" class="social-icon" title="instagram"><i class='bx bxl-instagram-alt' style='color: #fd3c66;'  ></i></a>
                    <a href="www.linkedin//kidsclub" class="social-icon" title="linkedin"><i class='bx bxl-linkedin-square' style='color:#2c69f9'  ></i></a>
                    <a href="www.youtube.com//kidsclub" class="social-icon" title="youtube"><i class='bx bxl-youtube' style='color:#f92c41'  ></i></a>
                </div>
            </div>
        </div>
        <div class="">
            2023 &copy; By Group Four
        </div>
    </footer>
</section>
<script>
    // JavaScript to handle the testimonial carousel
    let currentTestimony = 0;
    const testimonies = document.querySelectorAll('.testimony-card');

    function showTestimony(n) {
        testimonies.forEach((testimony) => {
            testimony.classList.remove('active');
        });
        testimonies[n].classList.add('active');
    }

    function nextTestimony() {
        currentTestimony = (currentTestimony + 1) % testimonies.length;
        showTestimony(currentTestimony);
    }

    function prevTestimony() {
        currentTestimony = (currentTestimony - 1 + testimonies.length) % testimonies.length;
        showTestimony(currentTestimony);
    }

    // Automatically change testimonies every 5 seconds
    setInterval(nextTestimony, 5000);

    // Display the initial testimony
    showTestimony(currentTestimony);

    // Handle sandwich menu toggle
    function toggleMobileMenu(action) {
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const closeMenu = document.querySelector('.close-menu');

        if(action === 'show'){
            console.log(mobileMenu.classList)
            mobileMenu.classList.add('show');
            hamburgerMenu.classList.add('hide');
            closeMenu.classList.add('show');
        }
        else{
            mobileMenu.classList.remove('show');
            hamburgerMenu.classList.remove('hide');
            closeMenu.classList.remove('show');
        }
    }

    // Log in popup functionality

    // Get the login form popup and the close button
    const loginPopup = document.getElementById("loginPopup");
    const closeButton = document.getElementById("closeButton");

    // Function to open the login form popup
    function openPopup() {
        loginPopup.style.display = "block";
    }

    // Function to close the login form popup
    function closePopup() {
        loginPopup.style.display = "none";
    }

    // Add event listener to the login button to open the popup
    document.getElementById("loginButton").addEventListener("click", openPopup);


</script>
</body>
</html>

