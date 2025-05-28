<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembah Fitness Gym</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('common/dashboard/assets/css/swap.css') }}">
    <link rel="stylesheet" href="{{ asset('common/dashboard/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('common/dashboard/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('common/dashboard/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('common/dashboard/assets/css/media_query.css') }}">

    {{-- css dahboard user --}}
    <link rel="stylesheet" href="{{ asset('common/css/dashboard-user.css') }}">
    <link rel="stylesheet" href="{{ asset('common/css/dashboard-package.css') }}">
</head>

<body style="background-color: black">
    <div class="site_content">
        {{-- LOADER MENU--------------------------- --}}

        <div id="preloader">
            <img src="{{ asset('asset/loader.gif') }}" alt="Loading..." />
        </div>
        <section class="section-main-ver p-0">

            @include('sweetalert::alert')

            @yield('content')

        </section>
        {{-- BOTTON MENU--------------------------- --}}
        <div class="bottom-menu-svg-main">
            <div style="background-color: black;" class="bottom-menu-svg">
                <div style="background-color: #356bff;" class="gol3">
                    <div class="add-to-cart-icon">
                        <a href="javascript:void(0);" onclick="openModal('modalQr')">
                            <img style="width: 40px;;" class="home-icon" src="{{ asset('asset/qr-code.svg') }}"
                                alt="footer-cart">
                        </a>
                    </div>
                </div>
                <svg style="background-color: black" class="bottom-menu-svg-design" xmlns="http://www.w3.org/2000/svg"
                    width="600" height="150" viewBox="0 0 600 150" fill="none">
                    <g filter="url(#filter0_b_29_9412)">
                        <path
                            d="M300.8 64.9675C329.077 64.9675 352 44.2102 352 18.6047V18.6047C352 9.71598 358.65 -0.0945674 367.512 0.592055L585.236 17.4608C593.568 18.1064 600 25.0558 600 33.413V149H0V33.4191C0 25.0594 6.4356 18.1087 14.7706 17.4664L234.075 0.565541C242.947 -0.118163 249.6 9.7067 249.6 18.6047V18.6047C249.6 44.2102 272.523 64.9675 300.8 64.9675Z"
                            fill="url(#paint0_linear_29_9412)" />
                    </g>
                    <defs>
                        <filter id="filter0_b_29_9412" x="-32" y="-31.4683" width="664" height="212.468"
                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                            <feGaussianBlur in="BackgroundImageFix" stdDeviation="16" />
                            <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_29_9412" />
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_29_9412"
                                result="shape" />
                        </filter>
                        <linearGradient id="paint0_linear_29_9412" x1="300" y1="-1" x2="300.656"
                            y2="149.001" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#e1e1e1" stop-opacity="0.24" />
                            <stop offset="1" stop-color="#e1e1e1" stop-opacity="0.16" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>
        <div class="navigation">
            <ul class="listWrap">
                <li class="list">
                    <div class="white-circle"></div>
                    <a href="{{ route('member.dashboard') }}">
                        <i class="icon">
                            <img style="width: 30%" src="{{ asset('asset/home.svg') }}" alt="home-footer">
                        </i>
                        <span class="text"></span>
                    </a>
                </li>
                <li class="list">
                    <div class="white-circle"></div>
                    <a href="{{ route('presence-member.index') }}">
                        <i class="icon">
                            <img style="width: 30%" src="{{ asset('asset/presensi.svg') }}" alt="search-footer">
                        </i>
                        <span class="text"></span>
                    </a>
                </li>
                <li class="list">
                    <div class="white-circle"></div>
                    <a href="{{ route('report-transaction-member.index') }}">
                        <i class="icon">
                            <img style="width: 38%" src="{{ asset('asset/transaksi.svg') }}" alt="WishList">
                        </i>
                        <span class="text"></span>
                    </a>
                </li>
                <li class="list">
                    <div class="white-circle"></div>
                    <a href="{{ route('profile-member.index') }}">
                        <i class="icon">
                            <img style="width: 30%" src="{{ asset('asset/profile.svg') }}" alt="profile-footer">
                        </i>
                        <span class="text"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Modal QR -->
    <div id="modalQr" class="modal">
        <div class="modal-content qr-content" style="background-color: white">
            <span style="color: black" class="close-btn" onclick="closeModal('modalQr')">&times;</span>
            <div class="qr-wrapper">
                <img src="{{ asset('asset/qrr.svg') }}" alt="QR Code" class="qr-image">
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "flex";
        }

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Klik luar modal untuk menutup
        window.onclick = function(event) {
            document.querySelectorAll('.modal').forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        };
    </script>

    <script>
        window.addEventListener("load", function() {
            const preloader = document.getElementById("preloader");
            preloader.style.display = "none";
        });
    </script>

    @yield('scripts')

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('common/dashboard/assets/javascript/jquery.js') }}"></script>
    <script src="{{ asset('common/dashboard/assets/javascript/slick.min.js') }}"></script>
    <script src="{{ asset('common/dashboard/assets/javascript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('common/dashboard/assets/javascript/script.js') }}"></script>

    {{-- CHART --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>
