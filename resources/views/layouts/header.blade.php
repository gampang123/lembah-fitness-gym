<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<!-- Navbar -->
<nav class="d-flex justify-content-between align-items-center pl-10 pr-10">
    <!-- Logo -->
    <div>
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="img-fluid" style="width: 100px; height: auto;">
    </div>

    <!-- Menu -->
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link text-dark hover:text-red-600" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-dark" href="#">Contact</a>
        </li>
    </ul>
</nav>

<main>
