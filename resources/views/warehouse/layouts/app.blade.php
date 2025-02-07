<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Laravel')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/cc622e456c.js" crossorigin="anonymous"></script>

    <x-script />

</head>

<body class="mx-auto">
    <div id="wrapper">

        @php
        session()->forget('error');
        session()->forget('success');
        @endphp

        @yield('content')
    </div>
</body>

</html>
