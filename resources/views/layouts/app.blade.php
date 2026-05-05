<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="/favicon.png">
    <title>@yield('title', 'Arbaeen 2026 — Pakistan to Iraq | Ziarat Planner')</title>
    <meta name="description" content="@yield('meta_description', 'Register for Arbaeen 2026 pilgrimage from Pakistan to Iraq. Two groups — AR01 (23 July) and AR02 (31 July). All shrines, full package from $1,440. Bhojani Brothers × Ziarat Planner.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-cream">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.whatsapp-float')

    @stack('scripts')
    @stack('body-end')

</body>
</html>
