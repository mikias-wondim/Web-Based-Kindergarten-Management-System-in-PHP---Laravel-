<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Kids Club</title>
    <link rel="icon" href="{{ asset('image/image-logo.png') }}">

    <!-- CSS and Script Resource -->
    @vite(['resources/css/homepage.css','resources/css/login.css', 'resources/js/homepage.js', 'resources/js/login.js'])

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
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('flash-message').style.display = 'none';
            }, 3000);
        </script>
    </div>
@endif

@auth()
    @php
        $dashboard = match (auth()->user()->role){
            'child' => '/home',
            'teacher' => '/teacher-dashboard',
            'accountant' => '/accountant-dashboard',
            'reception' => '/reception-dashboard',
            'system admin' => '/admin-dashboard',
            'school director' => '/director-dashboard',
        }
    @endphp
@endauth

<header>
    <nav>
        <div class="logo">
            <img src="{{ asset('image/logo-colorful.png') }}" alt="logo"/>
        </div>

        @if(auth()->user())

            <a href="{{ $dashboard }}" class="login btn primary-btn nunito" style="position: fixed; z-index: 999;">
                <i class="bx bxs-dashboard"></i> Dashboard</a>

        @else
            <button id="loginButton" class="login btn secondary-btn nunito"> Log in</button>
        @endif
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
                @auth()
                    <li><a href="{{ $dashboard }}">Dashboard</a></li>
                @endauth
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
                @auth()
                    <li><a href="{{ $dashboard }}">Dashboard</a></li>
                @endauth
                <li><a href="{{ route('welcome') }}#contacts">Contact</a></li>
            </ul>
        </div>
    </nav>
</header>
<section id="home" style="background-image: url({{ asset('image/hero-background-two.png') }}); @media screen and (max-width: 767px){
    background-image: url({{ asset('image/small-screen-background.png') }});
  }">
    <div class="desc">
        <h2>Nurture Young Generation</h2>
        <p>
            Rise up little ones where they learn everything they need for the
            future !!
        </p>
        @unless(auth()->user())
            <a href="/admission" class="btn primary-btn">
                Admission<i class="bx bx-right-arrow-alt bx-flashing"></i>
            </a>
        @endif
    </div>
</section>
<section id="about-us">
    <h1 class="under main-heading">
        <span class="underline">About Us</span>
    </h1>

    <div class="about-us-message">
        <div class="text">
            <img src="{{ asset('image/about-us-one.png') }}" alt=""/>
            <div class="paragraph">
                <h3 class="sub-sub-heading">Objective</h3>
                <p>
                    At <span class="orange">Kids Club</span> , we believe in creating
                    a nurturing and inspiring environment where young minds blossom.
                    Our kindergarten is a place where learning is an adventure, and
                    every day brings new opportunities for exploration and discovery.
                </p>
            </div>
        </div>

        <div class="text">
            <div class="paragraph">
                <h3 class="sub-sub-heading">Mission</h3>
                <p>
                    <span class="blue">Our mission</span> is to provide a joyful and
                    inclusive learning experience that lays the foundation for a
                    lifelong love of learning. We foster a supportive community that
                    values diversity and celebrates the unique qualities of each
                    child.
                </p>
            </div>
            <img src="{{ asset('image/about-us-two.png') }}" alt="" class="small-screen-hide"/>
        </div>

        <div class="text">
            <img src="{{ asset('image/about-us-three.png') }}" alt="" class="small-screen-hide"/>
            <div class="paragraph">
                <h3 class="sub-sub-heading">Parent Partnership</h3>
                <p>
                    We recognize the importance of a strong
                    <span class="red">parent-teacher partnership</span>. We encourage
                    open communication and value your involvement in your child's
                    learning journey. Together, we can create a supportive network for
                    your child's growth.
                </p>
            </div>
        </div>
    </div>
    <div class="school-desc">
        <div class="desc-list">
            <div class="icon">
                <i class="bx bx-happy-beaming bx-tada-hover"></i>
            </div>

            @php
                $allChildren = new \App\Http\Controllers\ProfileController();
                $countAllChildren = $allChildren::countAllChildren();
            @endphp
            <div class="number">@if($countAllChildren > 0) {{ $countAllChildren }} @else New @endif</div>

            <div class="type">Cheerful Students</div>
        </div>
        <div class="desc-list">
            <div class="icon">
                <i class="bx bxs-trophy bx-tada-hover"></i>
            </div>
            <div class="number">Many</div>
            <div class="type">Awards and trophies</div>
        </div>
        <div class="desc-list">
            <div class="icon">
                <i class="bx bx-male-female bx-tada-hover"></i>
            </div>
            @php
                $allStaff = new \App\Http\Controllers\StaffController();
                $countAllStaff = $allStaff::countAllStaff();
            @endphp
            <div class="number">@if($countAllStaff > 0) {{ $countAllStaff }} @else Diligent @endif</div>
            <div class="type">Staff Members</div>
        </div>
        <div class="desc-list">
            <div class="icon">
                <i class="bx bx-bus-school bx-tada-hover"></i>
            </div>
            <div class="number">Full</div>
            <div class="type">Facilities</div>
        </div>
    </div>
</section>

<section id="services">
    <h1 class="main-heading">
        <span class="underline">Services</span>
    </h1>

    <div class="grid-container">
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bx-body bx-border-circle"></i>
                    <h2 class="list-title">Active and Healthy</h2>
                    <h3 class="sub-sub-heading">Body</h3>
                </div>
                <div class="content back">
                    <p class="description">
                        Physical activity is a fundamental aspect of childhood
                        development. Our program includes regular outdoor play,
                        age-appropriate exercises, and fun physical activities that
                        promote gross motor skills and overall health. We also provide
                        nutritious meals and snacks to fuel their growing bodies.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-brain bx-border-circle"></i>
                    <h2 class="list-title">Curious and Creative</h2>
                    <h3 class="sub-sub-heading">Mind</h3>
                </div>
                <div class="content back">
                    <p class="description">
                        We believe that every child is a natural explorer and problem
                        solver. Our curriculum is play-based, encouraging hands-on
                        learning and critical thinking. Through engaging activities,
                        children develop their cognitive abilities, language skills, and
                        a lifelong love for learning.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-florist bx-border-circle"></i>
                    <h2 class="list-title">Peaceful and Courageous</h2>
                    <h3 class="sub-sub-heading">Spirit</h3>
                </div>
                <div class="center content back">
                    <p class="description">
                        At kids club, we recognize the importance of nurturing a child's
                        Spirit and Emotional well-being. We promote kindness, empathy,
                        and respect for others. Our environment encourages
                        self-expression and peacefulness, helping children develop a
                        positive self-identity.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-bulb bx-border-circle"></i>
                    <h2 class="list-title">Mindfulness and Relaxation</h2>
                </div>
                <div class="content back">
                    <p class="description">
                        Mindfulness practices are integrated into our daily routines,
                        teaching children to be present and aware of their emotions. We
                        introduce relaxation techniques to help them manage stress and
                        build resilience.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-chart bx-border-circle"></i>
                    <h2 class="list-title">Character Development</h2>
                </div>
                <div class="content back">
                    <p class="description">
                        Character education is a core component of our "Body, Mind,
                        Spirit" approach. We focus on instilling qualities such as
                        honesty, responsibility, and perseverance, which form the
                        foundation of strong character.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bx-target-lock bx-border-circle"></i>
                    <h2 class="list-title">Cultural Awareness</h2>
                </div>
                <div class="content back">
                    <p class="description">
                        We celebrate diversity and teach children about different
                        cultures, customs, and traditions. Our kindergarten is an
                        inclusive space that encourages open-mindedness and global
                        awareness.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-home-heart bx-border-circle"></i>
                    <h2 class="list-title">Family Involvement</h2>
                </div>
                <div class="content back">
                    <p class="description">
                        We believe in the power of the parent-teacher partnership.
                        Regular communication and involvement of parents in our
                        activities create a supportive network for each child's growth.
                    </p>
                </div>
            </div>
        </div>
        <div class="grid-item">
            <div class="card">
                <div class="content front">
                    <i class="bx bxs-building-house bx-border-circle"></i>
                    <h2 class="list-title">Community Engagement</h2>
                </div>
                <div class="content back">
                    <p class="description">
                        We extend our "Body, Mind, Spirit" philosophy beyond our
                        kindergarten walls. Through community engagement activities,
                        children learn the value of giving back and becoming responsible
                        global citizens.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<hr/>

@if(auth()->user())
    @php
        $dashboard = match (auth()->user()->role){
            'child' => '/home',
            'teacher' => '/teacher-dashboard',
            'accountant' => '/accountant-dashboard',
            'reception' => '/reception-dashboard',
            'system admin' => '/admin-dashboard',
            'school director' => '/director-dashboard',
        }
    @endphp

    <div class="login-msg center">
        <a href="{{ $dashboard }}" class="login btn primary-btn nunito">Back to Dashboard</a>
    </div>

@else
    <div class="login-msg center">
        <button class="login btn secondary-btn" onclick="openPopup()"> Log in</button>
        <h3> and check your kid's progress.</h3> <br>
    </div>
@endif
<section id="divider" class="center">
    <img src="{{ asset('image/divider-img.png') }}" alt="divide"/>
</section>
<hr/>
<section id="programs" style="background-image: url({{ asset('image/programs-background.png') }});">
    <h1 class="main-heading"><span class="underline">Programs</span></h1>

    <div class="program-list">
        <div class="program-item">
            <h2>Nursery</h2>
            <div class="program-content">
                <img class="avatar" src="{{ asset('image/nursery.jpg') }}" alt="Nursery Avatar"/>
                <p>
                    In our nursery program, children explore the world around them
                    through play-based learning. We focus on fostering their
                    creativity and imagination, encouraging them to express themselves
                    freely. Our nurturing environment helps children build strong
                    social skills, self-confidence, and a love for learning.
                </p>
            </div>
        </div>
        <div class="program-item">
            <h2>Junior KG</h2>
            <div class="program-content">
                <img class="avatar" src="{{ asset('image/jrkg.jpg') }}" alt="Jr. KG Avatar"/>
                <p>
                    Junior KG is an exciting time for children to build a strong
                    foundation for future learning. Our curriculum is designed to
                    promote cognitive development and problem-solving skills. Through
                    engaging activities, children develop their language and
                    communication abilities while fostering a sense of curiosity and
                    discovery.
                </p>
            </div>
        </div>
        <div class="program-item">
            <h2>Preparatory</h2>
            <div class="program-content">
                <img
                    class="avatar"
                    src="{{ asset('image/preparatory.jpg') }}"
                    alt="Preparatory Avatar"
                />
                <p>
                    Our preparatory program focuses on honing essential academic and
                    life skills to prepare children for primary school. We provide a
                    structured learning environment that emphasizes critical thinking,
                    decision-making, and independence. Our experienced educators
                    instill a strong sense of responsibility and respect for others.
                </p>
            </div>
        </div>
    </div>
</section>
<section id="testimony">
    <h1 class="main-heading">
        <span class="underline">Testimony</span>
    </h1>
    <div class="center container">
        <div class="testimony-container">
            <div class="testimony-card">
                <div class="blockquote">
                    <i class="bx bxs-quote-alt-left"></i> Our experience with the
                    kindergarten has been wonderful. The teachers are caring and
                    provide a nurturing environment for our child's growth. We are
                    impressed with the well-rounded curriculum and how much our child
                    has learned in such a short time."
                </div>
                <img src="{{ asset('image/tesimony-avatar-one.jpg') }}" alt=""/>
                <h2>Alemitu Deressa</h2>
                <p>Parent of Sarah Doe</p>
            </div>
            <div class="testimony-card">
                <div class="blockquote">
                    <i class="bx bxs-quote-alt-left"></i> We couldn't be happier with
                    our decision to enroll our child in this kindergarten. The staff
                    is attentive, and the learning activities are engaging. Our child
                    loves going to school every day and has made great progress in
                    various areas of development."
                </div>
                <img src="{{ asset('image/testimony-avatar-two.jpg') }}" alt=""/>
                <h2>Dereje Asenakew</h2>
                <p>Parent of Amanuel Dereje</p>
            </div>
            <div class="testimony-card">
                <div class="blockquote">
                    <i class="bx bxs-quote-alt-left"></i> The kindergarten has
                    exceeded our expectations. The teachers go above and beyond to
                    create a supportive learning environment. Our child has not only
                    learned important academic skills but also developed social and
                    emotional skills that will benefit her for life."
                </div>
                <img src="{{ asset('image/testimony-avatar-three.jpg') }}" alt=""/>
                <h2>Marta Solomon</h2>
                <p>Parent of Emma Lenda</p>
            </div>

            <div class="testimony-card">
                <div class="blockquote">
                    <i class="bx bxs-quote-alt-left"></i> As first-time parents, we
                    were a bit anxious about sending our child to school. However, the
                    kindergarten staff made us feel comfortable and confident in their
                    care. Our son is thriving, and we are grateful for the wonderful
                    experiences he is having here."
                </div>
                <img src="{{ asset('image/testimony-avatar-four.jpg') }}" alt=""/>
                <h2>Ermia Zewdu</h2>
                <p>Parent of Daniel Ermias</p>
            </div>
            <div class="carousel-nav">
                <span class="prev" onclick="prevTestimony()">&#10094;</span>
                <span class="next" onclick="nextTestimony()">&#10095;</span>
            </div>
        </div>
    </div>
</section>

<!-- Contacts -->

<section id="contacts" class="contacts-section">
    <h1 class="main-heading"><span class="underline">Contact Us</span></h1>

    <div class="container">
        <div class="contacts-container">
            <div class="address">
                <div><i class='bx bxs-location-plus'></i> Location: University of Gondar, Gondar City</div>
                <div><i class='bx bxs-envelope'></i> Email: info@kidsclub.com</div>
                <div><i class='bx bxs-phone'></i> Phone: +251 987 654 321</div>
            </div>

            <p>
                If you have any questions or inquiries, feel free to get in touch
                with us. We'd love to hear from you!
            </p>
            <form action="/contact" method="POST" class="contact-form center">
                @csrf

                <input type="text" name="name" placeholder="Your Name" required/>
                <input type="email" name="email" placeholder="Your Email" required/>
                <textarea name="message" placeholder="Your Message" minlength="15" maxlength="" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
        <div class="side-image">
            <img src="{{ asset('image/contact-side-image.png') }}" alt="side-image"/>
        </div>
    </div>
</section>
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
                @auth()
                    <li><a href="{{ $dashboard }}">Dashboard</a></li>
                @endauth
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
                    <a href="www.youtube.com//kidsclub" class="social-icon" title="youtube"><i
                            class='bx bxl-youtube'
                            style='color:#f92c41'></i></a>
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
