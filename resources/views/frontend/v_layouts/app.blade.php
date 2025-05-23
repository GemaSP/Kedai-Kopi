<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Kopi</title>
    <!-- Favicon -->
    <link href="frontend/img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('frontend/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
</head>

<body>
    <!-- Header Start -->
    <!-- Navbar Start -->
    <div class="container-fluid p-0 nav-bar">
        <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
            <a href="" class="navbar-brand px-lg-4 m-0">
                <h1 class="m-0 display-4 text-uppercase text-white">Kopi</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav m1-auto p-4">
                    <a href="{{ route('frontend.home') }}" class="nav-item nav-link active">Home</a>
                    <a href="{{ route('frontend.home') }}#about" class="nav-item nav-link">About</a>
                    <a href="{{ route('frontend.home') }}#service" class="nav-item nav-link">Service</a>
                    <a href="{{ route('frontend.home') }}#menu" class="nav-item nav-link">Menu</a>
                    <a href="{{ route('frontend.home') }}#reserve" class="nav-item nav-link">Reservation</a>
                    <a href="{{ route('frontend.home') }}#contact" class="nav-item nav-link">Contact</a>
                </div>
            </div>

            <div class="d-flex align-items-center me-4 pe-4">
                <!-- Icon Keranjang -->
                @if (auth()->check())
                <a href="{{ route('frontend.keranjang.index') }}" class="text-white position-relative px-3">
                    <i class="fa fa-shopping-cart fa-lg"></i>
                    @if ($keranjangCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $keranjangCount }}
                    </span>
                    @endif
                </a>
                @else
                <a href="#" onclick="keranjangAlert()" class="text-white position-relative px-3">
                    <i class="fa fa-shopping-cart fa-lg"></i>
                </a>
                @endif
                @if (Auth::user())
                <!-- Dropdown User Logged In -->
                <div class="dropdown px-3">
                    <a href="#" class="d-flex align-items-center text-white dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- Avatar -->
                        <img src="{{ asset('storage/image/foto-profil/' . ($user->foto ?? 'default.jpg')) }}" class="rounded-circle" width="30" height="30" alt="Avatar">
                        <!-- Nama User -->
                        <span class="ml-2 d-none d-md-inline">{{ Auth::user()->nama }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('frontend.profilSaya') }}">Profil</a>
                        <a class="dropdown-item" href="{{ route('frontend.pesanan.index') }}">Pesanan Saya</a>
                        <a class="dropdown-item" href="{{ route('frontend.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Keluar
                        </a>
                        <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
                @else
                <!-- Dropdown Login/Daftar -->
                <div class="dropdown px-3">
                    <a href="#" class="text-white dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('frontend.login') }}">Login</a>
                        <a class="dropdown-item" href="{{ route('frontend.register') }}">Daftar</a>
                    </div>
                </div>
                @endif
            </div>
        </nav>
    </div>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid footer text-white mt-5 pt-5 px-0 position-relative overlay-top">
        <div class="row mx-0 pt-5 px-sm-3 px-lg-5 mt-4">
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Get In Touch</h4>
                <p><i class="fa fa-map-marker-alt mr-2"></i>Jalan 123, Bogor, Jabar</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+62 812 9770 5514</p>
                <p><i class="fa fa-envelope mr-2"></i>gesap@gmail.com</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Follow Us</h4>
                <p>Mampir ke sosmed, siapa tau ada promo ngopi!</p>
                <div class="d-flex justify-content-start">
                    <a href="#" class="btn btn-lg btn-outline-light btn-lg-square mr-2"><i
                            class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-lg btn-outline-light btn-lg-square mr-2"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-lg btn-outline-light btn-lg-square mr-2"><i
                            class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="btn btn-lg btn-outline-light btn-lg-square mr-2"><i
                            class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Open Hours</h4>
                <h6 class="text-white text-uppercase">Monday - Friday</h6>
                <p>8.00 AM - 8.00 PM</p>
                <h6 class="text-white text-uppercase">Saturday - Sunday</h6>
                <p>2.00 PM - 8.00 PM</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-white text-uppercase mb-4" style="letter-spacing: 3px;">Newsletter</h4>
                <p>Dapetin update kopi, promo, dan cerita seru langsung ke inbox kamu.</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" name="" id="" class="form-control border-light" style="padding: 25px;" placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary font-weight-bold px-3">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid text-center text-white border-top mt-4 py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1)!important;">
            <p class="mb-2 text-white">Copyright &copy; <a href="#" class="font-weight-bold">KOPI</a>. All Rights Reserved.</p>
            <p class="m-0 text-white">Designed by<a href="#" class="font-weight-bold"> Gesap</a></p>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="frontend/lib/easing/easing.min.js"></script>
    <script src="frontend/lib/waypoints/waypoints.min.js"></script>
    <script src="frontend/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="frontend/lib/tempusdominus/js/moment.min.js"></script>
    <script src="frontend/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="frontend/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="frontend/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function keranjangAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Login Dulu',
                text: 'Silakan login untuk melihat keranjang belanja Anda.',
                confirmButtonText: 'Login',
                confirmButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('frontend.login') }}";
                }
            });
        }
    </script>
</body>

</html>