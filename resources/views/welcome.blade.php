<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMate</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link href="{{ asset('css/index.css') }}" rel="stylesheet">
      
    </head>
   
   <style>
        /* Your CSS rules here */
        body {
          
            background-size: cover;
            background-position: center;
        }

        /* Additional styles for the button */
        #feedbackButton {
            z-index: 999;
            position: absolute;
            bottom: 70px; /* Adjust distance from bottom */
            right: 90px; /* Adjust distance from right */
            background-color: #30defc;
            box-shadow: 5px 10px 10px rgba(0, 0.1, 0.1, 0.2);
            border: 1px solid;
            border-radius: 10px;
            cursor: pointer;
            font-size: 24px;
            transition: transform 0.2s, background-color 0.2s; /* Transition effect for shadow and background */
            
        }

        .feed{
            color: black;
            padding-left: 20px;
            padding-right: 20px;
        }


        /* Change shadow and color on button press */
        #feedbackButton:active {
            box-shadow: 2px 5px 5px rgba(0, 0, 0, 0.3); /* New shadow on button press */
            background-color: #1cb0fc; /* New background color on button press */
        }

        #feedbackButton:active {
    transform: scale(0.60); /* Scale down when button is pressed */
}

        


        /* Other CSS styles as needed */
    </style>



<body class="antialiased" style="background-image: url('{{ asset('css/images/index.jpg') }}'); background-size: cover; background-position: center;">
        <nav class="top-right-links">
        <div >
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in   </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-8 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">   |  Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
            </nav>

       <!-- <section class="hero-section" id="hero">
            <div class="wave">

            <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
             <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
            <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z" id="Path"></path>
             </g>
            </g>
            </svg>

            </div>
            -->
        <div class="container">
            <div class="row align-items-center">
                <!-- Content on the left side -->
                <div class= "welcome">
                    <div style="text-align: center;">
                    <h1 data-aos="fade-right" class="mx-auto">TASKMATE</h1>
                    <p class="mb-5" data-aos="fade-right" data-aos-delay="100">Elevate Your Productivity: Simplify Your Life with <br>Our To-Do List System – Your Key to Achieving More, Stressing Less!</p>
                </div>
            </div>
        </div>
        </section><!-- End Hero -->

        <main id="main">
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <a href="{{ route('feedback.form') }}" class="ripple" >
            <button id="feedbackButton"><p class="feed">
                Feedback here</p>
            </button>
        </a>
       







        <!-- Vendor JS Files -->
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
        </main>
    </body>
</html>
