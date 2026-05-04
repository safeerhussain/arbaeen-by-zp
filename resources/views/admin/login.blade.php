<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Arbaeen 2026</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body style="background:var(--zp-cream-warm);min-height:100vh;display:flex;align-items:center;justify-content:center">
<div style="width:100%;max-width:400px;padding:1.5rem">
    <div class="text-center mb-4">
        <p class="fw-700 text-maroon mb-0" style="font-size:1.15rem">Arbaeen 2026</p>
        <p class="text-muted" style="font-size:0.78rem">Admin Panel</p>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if($errors->any())
            <div class="alert alert-danger mb-3" style="font-size:0.825rem">
                {{ $errors->first() }}
            </div>
            @endif
            <form method="POST" action="{{ route('admin.login.post') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-600" style="font-size:0.85rem">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-600" style="font-size:0.85rem">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:0.85rem">Remember me</label>
                </div>
                <button type="submit" class="btn btn-maroon w-100 fw-600">Sign In</button>
            </form>
        </div>
    </div>
    <p class="text-center text-muted mt-3" style="font-size:0.75rem">
        Default: admin@arbaeen.local — change before going live.
    </p>
</div>
</body>
</html>
