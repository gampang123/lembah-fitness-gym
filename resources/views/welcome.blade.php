<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>Lembah Fitness Gym</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('common/css/landingpages.css') }}">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- AOS Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body class="flex flex-col min-h-screen" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="70"
    tabindex="0">
    <header class="fixed-top transparent" id="mainHeader">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark px-0">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="#home">
                    <img style="width: 50px;" src="{{ asset('asset/logo-circle.svg') }}" alt="Logo"
                        class="me-2" />
                </a>

                <!-- Hamburger -->
                <button class="navbar-toggler" type="button" id="hamburgerBtn" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Overlay -->
                <div id="overlay" class="overlay d-lg-none"></div>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#fasilitas">Fasilitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#member">Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#kontak">Kontak</a>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('login') }}" class="btn btn-danger">Login</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>



    <section id="home" class="hero-video position-relative">
        <video autoplay muted loop playsinline
            class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 z-n1">
            <source src="{{ asset('asset/gym-hero.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div
            class="container d-flex flex-column justify-content-center align-items-center text-center text-white min-vh-100">
            <h1 class="display-4 fw-bold text-shadow">Jangan Menyerah, Keringatmu Adalah Kunci!</h1>
            <p class="lead text-shadow">Bangun kekuatanmu hari ini, dan jadilah versi terbaik dirimu di gym!</p>
            <a href="#fasilitas" class="btn btn-danger btn-lg mt-3">Lihat Fasilitas</a>
        </div>
    </section>


    <section id="about" class="py-5 bg-light">
        <div class="container pt-5 pb-28">
            <div class="row align-items-center">
                <!-- Gambar -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="{{ asset('asset/about.jpg') }}" alt="Tentang Gym" class="img-fluid rounded shadow">
                </div>

                <!-- Teks -->
                <div class="col-md-6" style="border-right: 2px solid red;">
                    <h2 class="fw-bold mb-3">Tentang Kami</h2>
                    <p class="text-muted">
                        Kami adalah pusat kebugaran modern yang menyediakan berbagai fasilitas dan program latihan untuk
                        semua kalangan.
                        Mulai dari pemula hingga atlet profesional, kami mendukung perjalanan fitness Anda dengan
                        pelatih profesional,
                        peralatan terbaik, dan suasana positif.
                    </p>
                    <p class="text-muted">
                        Komitmen kami adalah membantu Anda mencapai kesehatan optimal dan gaya hidup aktif.
                        Bergabunglah bersama kami dan mulai transformasi dirimu sekarang!
                    </p>
                </div>
            </div>
        </div>
        <div class="marquee-section">
            <div class="marquee-content">
                <b> Selamat datang di Lembah Fitness Gym! Ayo capai tubuh sehat dan bugar bersama kami! | Selamat datang
                    di
                    Lembah Fitness Gym! Ayo capai tubuh sehat dan bugar bersama kami! | Selamat datang di Lembah Fitness
                    Gym!
                    Ayo capai tubuh sehat dan bugar bersama kami! | Selamat datang di Lembah Fitness Gym!
                    Ayo capai tubuh sehat dan bugar bersama kami! |</b>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light" id="fasilitas">
        <div class="container text-center">
            <h2 class="mb-5 fw-bold">Keunggulan Lembah Fitness Gym</h2>
            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-3" data-aos="fade-up">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-house-gear fs-1 text-primary mb-3"></i>
                            <h5 class="card-title fw-bold">Tempat Bersih</h5>
                            <p class="card-text text-muted">Kami menjaga kebersihan setiap area agar tetap nyaman dan
                                higienis.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-tools fs-1 text-success mb-3"></i>
                            <h5 class="card-title fw-bold">Alat Lengkap</h5>
                            <p class="card-text text-muted">Dilengkapi dengan peralatan modern untuk berbagai jenis
                                latihan.</p>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-mortarboard fs-1 text-warning mb-3"></i>
                            <h5 class="card-title fw-bold">Trainer Profesional</h5>
                            <p class="card-text text-muted">Dilatih oleh lulusan akademik olahraga yang bersertifikat.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-cash-stack fs-1 text-danger mb-3"></i>
                            <h5 class="card-title fw-bold">Harga Terjangkau</h5>
                            <p class="card-text text-muted">Paket keanggotaan fleksibel dan sesuai semua kalangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="member" class="pricing">
        <div class="pricing_1">
            <div class="responsive-container-block big-container">
                <div class="responsive-container-block container">
                    <p class="text-blk head">
                        Bergabung Bersama Kami
                    </p>
                    <div class="responsive-container-block card-container">
                        <div class="responsive-cell-block wk-desk-4 wk-ipadp-4 wk-tab-6 wk-mobile-12">
                            <div class="card card-selected">
                                <p class="text-blk">
                                    Paket 1 Bulan
                                </p>
                                <h1 class="monthly-price">
                                    Rp250.000
                                </h1>
                                <div class="card-description">
                                    <span class="monthly-plan">
                                        <p class="text-blk card-points">
                                            Akses Gym Selama 1 Bulan
                                        </p>
                                        {{-- <p class="text-blk card-points">
                                            Ultricies diam arcu.
                                        </p>
                                        <p class="text-blk card-points">
                                            Pellentesque elementum.
                                        </p>
                                        <p class="text-blk card-points">
                                            Leo adipiscing adipiscing.
                                        </p>
                                        <p class="text-blk card-points">
                                            Mattis diam amet.
                                        </p> --}}
                                    </span>
                                </div>
                                <span class="buy-button">
                                    <button class="btns text-black" type="button">
                                        Buy
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="responsive-cell-block wk-desk-4 wk-ipadp-4 wk-tab-6 wk-mobile-12">
                            <div class="card">
                                <p class="text-blk">
                                    Paket 3 Bulan
                                </p>
                                <h1 class="monthly-price">
                                    Rp600.000
                                </h1>
                                <div class="card-description">
                                    <span class="monthly-plan">
                                        <p class="text-blk card-points">
                                            Akses Gym Selama 3 Bulan
                                        </p>
                                        {{-- <p class="text-blk card-points">
                                            Lorem nibh odio montes.
                                        </p>
                                        <p class="text-blk card-points">
                                            Lacus volutpat nunc leo at.
                                        </p>
                                        <p class="text-blk card-points">
                                            Arcu in augue nunc risus.
                                        </p>
                                        <p class="text-blk card-points">
                                            Ornare vestibulum.
                                        </p> --}}
                                    </span>

                                </div>
                                <span class="buy-button">
                                    <button class="btns" type="button">
                                        Buy
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="responsive-cell-block wk-desk-4 wk-ipadp-4 wk-tab-6 wk-mobile-12">
                            <div class="card">
                                <p class="text-blk">
                                    Paket Personal Training
                                </p>
                                <h1 class="monthly-price">
                                    Rp820.000
                                </h1>
                                <div class="card-description">
                                    <span class="monthly-plan">
                                        <p class="text-blk card-points">
                                            Akses Gym Selama 1 Bulan
                                        </p>
                                        <p class="text-blk card-points">
                                            Di latih oleh trainer profesional
                                        </p>
                                        {{-- <p class="text-blk card-points">
                                            Pellentesque elementum.
                                        </p>
                                        <p class="text-blk card-points">
                                            Leo adipiscing adipiscing.
                                        </p>
                                        <p class="text-blk card-points">
                                            Mattis diam amet.
                                        </p> --}}
                                    </span>
                                </div>
                                <span class="buy-button">
                                    <button class="btns" type="button">
                                        Buy
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5"><b>Kontak Kami</b></h2>
            <div class="row">
                <!-- Form -->
                <div class="col-md-6 mb-4">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="tel" class="form-control" id="telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea class="form-control" id="pesan" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Kirim via WhatsApp</button>
                    </form>
                </div>

                <!-- Google Maps -->
                <div class="col-md-6">
                    <div class="ratio ratio-4x3">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.7839295902545!2d110.38780447500528!3d-7.812682592207873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a571a08a55f05%3A0xa5831b1aa3e9386b!2sLembah%20Fitness%20Warungboto!5e0!3m2!1sid!2sid!4v1748138419406!5m2!1sid!2sid"
                            width="600" height="450" style="border:0; border-radius:15px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade">

                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-white py-4" style="background-color: #212529;">
        <div class="container text-center">
            <p class="mb-2">&copy; {{ date('Y') }} Lembah Fitness Gym.</p>
        </div>
    </footer>



    <script>
        document.getElementById("contactForm").addEventListener("submit", function(e) {
            e.preventDefault();

            var nama = document.getElementById("nama").value;
            var telepon = document.getElementById("telepon").value;
            var pesan = document.getElementById("pesan").value;

            var nomorTujuan = "6281946656058";

            var text = `Halo, saya ingin menghubungi:\n\nNama: ${nama}\nNo. Telp: ${telepon}\nPesan: ${pesan}`;

            var url = `https://wa.me/${nomorTujuan}?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        });
    </script>




    <script>
        // Scroll effect
        window.addEventListener("scroll", function() {
            const header = document.getElementById("mainHeader");
            if (window.scrollY > 50) {
                header.classList.add("scrolled");
                header.classList.remove("transparent");
            } else {
                header.classList.remove("scrolled");
                header.classList.add("transparent");
            }
        });

        // Toggle hamburger
        const hamburgerBtn = document.getElementById("hamburgerBtn");
        const mainNav = document.getElementById("mainNav");
        const overlay = document.getElementById("overlay");

        hamburgerBtn.addEventListener("click", function() {
            mainNav.classList.toggle("show");
            overlay.classList.toggle("active");
        });

        overlay.addEventListener("click", function() {
            mainNav.classList.remove("show");
            overlay.classList.remove("active");
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    {{-- PRICNG  --}}
    <script src="{{ asset('common/js/pricing.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
