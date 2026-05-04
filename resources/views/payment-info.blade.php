@extends('layouts.app')

@section('title', 'Payment Information — Arbaeen 2026')
@section('meta_description', 'Payment schedule, methods, and bank details for Arbaeen 2026 registration. Payments collected at Bhojani Brothers office, Karachi.')

@section('content')

{{-- Page Header --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Payment Information</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem">
            How and when to pay &mdash; all deposits, instalments, and bank details
        </p>
    </div>
</section>

{{-- Intro --}}
<section class="section-py-sm" style="background: var(--zp-cream-warm); border-bottom: 1px solid rgba(201,169,97,0.25);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p style="font-size: 0.925rem; color: var(--zp-ink-soft); line-height: 1.8">
                    Payments are collected in four stages — a deposit at registration secures your seat,
                    with subsequent payments triggered by booking milestones. All payments are made
                    at <strong class="text-ink">Bhojani Brothers Travel &amp; Tour, Karachi</strong> via
                    bank transfer or cash. No online payment gateway is available this season.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Payment Stages --}}
<section class="section-py" style="background: #fff;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Four Stages</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Payment Schedule</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">

                @foreach($paymentSchedule as $stage)
                <div class="d-flex gap-4 mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}"
                     style="border-color: rgba(201,169,97,0.2) !important">

                    {{-- Stage number --}}
                    <div class="flex-shrink-0 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center fw-700 text-white"
                             style="width:40px;height:40px;border-radius:50%;background:var(--zp-maroon);font-size:0.85rem;flex-shrink:0">
                            {{ $stage['stage'] }}
                        </div>
                        @if(!$loop->last)
                        <div style="width:2px;flex:1;background:rgba(201,169,97,0.2);margin-top:0.5rem;min-height:24px"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="pb-2">
                        <div class="d-flex flex-wrap align-items-baseline gap-3 mb-2">
                            <h3 class="fw-700 mb-0 text-ink" style="font-size: 1rem">{{ $stage['label'] }}</h3>
                            <span class="fw-700 text-maroon ls-tight" style="font-size: 1.4rem">
                                @if($stage['amount'])
                                    ${{ $stage['amount'] }}
                                @else
                                    Remaining Balance
                                @endif
                            </span>
                        </div>
                        <p class="mb-0 text-muted" style="font-size: 0.875rem; line-height: 1.75">
                            {{ $stage['note'] }}
                        </p>
                        @if($loop->last)
                        <p class="mt-2 mb-0" style="font-size: 0.825rem; color: var(--zp-ink-soft); line-height: 1.65">
                            The remaining balance (total package price minus the three prior deposits)
                            is payable either in <strong>USD cash on arrival in Iraq</strong>, or
                            in <strong>PKR at the Bhojani Brothers office</strong> before your departure date.
                            Contact us for the current PKR exchange rate.
                        </p>
                        @endif
                    </div>

                </div>
                @endforeach

                {{-- Total note --}}
                <div class="p-4 rounded-3 mt-2"
                     style="background: rgba(92,15,30,0.04); border: 1px solid rgba(92,15,30,0.12)">
                    <p class="fw-600 mb-1" style="font-size: 0.875rem; color: var(--zp-maroon)">
                        Advance Deposits: $900 per person
                    </p>
                    <p class="mb-0 text-muted" style="font-size: 0.825rem; line-height: 1.65">
                        The first three stages total $900 per person (paid in Karachi before departure).
                        For a Karachi adult package ($1,440), the remaining $540 is settled on arrival in Iraq or at the office.
                        Amounts differ for Lahore/Islamabad departures — contact us for your specific balance.
                    </p>
                </div>

            </div>
        </div>

    </div>
</section>

{{-- Payment Methods --}}
<section class="section-py bg-cream">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">How to Pay</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Payment Methods</h2>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">🏦</div>
                    <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">Bank Transfer</h4>
                    <p class="text-muted mb-3" style="font-size: 0.825rem; line-height: 1.7">
                        Transfer to the Bhojani Brothers bank account and bring a copy of your receipt
                        to the office. Account details are shared upon registration confirmation.
                    </p>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--zp-orange); font-weight: 600">
                        Always include your full name and booking reference in the transfer description.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">💵</div>
                    <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">Cash at Office</h4>
                    <p class="text-muted mb-3" style="font-size: 0.825rem; line-height: 1.7">
                        Visit the Bhojani Brothers office directly and pay in cash. PKR equivalent
                        accepted for deposits at prevailing USD rate on the day of payment.
                    </p>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--zp-orange); font-weight: 600">
                        Call ahead to arrange your visit and confirm office hours.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">🇮🇶</div>
                    <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">Balance in Iraq (USD Cash)</h4>
                    <p class="text-muted mb-3" style="font-size: 0.825rem; line-height: 1.7">
                        The Stage 4 remaining balance may be paid in USD cash on arrival in Iraq
                        to the group leader. Bring exact or close-to-exact amount to avoid
                        exchange complications.
                    </p>
                    <p class="mb-0" style="font-size: 0.78rem; color: var(--zp-ink-soft); font-weight: 500">
                        Option also available: settle remaining balance in PKR at the Karachi office before departure.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Office & Contact --}}
<section class="section-py" style="background: #fff;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Office</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Where to Pay</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="row g-4">

                    <div class="col-md-6">
                        <div class="info-card h-100">
                            <div class="info-card-icon">📍</div>
                            <h4 class="fw-700 mb-2" style="font-size: 0.95rem; color: var(--zp-ink)">
                                Bhojani Brothers Travel &amp; Tour
                            </h4>
                            <address class="fst-normal mb-3 text-muted" style="font-size: 0.875rem; line-height: 1.8">
                                {{ $office['address'] }}
                            </address>
                            @foreach($office['landlines'] as $line)
                            <p class="mb-1" style="font-size: 0.875rem">
                                <a href="tel:{{ str_replace(' ', '', $line) }}" class="text-maroon fw-500"
                                   style="text-decoration: none">{{ $line }}</a>
                            </p>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card h-100">
                            <div class="info-card-icon">📞</div>
                            <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">
                                Registration Contacts
                            </h4>
                            @foreach($contacts as $contact)
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-3
                                        {{ !$loop->last ? 'border-bottom' : '' }}"
                                 style="border-color: rgba(0,0,0,0.06) !important">
                                <div>
                                    <p class="fw-600 mb-0" style="font-size: 0.875rem; color: var(--zp-ink)">
                                        {{ $contact['name'] }}
                                    </p>
                                    <p class="mb-0" style="font-size: 0.75rem; color: var(--zp-ink-soft)">
                                        {{ $contact['role'] }}
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                                       class="btn btn-outline-primary btn-sm" style="font-size: 0.75rem; padding: 0.3rem 0.7rem">
                                        Call
                                    </a>
                                    <a href="https://wa.me/{{ $contact['wa'] }}"
                                       class="btn btn-sm text-white" target="_blank" rel="noopener"
                                       style="font-size:0.75rem;padding:0.3rem 0.7rem;background:#25D366;border-color:#25D366">
                                        WA
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-py-sm bg-cream-warm text-center">
    <div class="container">
        <p class="text-muted mb-3" style="font-size: 0.875rem">
            Ready to register? Begin your application and pay Stage 1 ($150) to confirm your seat.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-orange px-5">Begin Registration &rarr;</a>
            <a href="{{ route('terms') }}" class="btn btn-outline-primary px-4">Terms &amp; Cancellation</a>
        </div>
    </div>
</section>

@endsection
