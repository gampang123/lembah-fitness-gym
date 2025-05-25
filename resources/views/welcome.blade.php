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

<body class="flex flex-col min-h-screen">
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
                            <a class="nav-link text-white" href="#">Fasilitas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">Kontak</a>
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

    <section class="py-5 bg-light" id="keunggulan">
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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
