<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strategienavigator</title>
    <!-- Lokales Bootstrap CSS einbinden -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Lokales Chart JavaScript einbinden -->
    <script src="{{ asset('js/chart.min.js') }}"></script>
</head>
<body>
    <header>
        <!-- Hier den Header definieren -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Hier den Footer definieren -->
    </footer>

    <!-- Lokales Bootstrap JavaScript einbinden -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

