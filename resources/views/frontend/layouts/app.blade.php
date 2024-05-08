<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
    <meta name="keywords"
        content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

    <title>Apple Shop - eCommerce</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/assets/images/favicon.png">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.css">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/bootstrap/css/bootstrap.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <!-- Icon Font CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/linearicons.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/flaticon.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/simple-line-icons.css">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owlcarousel/css/owl.theme.default.min.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/magnific-popup.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/slick.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/slick-theme.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/responsive.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('cutom_css')

    <style>
        .reveal {
            position: relative;
            transform: translateY(80px);
            opacity: 0;
            transition: all 0.8s ease;
        }

        .reveal.revealActive {
            transform: translateY(0px);
            opacity: 1;
        }
    </style>


</head>

<body>

    {{-- <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> --}}

    <div>
        @yield('content')
    </div>

    <!-- Latest jQuery -->
    <script src="{{ asset('frontend') }}/assets/js/jquery-3.7.1.min.js"></script>
    <!-- popper min js -->
    <script src="{{ asset('frontend') }}/assets/js/popper.min.js"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('frontend') }}/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('frontend') }}/assets/owlcarousel/js/owl.carousel.min.js"></script>
    <!-- magnific-popup min js  -->
    <script src="{{ asset('frontend') }}/assets/js/magnific-popup.min.js"></script>
    <!-- waypoints min js  -->
    <script src="{{ asset('frontend') }}/assets/js/waypoints.min.js"></script>
    <!-- parallax js  -->
    <script src="{{ asset('frontend') }}/assets/js/parallax.js"></script>
    <!-- countdown js  -->
    <script src="{{ asset('frontend') }}/assets/js/jquery.countdown.min.js"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('frontend') }}/assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope min js -->
    <script src="{{ asset('frontend') }}/assets/js/isotope.min.js"></script>
    <!-- jquery.dd.min js -->
    <script src="{{ asset('frontend') }}/assets/js/jquery.dd.min.js"></script>
    <!-- slick js -->
    <script src="{{ asset('frontend') }}/assets/js/slick.min.js"></script>
    <!-- elevatezoom js -->
    <script src="{{ asset('frontend') }}/assets/js/jquery.elevatezoom.js"></script>
    <!-- scripts js -->
    <script src="{{ asset('frontend') }}/assets/js/scripts.js"></script>

    <script type="text/javascript">
        window.addEventListener('scroll', reveal);

        function reveal() {
            var reveals = document.querySelectorAll('.reveal');
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var revealTop = reveals[i].getBoundingClientRect().top;
                var revealPoint = 150;

                if (revealTop < windowHeight - revealPoint) {
                    reveals[i].classList.add('revealActive');
                } else {
                    reveals[i].classList.remove('revealActive');
                }
            }
        }
    </script>


    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>



</body>

</html>
