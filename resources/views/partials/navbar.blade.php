<nav class="navbar navbar-expand-lg navbar-arbaeen sticky-top" data-bs-theme="dark">
    <div class="container">

        <a class="navbar-brand d-flex flex-column lh-1" href="{{ route('home') }}">
            <span>Arbaeen 2026 </span>
            <span class="navbar-brand-sub d-none d-sm-block">Ziarat Planner × Bhojani Brothers</span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain"
                aria-controls="navbarMain"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 py-2 py-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ar01') ? 'active' : '' }}"
                       href="{{ route('ar01') }}">AR01 &mdash; Karbala</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ar02') ? 'active' : '' }}"
                       href="{{ route('ar02') }}">AR02 &mdash; 28 Safar</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('status') ? 'active' : '' }}"
                       href="{{ route('status') }}">Check Status</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('questions') ? 'active' : '' }}"
                       href="{{ route('questions') }}">FAQs</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">Contact</a>
                </li>

                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-orange px-4" href="{{ route('register') }}">
                        Begin Registration
                    </a>
                </li>

            </ul>
        </div>

    </div>
</nav>
