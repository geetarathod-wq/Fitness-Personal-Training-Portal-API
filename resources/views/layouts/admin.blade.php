<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('materialm-free-bootstrap-v2/src/assets/css/styles.css') }}">
</head>

<body>

    @include('admin.partials.sidebar')

    <div class="body-wrapper">

        @include('admin.partials.header')

        <div class="container-fluid">
            @yield('content')
        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('materialm-free-bootstrap-v2/src/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('materialm-free-bootstrap-v2/src/assets/js/app.min.js') }}"></script>

</body>

</html>