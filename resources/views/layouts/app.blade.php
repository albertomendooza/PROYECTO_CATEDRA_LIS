<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('template/css/shop-homepage.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
