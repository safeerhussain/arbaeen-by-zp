<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="/favicon.png">
    <title>@yield('title', 'Arbaeen 2026 — Pakistan to Iraq | Ziarat Planner')</title>
    <meta name="description" content="@yield('meta_description', 'Register for Arbaeen 2026 pilgrimage from Pakistan to Iraq. Two groups — AR01 (23 July) and AR02 (31 July). All inclusive package from $1,440. Ziarat Planner × Bhojani Brothers .')">

    {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="Arbaeen 2026 — Ziarat Planner">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:title"       content="@yield('og_title', 'Arbaeen 2026 — Pakistan to Iraq | Ziarat Planner')">
    <meta property="og:description" content="@yield('og_description', 'Register for Arbaeen 2026 pilgrimage from Pakistan to Iraq. Two groups — AR01 (23 July) and AR02 (31 July). All inclusive package from $1,440.')">
    <meta property="og:image"       content="@yield('og_image', url('/images/arbaeen-featured-image_zpxbb.png') . '?v=2')">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"   content="Arbaeen 2026 pilgrimage — Ziarat Planner">

    {{-- Twitter / X card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('og_title', 'Arbaeen 2026 — Pakistan to Iraq | Ziarat Planner')">
    <meta name="twitter:description" content="@yield('og_description', 'Register for Arbaeen 2026 pilgrimage from Pakistan to Iraq. Two groups — AR01 (23 July) and AR02 (31 July). All inclusive package from $1,440.')">
    <meta name="twitter:image"       content="@yield('og_image', url('/images/arbaeen-featured-image_zpxbb.png') . '?v=2')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.scss', 'resources/js/app.js'])

    @stack('styles')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-71XM08RHT7"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-71XM08RHT7');
    </script>
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
