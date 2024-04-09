<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strategienavigator</title>
    <!-- Lokales Bootstrap CSS einbinden -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Lokales Fontawesome -->
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <!--  CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Lokales Chart JavaScript einbinden -->
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>
<body>
<header>
    <!-- Navigation -->
    @include('layouts.partials.navbar')
    <!-- //Navigation// -->
</header>

<main>
    @yield('content')
</main>

<footer>
    <!-- Footer -->

    <!-- //Footer// -->
</footer>

<!-- Lokales Bootstrap JavaScript einbinden -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>

