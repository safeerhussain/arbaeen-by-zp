<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/favicon.png">
    <title>@yield('title', 'Admin — Arbaeen 2026')</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body style="background:#f4f4f6;min-height:100vh">

<nav class="navbar navbar-expand-lg" style="background:var(--zp-maroon-dark);padding:0.65rem 0;box-shadow:0 2px 12px rgba(0,0,0,0.25)">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-gold fw-700" href="{{ route('admin.dashboard') }}" style="font-size:1rem;letter-spacing:-0.01em">
            Arbaeen 2026 <span style="opacity:0.45;font-weight:300;font-size:0.8rem">/ Admin</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="text-white text-decoration-none" style="font-size:0.8rem;opacity:0.6" target="_blank">
                View Site ↗
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light" style="font-size:0.78rem;padding:0.3rem 0.8rem">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 py-4">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" style="font-size:0.875rem" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" style="font-size:0.875rem" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @yield('content')
</div>

@stack('scripts')
</body>
</html>
