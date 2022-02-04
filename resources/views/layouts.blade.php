<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VideoConverter</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>

<body class="antialiased">
    @yield('content')
</body>

</html>
