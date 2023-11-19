<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Kids Club</title>
    <link rel="icon" href="{{ asset('image/image-logo.png') }}">

    <!-- CSS and Script Resource -->
    @vite(['resources/css/homepage.css','resources/css/login.css','resources/css/admission.css', 'resources/js/homepage.js', 'resources/js/login.js'])

    <!-- Box Icons -->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    />

    <!-- Google Fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;1,200;1,400&family=Poppins:ital,wght@0,500;1,300&family=Shantell+Sans:ital,wght@0,400;1,300&display=swap"
        rel="stylesheet"
    />
</head>
<body>

@if(Session::has('success'))
    <div id="flash-message" class="bg-transparent center fixed-bottom mb-3 p-3 "
         style="color: #1a202c; background: rgba(193,243,202,0.88); position: fixed; top: 0; left: 50%; transform: translateX(-50%); display: flex; justify-content: center; margin-top: 16px; padding: 16px; border-radius: 5px; z-index: 999;">
        <div  class="alert alert-success">
            Messages
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('flash-message').style.display = 'none';
            }, 3000);
        </script>
    </div>
@endif

<header>
    <nav>
        <div class="logo">
            <img src="{{ asset('image/logo-colorful.png') }}" alt="logo"/>
        </div>

        <button id="loginButton" class="login btn secondary-btn nunito"> Log in</button>

        <div class="login-popup @unless(old('unique_name')) d-none @endif " id="loginPopup">
            <div class="popup-content" style="
                    background: url({{ asset('image/login-background.png') }} );
                    background-position: center;
                    background-size: cover;
                    background-repeat: no-repeat;">
                <div class="logo-img center">
                    <img src="{{ asset('image/logo-colorful.png') }}" alt="logo" class="login-img">
                </div>
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @error('status')
                    <span class="invalid-feedback" role="alert"><strong id="err-msg"
                                                                        style="color: red; text-align: center">{{ $message }}</strong></span>
                    @enderror

                    @error('unique_name')
                    <span class="center" role="alert"><strong id="err-msg"
                                                              style="color: red; text-align: center">{{ $message }}</strong></span>
                    @enderror

                    <label for="login-unique_name">Username:</label>
                    <input id="login-unique_name" type="text" name="unique_name"
                           class="@error('unique_name') is-invalid @enderror" value="{{ old('unique_name') }}" required
                           autofocus>

                    <label for="password">Password:</label>
                    <input id="login-password" type="password" name="password"
                           class="@error('password') is-invalid @enderror" required autofocus>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
                    @enderror

                    <div class="center">
                        <a id="closeButton" class="btn dark-btn text-light" onclick="closePopup()">Close</a>
                        <button type="submit" class="btn primary-btn text-light">Login</button>
                    </div>
                </form>
                @if (Route::has('password.request'))
                    <a class="orange" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
                <p>Have no account? <a href="#"><span class="orange">Admission</span></a></p>
            </div>
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
<main>
    <h1 class="main-heading">
      <span class="underline">
        Admission Form
      </span>
    </h1>
    <section class="admission-form" style="
    background: url({{ asset('image/admission-background-two.png') }});
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;">
        <form action="/admission" method="POST">
            @csrf

            <div class="form-display">
                <div class="admission-form">
                    <h3 class="form-header">Child Information</h3>

                    <div class="form-group">
                        <label for="full_name">Child's Full Name:</label>
                        <input type="text" id="full_name" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob"
                               max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Gender:</label>
                        <div class="radio-group">
                            <input type="radio" id="male" name="gender" value="male" required>
                            <label for="male">Male</label>

                            <input type="radio" id="female" name="gender" value="female" required>
                            <label for="female">Female</label>
                        </div>
                    </div>
                </div>
                <div class="admission-form">
                    <h3 class="form-header">Admission Information</h3>
                    <div class="form-group">
                        <label for="previous_school">Previous School (if any):</label>
                        <input type="text" id="previous_school" name="previous_school">
                    </div>

                    <div class="form-group">
                        <label for="applying_program">Applying Program (Grade)</label>
                        <input type="text" id="applying_program" name="applying_program" required>
                    </div>

                    <div class="form-group">
                        <label for="medical_condition">Medical Conditions (if any):</label>
                        <textarea id="medical_condition"
                                  rows="5"
                                  name="medical_condition"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-display">
                <div class="admission-form">
                    <h3 class="form-header"> Parental Information</h3>
                    <div class="form-group">
                        <label for="father_name">Mother's Name :</label>
                        <input type="text" id="father_name" name="father_name" required>
                    </div>

                    <div class="form-group">
                        <label for="mother_name">Father's Name :</label>
                        <input type="text" id="mother_name" name="mother_name" required>
                    </div>

                    <div class="form-group">
                        <label for="additional_info">Additional Information (Optional)</label>
                        <textarea id="additional_info" name="additional_info"></textarea>
                    </div>
                </div>

                <div class="admission-form">
                    <h3 class="form-header">Address Information </h3>

                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="center">
                        <button type="submit" class="btn primary-btn">Submit</button>
                    </div>
                </div>
            </div>

        </form>
    </section>
</main>
<section id="footer">
    <footer class="footer-section ">
        <div class="footer-container center">
            <div class="footer-logo center">
                <a href="/#home"><img src="{{ asset('image/logo-black.png') }}" alt="Logo"></a>
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
                    <a href="www.facebook.com/kidsclub" class="social-icon" title="facebook"><i
                            class='bx bxl-facebook-circle' style='color:#2c71f9'></i></a>
                    <a href="www.instagram.com//kidsclub" class="social-icon" title="instagram"><i
                            class='bx bxl-instagram-alt' style='color: #fd3c66;'></i></a>
                    <a href="www.linkedin//kidsclub" class="social-icon" title="linkedin"><i
                            class='bx bxl-linkedin-square' style='color:#2c69f9'></i></a>
                    <a href="www.youtube.com//kidsclub" class="social-icon" title="youtube"><i class='bx bxl-youtube'
                                                                                               style='color:#ff0028'></i></a>
                </div>
            </div>
        </div>
        <small class="">
            2023 &copy; By Group Four
        </small>
    </footer>
</section>
<script>

    // Handle sandwich menu toggle
    function toggleMobileMenu(action) {
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const closeMenu = document.querySelector('.close-menu');

        if (action === 'show') {
            console.log(mobileMenu.classList)
            mobileMenu.classList.add('show');
            hamburgerMenu.classList.add('hide');
            closeMenu.classList.add('show');
        } else {
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
        document.getElementById('login-password').value = '';
        document.getElementById('login-unique_name').value = '';
        document.getElementById('err-msg').textContent = '';
    }

    // Add event listener to the login button to open the popup
    document.getElementById("loginButton").addEventListener("click", openPopup);
</script>
</body>
</html>
