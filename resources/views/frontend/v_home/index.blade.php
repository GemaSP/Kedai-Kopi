@extends('frontend.v_layouts.app')
@section('content')

<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div id="blog-carousel" class="carousel slide overlay-bottom" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="frontend/img/carousel-1.jpg" alt="img" class="w-100">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <h2 class="text-primary font-weight-medium m-0">Kami Hadir dengan Kopi Terbaik</h2>
                    <h1 class="display-1 text-white m-0">Kedai Kopi</h1>
                    <h2 class="text-white m-0">Nikmati Setiap Cangkirnya</h2>
                </div>
            </div>

            <div class="carousel-item">
                <img src="frontend/img/carousel-2.jpg" alt="img" class="w-100">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <h2 class="text-primary font-weight-medium m-0">Kami Hadir dengan Kopi Terbaik</h2>
                    <h1 class="display-1 text-white m-0">Kedai Kopi</h1>
                    <h2 class="text-white m-0">Nikmati Setiap Cangkirnya</h2>
                </div>
            </div>
        </div>
        <a href="#blog-carousel" class="carousel-control-prev" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a href="#blog-carousel" class="carousel-control-next" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
<!-- Carousel End -->
<!-- Header End -->

<!-- About Start -->
<div class="container-fluid py-5" id="about">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                Tentang Kami
            </h4>
            <h1 class="display-4">Kopi Bukan Sekadar Minuman</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 py-0 py-lg-5">
                <h1 class="mb-3">Cerita Kami</h1>
                <h5 class="mb-3">Semua berawal dari cinta kami pada kopi dan suasana hangat di setiap cangkirnya.
                </h5>
                <p>
                    Kami percaya bahwa kopi bukan hanya minuman, tapi cara untuk menyatukan orang, menghangatkan
                    suasana, dan menciptakan momen yang berkesan.
                    Dengan bahan baku berkualitas dan semangat pelayanan, kami hadir untuk memberikan pengalaman
                    ngopi yang berbeda.
                </p>
                <a href="#" class="btn btn-secondary font-weight-bold py-2 px-4 mt-2">Selengkapnya</a>
            </div>
            <div class="col-lg-4 py-5 py-lg-0" style="min-height: 500px;">
                <div class="position-relative h-100">
                    <img src="frontend/img/about.png" alt="Tentang Kami" class="position-absolute w-100 h-100"
                        style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-4 py-0 py-lg-5">
                <h1 class="mb-3">Visi Kami</h1>
                <p>
                    Menjadi tempat kopi pilihan yang bukan hanya menyajikan rasa, tapi juga menciptakan ruang nyaman
                    untuk berbagi cerita dan inspirasi.
                    Setiap sudut kedai kami dirancang untuk membuat siapa pun merasa di rumah.
                </p>
                <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Menjaga kualitas kopi terbaik</h5>
                <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Memberikan pelayanan hangat dan ramah
                </h5>
                <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>Membangun komunitas pencinta kopi</h5>
                <a href="#" class="btn btn-primary font-weight-bold py-2 px-4 mt-2">Selengkapnya</a>
            </div>
        </div>
    </div>
</div>
<!-- About Start -->

<!-- Service Start -->
<div class="container-fluid pt-5" id="service">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Pelayanan Kami</h4>
            <h1 class="display4">Biji Kopi Segar dan Organik</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <img src="frontend/img/service-1.jpg" alt="" class="img-fluid mb-3 mb-sm-0">
                    </div>
                    <div class="col-sm-7">
                        <h4><i class="fa fa-truck service-icon"></i>Pengantaran Cepat</h4>
                        <p class="m-0">Nikmati layanan pengiriman cepat langsung ke rumah Anda. Kami menjamin produk
                            sampai dengan aman, segar, dan tepat waktu agar Anda bisa menikmati kopi terbaik tanpa
                            perlu repot keluar rumah.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <img src="frontend/img/service-2.jpg" alt="" class="img-fluid mb-3 mb-sm-0">
                    </div>
                    <div class="col-sm-7">
                        <h4><i class="fa fa-coffee service-icon"></i>Biji Kopi Segar</h4>
                        <p class="m-0">Kami menyediakan biji kopi pilihan yang dipetik langsung dari kebun terbaik.
                            Setiap biji diseleksi dengan cermat untuk menjaga rasa, aroma, dan kesegaran alami yang
                            istimewa dalam setiap seduhan.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <img src="frontend/img/service-3.jpg" alt="" class="img-fluid mb-3 mb-sm-0">
                    </div>
                    <div class="col-sm-7">
                        <h4><i class="fa fa-award service-icon"></i>Kopi Terbaik</h4>
                        <p class="m-0">Kopi kami dibuat dari biji berkualitas tinggi dengan proses pengolahan yang
                            higienis dan modern. Kami pastikan setiap cangkir menyuguhkan rasa khas, aroma kuat, dan
                            kualitas yang selalu konsisten.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <div class="row align-items-center">
                    <div class="col-sm-5">
                        <img src="frontend/img/service-4.jpg" alt="" class="img-fluid mb-3 mb-sm-0">
                    </div>
                    <div class="col-sm-7">
                        <h4><i class="fa fa-table service-icon"></i>Reservasi Meja Online</h4>
                        <p class="m-0">Nikmati kemudahan reservasi meja secara online kapan saja. Cukup beberapa
                            klik, tempat duduk Anda sudah siap tanpa harus antre atau menunggu lama di lokasi kedai
                            kopi kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->

<!-- Offer Start -->
<div class="offer container-fluid my-5 py-5 text-center position-relative overlay-top overlay-bottom">
    <div class="container py-5">
        <h1 class="display-5 text-primary mt-3">50% OFF</h1>
        <h1 class="text-white mb-3">Sunday Special Offer</h1>
        <h4 class="text-white font-weight-normal mb-4 pb-3">Only for Sunday 1st Jan to 30th Jan 2024</h4>
        <form action="#" class="form-inline justify-content-center mb-4">
            <div class="input-group">
                <input type="text" name="" id="" class="form-control p-4" placeholder="Your Email"
                    style="height: 60px;">
                <div class="input-group-append">
                    <button class="btn btn-primary font-weight-bold px-4" type="submit">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Offer End -->

<!-- Menu Start -->
<div class="container pt-5" id="menu">
    <div class="text-center mb-4">
        <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Menu & Price</h4>
        <h1 class="display-4">Competative Pricing</h1>
        <div class="btn-group mt-3" role="group">
            <button type="button" class="btn btn-outline-primary btn-sm active" id="btnSemua">Semua</button>
            @foreach($menu as $m)
            <button type="button" class="btn btn-outline-primary btn-sm" id="btn{{ $m->nama_menu }}">{{ $m->nama_menu }}</button>
            @endforeach
        </div>
    </div>

    <div class="row" id="produkList">
        @foreach($produk as $p)
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4 produk-item" data-menu="{{ $p->menu->nama_menu }}">
            <div class="card h-100 text-center shadow-sm border-0">
                <img src="{{ asset('storage/image/produk/'. $p->foto) }}" class="card-img-top mx-auto mt-3 rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" alt="{{ $p->nama }}">
                <div class="card-body py-2">
                    <h6 class="card-title mb-1">{{ $p->nama }}</h6>
                    <p class="text-primary font-weight-bold mb-1">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                    <p class="card-text small text-muted mb-2">{{ $p->deskripsi }}</p>
                    <form
                        action="{{ route('frontend.keranjang.store') }}"
                        method="POST"
                        @if (!Auth::check()) onsubmit="showLoginAlert(); return false;" @endif>
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-shopping-cart"></i> Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>


</div>
<!-- Menu End -->

<!-- Reservation Start -->
<div class="container-fluid my-5" id="reserve">
    <div class="container">
        <div class="reservation position-relative overlay-top overlay-bottom">
            <div class="row align-items-center">
                <div class="col-lg-6 my-5 my-lg-0">
                    <div class="p-5">
                        <div class="mb-4">
                            <h1 class="display-3 text-primary">30% OFF</h1>
                            <h1 class="text-white">Untuk Reservasi Meja Online</h1>
                        </div>
                        <p class="text-white">Nikmati pengalaman ngopi yang lebih nyaman dengan memesan meja secara online di kedai kopi kami!
                            Dapatkan diskon spesial 30% hanya dengan reservasi melalui website.</p>
                        <ul class="list-inline text-white m-0">
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Hemat tanpa antre panjang</li>
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Pilih meja favoritmu.</li>
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Berlaku setiap hari*</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center p-5" style="background: rgba(51, 33, 29, .8);">
                        <h1 class="text-white mb-4 mt-5">Book Your Table</h1>
                        <form action="#" class="mb-5">
                            <div class="form-group">
                                <input type="text" name="" id="" placeholder="Name"
                                    class="form-control bg-transparent border-primary p-4" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="" id="" placeholder="Email"
                                    class="form-control bg-transparent border-primary p-4" required>
                            </div>
                            <div class="form-group">
                                <div class="date" id="date" data-target-input="nearest">
                                    <input type="text" name="" id="" placeholder="Date" data-target="#date"
                                        class="form-control bg-transparent border-primary p-4 datetimepicker-input"
                                        data-toggle="datetimepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="time" id="time" data-target-input="nearest">
                                    <input type="text" name="" id="" placeholder="Time" data-target="#time"
                                        class="form-control bg-transparent border-primary p-4 datetimepicker-input"
                                        data-toggle="datetimepicker">
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="" id="" placeholder="Email"
                                    class="custom-select bg-transparent border-primary px-4" style="height: 49px;"
                                    required>
                                    <option selected>Person</option>
                                    <option value="1">Person 1</option>
                                    <option value="2">Person 2</option>
                                    <option value="3">Person 3</option>
                                    <option value="4">Person 4</option>
                                </select>
                            </div>
                            <div>
                                <button class="submit btn btn-primary btn-block font-weight-bold py-3">Book
                                    Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reservation End -->

<!-- Testimonial Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">
                Testimonial
            </h4>
            <h1 class="display-4">Our Clients Say</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img src="frontend/img/testimonial-1.jpg" alt="" class="img-fluid">
                    <div class="ml-3">
                        <h4>Client Name</h4>
                        <i>Professional</i>
                    </div>
                </div>
                <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus laboriosam
                    ad cumque. Cupiditate sed, asperiores tempore, magnam, harum non pariatur esse alias optio
                    dolorum voluptates unde nam dicta vitae debitis.</p>
            </div>
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img src="frontend/img/testimonial-2.jpg" alt="" class="img-fluid">
                    <div class="ml-3">
                        <h4>Client Name</h4>
                        <i>Professional</i>
                    </div>
                </div>
                <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus laboriosam
                    ad cumque. Cupiditate sed, asperiores tempore, magnam, harum non pariatur esse alias optio
                    dolorum voluptates unde nam dicta vitae debitis.</p>
            </div>
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img src="frontend/img/testimonial-3.jpg" alt="" class="img-fluid">
                    <div class="ml-3">
                        <h4>Client Name</h4>
                        <i>Professional</i>
                    </div>
                </div>
                <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus laboriosam
                    ad cumque. Cupiditate sed, asperiores tempore, magnam, harum non pariatur esse alias optio
                    dolorum voluptates unde nam dicta vitae debitis.</p>
            </div>
            <div class="testimonial-item">
                <div class="d-flex align-items-center mb-3">
                    <img src="frontend/img/testimonial-4.jpg" alt="" class="img-fluid">
                    <div class="ml-3">
                        <h4>Client Name</h4>
                        <i>Professional</i>
                    </div>
                </div>
                <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Necessitatibus laboriosam
                    ad cumque. Cupiditate sed, asperiores tempore, magnam, harum non pariatur esse alias optio
                    dolorum voluptates unde nam dicta vitae debitis.</p>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->

<!-- Contact Start -->
<div class="container-fluid pt-5" id="contact">
    <div class="container">
        <div class="section-title">
            <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact Us</h4>
            <h1 class="display-4">Feel Free To Contact</h1>
        </div>
        <div class="row px-3 pb-2">
            <div class="col-sm-4 text-center mb-3">
                <i class="fa fa-2x fa-map-marker-alt mb-3 text-primary"></i>
                <h4 class="font-weight-bold">Address</h4>
                <p>123 Street, New York, USA</p>
            </div>
            <div class="col-sm-4 text-center mb-3">
                <i class="fa fa-2x fa-phone-alt mb-3 text-primary"></i>
                <h4 class="font-weight-bold">Phone</h4>
                <p>+62 812 9770 5514</p>
            </div>
            <div class="col-sm-4 text-center mb-3">
                <i class="fa fa-2x fa-envelope mb-3 text-primary"></i>
                <h4 class="font-weight-bold">Email</h4>
                <p>gesap@gmail.com</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-5">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.5282526954397!2d106.79282277315765!3d-6.581057493412428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c563dc10cb4d%3A0x8ab7ee29dc9ab0d8!2sKanca%20Coffee!5e0!3m2!1sid!2sid!4v1746063421804!5m2!1sid!2sid"
                    width="100%" height="443px" style="border:0;" allowfullscreen="" loading="lazy"
                    aria-hidden="false" tabindex="0" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6 pb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <form action="#" id="contactForm" novalidate="novalidate">
                        <div class="control-group">
                            <input type="text" name="" id="name" class="form-control bg-transparent p-4"
                                placeholder="Your Name" required
                                data-validation-required-message="Please enter your name">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" name="" id="email" class="form-control bg-transparent p-4"
                                placeholder="Your Email" required
                                data-validation-required-message="Please enter your email">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" name="" id="subject" class="form-control bg-transparent p-4"
                                placeholder="Your Subject" required
                                data-validation-required-message="Please enter your subject">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea name="" id="message" rows="5" class="form-control bg-transparent py-3 px-4"
                                placeholder="message" required
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-primary font-weight-bold py-3 px-5" type="submit"
                                id="sendMessageButton">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-group .btn');
        const items = document.querySelectorAll('.produk-item');

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                buttons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const kategori = this.id.replace('btn', '');

                items.forEach(item => {
                    const menu = item.getAttribute('data-menu');
                    if (kategori === 'All' || kategori === 'Semua' || menu === kategori) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
<script>
    function showLoginAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Login Dulu',
            text: 'Silakan login untuk menambahkan produk ke keranjang.',
            confirmButtonText: 'Login',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('frontend.login') }}";
            }
        });
    }
</script>
@if (session('keranjangSuccess'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('keranjangSuccess') }}",
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endsection