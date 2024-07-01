<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Lokales Bootstrap CSS einbinden -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Lokales Fontawesome -->
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- custom CSS -->
    <!-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> -->
    <!--  CDN Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Lokales Chart JavaScript einbinden -->
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>
<body>
<div id="app" class="d-flex flex-column min-vh-100">
    @include('layouts.navigation')

    <header>
        <!-- Navigation -->
            @yield('header')
        <!-- //Navigation// -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Footer -->
        <!-- //Footer// -->
    </footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Lokales Bootstrap JavaScript einbinden -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('js/custom.js')}}"></script>

    <script>
        // JavaScript to handle dropdown functionality
        document.querySelector('.dropdown-btn').addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('hidden');
        });
    </script>
</body>
</html>
