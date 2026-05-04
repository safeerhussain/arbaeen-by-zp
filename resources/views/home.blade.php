@extends('layouts.app')

@section('title', 'Arbaeen Ziyarat From Pakistan 2026 » Ziarat Planner × Bhojani Brothers')
@section('meta_description', 'Register for Arbaeen 2026 pilgrimage from Pakistan to Iraq. Two groups — AR01 (23 July) and AR02 (31 July). All inclusive packages from $1,440. Bhojani Brothers × Ziarat Planner.')

@section('content')

{{-- Hero --}}
<section class="hero-section section-py-lg"
         style="background-image: url('{{ asset('images/arbaeen-header.jpg') }}'); min-height: 88vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-xl-7">

                <div class="hero-eyebrow">Arbaeen 2026 · Pakistan to Iraq</div>

                <h1 class="display-2 fw-300 text-white mb-4 ls-tight" style="line-height: 1.05">
                    Arbaeen Ziyarat<br>
                    <span class="text-gold">from Pakistan</span>
                </h1>

                <p class="text-white mb-5" style="font-size: 1.05rem; opacity: 0.8; line-height: 1.75; font-weight: 400">
                    15-day spiritual journey from Pakistan to Iraq &mdash; all inclusive packages,<br class="d-none d-md-block">
                    Arbaeen Walk, Najaf, Karbala, Kadhimiya stays. Two exclusive groups available
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-orange btn-lg px-5 py-3">
                        Begin Registration &rarr;
                    </a>
                    <a href="#packages" class="btn btn-outline-light btn-lg px-5 py-3">
                        View Packages
                    </a>
                </div>

                <p class="mt-4" style="font-size: 0.75rem; opacity: 0.45; letter-spacing: 0.08em; text-transform: uppercase">
                    Max 135 zaireen per group &nbsp;&middot;&nbsp; Families welcome &nbsp;&middot;&nbsp; Limited seats
                </p>

            </div>
        </div>
    </div>
</section>

{{-- Live counter strip --}}
<div class="counter-strip" id="seat-counter">
    <div class="container">
        <div class="row justify-content-center text-center text-md-start">
            <div class="col-auto">
                <span class="counter-label">AR01</span>
                <span id="counter-ar01">Checking availability…</span>
            </div>
            <div class="col-auto d-none d-md-block" style="opacity:0.25">&nbsp;&nbsp;|&nbsp;&nbsp;</div>
            <div class="col-auto">
                <span class="counter-label">AR02</span>
                <span id="counter-ar02">Checking availability…</span>
            </div>
        </div>
    </div>
</div>

{{-- Package cards --}}
<section class="section-py bg-cream" id="packages">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Two Groups Available</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Choose Your Journey</h2>
            <p class="text-muted mt-2" style="max-width: 480px; margin: 0.75rem auto 0; font-size: 0.9rem">
                Both groups cover all major shrines. Choose based on your preferred travel dates.
            </p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- AR01 --}}
            <div class="col-lg-5 col-md-6">
                <div class="package-card h-100 d-flex flex-column">
                    <div class="package-card-header">
                        <div class="package-badge">Group AR01</div>
                        <h3 class="text-white fw-700 mb-1" style="font-size: 1.3rem; letter-spacing: -0.01em">
                            Arbaeen in Karbala
                        </h3>
                        <p class="mb-0" style="font-size: 0.8rem; color: rgba(201,169,97,0.7)">
                            8 Safar – 22 Safar 1448 AH
                        </p>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <p class="mb-3" style="font-size: 0.85rem; color: var(--zp-ink-soft)">
                            <strong class="text-ink">23 July – 6 August 2026</strong>
                            &nbsp;&middot;&nbsp; 15 Days &middot; 14 Nights
                        </p>
                        <ul class="list-unstyled mb-4" style="font-size: 0.875rem">
                            @foreach([
                                'Arbaeen Walk — Najaf to Karbala',
                                '6 nights Karbala · 2 Kadhimiya · 6 Najaf',
                                'All meals, AC transport, group Maulana',
                                'Iraq eVisa + airfare (full package)',
                            ] as $feat)
                            <li class="d-flex gap-2 mb-2">
                                <span class="text-gold fw-700" style="font-size:0.7rem; margin-top:0.25rem">✦</span>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mb-4">
                            <p class="mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--zp-ink-soft)">
                                From
                            </p>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="package-price">$1,440</span>
                                <span style="font-size:0.8rem; color:var(--zp-ink-soft)">/&nbsp;person</span>
                            </div>
                        </div>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('ar01') }}" class="btn btn-outline-primary flex-grow-1">
                                View Details
                            </a>
                            <a href="{{ route('register') }}?group=AR01" class="btn btn-orange flex-grow-1">
                                Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AR02 --}}
            <div class="col-lg-5 col-md-6">
                <div class="package-card h-100 d-flex flex-column">
                    <div class="package-card-header">
                        <div class="package-badge">Group AR02</div>
                        <h3 class="text-white fw-700 mb-1" style="font-size: 1.3rem; letter-spacing: -0.01em">
                            Arbaeen + 28 Safar
                        </h3>
                        <p class="mb-0" style="font-size: 0.8rem; color: rgba(201,169,97,0.7)">
                            16 Safar – 30 Safar 1448 AH
                        </p>
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <p class="mb-3" style="font-size: 0.85rem; color: var(--zp-ink-soft)">
                            <strong class="text-ink">31 July – 14 August 2026</strong>
                            &nbsp;&middot;&nbsp; 15 Days &middot; 14 Nights
                        </p>
                        <ul class="list-unstyled mb-4" style="font-size: 0.875rem">
                            @foreach([
                                'Arbaeen Walk — Najaf to Karbala',
                                'Includes 28 & 29 Safar in Karbala',
                                'All meals, AC transport, group Maulana',
                                'Iraq eVisa + airfare (full package)',
                            ] as $feat)
                            <li class="d-flex gap-2 mb-2">
                                <span class="text-gold fw-700" style="font-size:0.7rem; margin-top:0.25rem">✦</span>
                                <span>{{ $feat }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mb-4">
                            <p class="mb-1" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--zp-ink-soft)">
                                From
                            </p>
                            <div class="d-flex align-items-baseline gap-2">
                                <span class="package-price">$1,440</span>
                                <span style="font-size:0.8rem; color:var(--zp-ink-soft)">/&nbsp;person</span>
                            </div>
                        </div>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('ar02') }}" class="btn btn-outline-primary flex-grow-1">
                                View Details
                            </a>
                            <a href="{{ route('register') }}?group=AR02" class="btn btn-orange flex-grow-1">
                                Register
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Highlights strip --}}
<section class="section-py-sm bg-maroon-dark">
    <div class="container">
        <div class="row g-2 justify-content-center">
            @foreach([
                ['🍽', 'All Meals',       'Breakfast, lunch & dinner'],
                ['🚌', 'AC Transport',    'Airport to airport, all transfers'],
                ['🕌', 'Group Maulana',   'Accompanying throughout'],
                ['📋', 'Iraq eVisa',      'Full processing included'],
                ['👨‍👩‍👧‍👦', 'Families Welcome', 'Child & infant pricing available'],
            ] as $item)
            <div class="col-6 col-md-4 col-lg-2">
                <div class="highlight-item text-white">
                    <div class="highlight-icon">{{ $item[0] }}</div>
                    <div class="highlight-title">{{ $item[1] }}</div>
                    <div class="highlight-desc">{{ $item[2] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Three Sacred Cities --}}
<section class="section-py" style="background: #fff">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Three Sacred Cities</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Your Spiritual Itinerary</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach([
                ['Karbala',    '6 Nights', '🕌', 'Haram Imam Hussain (a.s.) & Hazrat Abbas (a.s.)', 'Quality hotel within walking distance from Haram'],
                ['Kadhimiya',  '2 Nights', '🕌', 'Haram Jawadain (a.s.)', 'Imam Musa Kazim (a.s.) & Imam Jawad (a.s.)'],
                ['Najaf',      '6 Nights', '🕌', 'Haram Imam Ali (a.s.)', 'Arbaeen Walk base — Najaf to Karbala'],
            ] as $city)
            <div class="col-md-4">
                <div class="city-card h-100">
                    <div class="city-nights">{{ $city[1] }}</div>
                    <h3 class="fw-700 text-maroon mb-1" style="font-size: 1.4rem; letter-spacing: -0.01em">
                        {{ $city[0] }}
                    </h3>
                    <p class="mb-1 fw-500" style="font-size: 0.875rem; color: var(--zp-ink)">{{ $city[3] }}</p>
                    <p class="mb-0" style="font-size: 0.8rem; color: var(--zp-ink-soft)">{{ $city[4] }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Social proof feed --}}
<section class="section-py-sm bg-cream" id="social-feed" style="display:none">
    <div class="container">
        <p class="text-center mb-3" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; opacity: 0.5">
            Recent Registrations
        </p>
        <div id="feed-items" class="d-flex gap-2 flex-wrap justify-content-center"></div>
    </div>
</section>

{{-- FAQ --}}
<section class="section-py bg-cream-warm">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7 text-center mb-5">
                <div class="section-tag mx-auto d-inline-flex">Common Questions</div>
                <h2 class="display-6 fw-600 ls-tight mt-1">Frequently Asked</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="accordion faq-accordion" id="faqAccordion">
                    @foreach([
                        ['Is the Arbaeen Walk compulsory?', 'No. The walk is optional. Non-walkers remain at the Najaf hotel with luggage. Special group transport is arranged for non-walkers to perform ziyarat-e-Arbaeen in Karbala on 20 Safar and return the same day.'],
                        ['Can families with young children join?', 'Yes. We accommodate families with infants, children, and elderly. Wheelchair arrangements are available on request. Children under 2 (infants) travel at a significantly reduced rate.'],
                        ['What does the package price include?', 'International return airfare, Iraq eVisa, 14 nights hotel accommodation, all meals (breakfast, lunch, dinner), group AC bus transport airport-to-airport, luggage handling, and a group leader, Maulana, and Noha Khuwan.'],
                        ['How do I pay? Is online payment available?', 'Payments are collected at Bhojani Brothers Karachi office via bank transfer or cash. Online payment gateway is not available this season. Full payment schedule details are on the Payment Info page.'],
                        ['What is the passport validity requirement?', 'Iraq requires passports valid for 6 months beyond your return date. AR01 passengers must have passports valid until 6 February 2027. AR02 passengers until 14 February 2027. The registration form checks this automatically.'],
                    ] as $i => $faq)
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $i }}">
                                {{ $faq[0] }}
                            </button>
                        </h3>
                        <div id="faq{{ $i }}"
                             class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}"
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">{{ $faq[1] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('questions') }}" class="btn btn-outline-primary px-4">
                        View All FAQs &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Final CTA --}}
<section class="section-py bg-maroon text-white text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <p class="mb-3" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--zp-gold)">
                    ✦ &nbsp; Answer the Call &nbsp; ✦
                </p>
                <h2 class="display-6 fw-600 ls-tight text-white mb-3">
                    Begin Your Journey to Karbala
                </h2>
                <p class="mb-5" style="opacity: 0.65; font-size: 0.9rem">
                    Maximum 135 zaireen per group. Seats are limited.
                </p>
                <a href="{{ route('register') }}" class="btn btn-orange btn-lg px-5 py-3">
                    Begin Registration &rarr;
                </a>
                <p class="mt-4" style="font-size: 0.8rem; opacity: 0.45">
                    Questions? Call or WhatsApp
                    <a href="tel:+923353151571" class="text-gold-soft" style="text-decoration:none">+92 335 3151571</a>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    var maxCap = 135;

    function renderCount(elementId, confirmed) {
        var el = document.getElementById(elementId);
        if (!el) { return; }
        if (confirmed <= 30) {
            el.textContent = 'Registration open — limited to 135 zaireen';
        } else if (confirmed <= 100) {
            el.textContent = (maxCap - confirmed) + ' of ' + maxCap + ' seats remaining';
        } else if (confirmed < maxCap) {
            el.textContent = (maxCap - confirmed) + ' seats left — filling fast';
        } else {
            el.textContent = 'Group full — join waitlist';
        }
    }

    function loadCounts() {
        fetch('/api/counts')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                renderCount('counter-ar01', data.ar01_confirmed || 0);
                renderCount('counter-ar02', data.ar02_confirmed || 0);
            })
            .catch(function () {
                var msg = 'Contact us for availability';
                var el1 = document.getElementById('counter-ar01');
                var el2 = document.getElementById('counter-ar02');
                if (el1) { el1.textContent = msg; }
                if (el2) { el2.textContent = msg; }
            });
    }

    loadCounts();
    setInterval(loadCounts, 60000);

    // Social proof feed (Module 7)
    function loadFeed() {
        fetch('/api/feed')
            .then(function (r) { return r.json(); })
            .then(function (items) {
                if (!items.length) { return; }
                var container = document.getElementById('feed-items');
                var feed = document.getElementById('social-feed');
                if (!container || !feed) { return; }
                container.innerHTML = '';
                items.forEach(function (item) {
                    var pill = document.createElement('span');
                    pill.style.cssText = 'display:inline-flex;align-items:center;gap:6px;background:#fff;border:1px solid rgba(0,0,0,0.08);border-radius:2rem;padding:0.3rem 0.85rem;font-size:0.78rem;color:var(--zp-ink)';
                    pill.innerHTML = '<span style="font-weight:600">' + item.name + '</span>'
                        + '<span style="opacity:0.5;font-size:0.7rem">·</span>'
                        + '<span style="opacity:0.65">' + item.city + '</span>'
                        + '<span style="font-size:0.65rem;font-weight:700;letter-spacing:0.06em;background:rgba(92,15,30,0.1);color:var(--zp-maroon);border-radius:0.25rem;padding:0.1em 0.45em">' + item.group + '</span>';
                    container.appendChild(pill);
                });
                feed.style.display = '';
            })
            .catch(function () {});
    }

    loadFeed();
}());
</script>
@endpush
