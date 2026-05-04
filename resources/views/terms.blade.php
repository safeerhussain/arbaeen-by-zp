@extends('layouts.app')

@section('title', 'Terms & Cancellation Policy — Arbaeen 2026')
@section('meta_description', 'Booking terms, cancellation policy, and conditions for Arbaeen 2026 registration. Bhojani Brothers Travel & Tour × Ziarat Planner.')

@section('content')

{{-- Page Header --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Terms &amp; Cancellation Policy</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem">
            Please read before completing your registration
        </p>
    </div>
</section>

{{-- Content --}}
<section class="section-py" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Last updated --}}
                <p class="mb-5 text-muted" style="font-size: 0.8rem">
                    These terms apply to all Arbaeen 2026 bookings managed by
                    <strong>Bhojani Brothers Travel &amp; Tour</strong> in partnership with
                    <strong>Ziarat Planner</strong>.
                    By submitting a registration form and paying the Stage 1 deposit, you agree to these terms.
                </p>

                {{-- Section: Booking --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        1. Booking &amp; Registration
                    </h2>
                    <ul class="list-unstyled" style="font-size: 0.9rem; line-height: 1.9; color: var(--zp-ink-soft)">
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Seats are reserved only upon receipt of the Stage 1 deposit ($150 per person).</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>All travellers in a booking must be listed at the time of registration. Addition of new travellers is subject to availability.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Each traveller must hold a valid passport. Passports must be valid for at least 6 months beyond the return date of the selected group.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>The lead registrant (head of family or group) is responsible for ensuring all submitted information is accurate. Errors in passport data that cause visa or ticketing issues are the responsibility of the registrant.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Maximum 15 travellers (lead + 14 additional) per registration. Larger groups must register separately and are subject to seat availability.</span>
                        </li>
                    </ul>
                </div>

                {{-- Section: Cancellation --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        2. Cancellation Policy
                    </h2>
                    <p class="text-muted mb-4" style="font-size: 0.875rem; line-height: 1.75">
                        Cancellation charges are tied to the payment stage reached at the time of cancellation.
                        All cancellation requests must be submitted in writing (WhatsApp or in person at the office).
                    </p>

                    <div class="table-responsive mb-4">
                        <table class="table align-middle" style="font-size:0.875rem">
                            <thead>
                                <tr style="font-size:0.75rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-ink-soft)">
                                    <th class="py-3 fw-700">When You Cancel</th>
                                    <th class="py-3 fw-700">Amount Forfeited</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-3" style="line-height:1.5">Before visa processing begins (Stage 1 deposit paid)</td>
                                    <td class="py-3 fw-700 text-maroon">$0 &mdash; Full refund</td>
                                </tr>
                                <tr>
                                    <td class="py-3" style="line-height:1.5">After visa processing begins (Stage 1)</td>
                                    <td class="py-3 fw-700 text-maroon">$150 non-refundable</td>
                                </tr>
                                <tr>
                                    <td class="py-3" style="line-height:1.5">After ticket confirmation (Stage 2 paid)</td>
                                    <td class="py-3 fw-700 text-maroon">$150 + airline cancellation charges on Stage 2</td>
                                </tr>
                                <tr>
                                    <td class="py-3" style="line-height:1.5">After ticket issuance (Stage 3 paid)</td>
                                    <td class="py-3 fw-700 text-maroon">Airline charges + $100/person (service &amp; Iraq ground)</td>
                                </tr>
                                <tr>
                                    <td class="py-3" style="line-height:1.5">After departure</td>
                                    <td class="py-3 fw-700 text-maroon">No refund</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 rounded-3"
                         style="background:rgba(232,101,31,0.06);border:1px solid rgba(232,101,31,0.25)">
                        <p class="fw-600 mb-1" style="font-size:0.875rem;color:var(--zp-ink)">Name Change Policy</p>
                        <p class="mb-0 text-muted" style="font-size:0.825rem;line-height:1.65">
                            Name changes after ticket issuance are subject to airline policy and may incur
                            additional fees. Name changes are not guaranteed and depend on the airline's terms
                            at the time of the request. Contact us as early as possible if a name change is needed.
                        </p>
                    </div>
                </div>

                {{-- Section: Passport & Visa --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        3. Passport &amp; Visa Requirements
                    </h2>
                    <ul class="list-unstyled" style="font-size: 0.9rem; line-height: 1.9; color: var(--zp-ink-soft)">
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span><strong class="text-ink">AR01</strong> passengers: passport must be valid until at least <strong class="text-ink">6 February 2027</strong>.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span><strong class="text-ink">AR02</strong> passengers: passport must be valid until at least <strong class="text-ink">14 February 2027</strong>.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Iraq eVisa is arranged by the organiser. Any visa rejection due to incorrect or incomplete information submitted by the traveller is not the responsibility of Bhojani Brothers or Ziarat Planner.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Travellers are responsible for holding valid Pakistani travel documents. Expired or cancelled passports discovered after registration may result in forfeiture of deposits.</span>
                        </li>
                    </ul>
                </div>

                {{-- Section: Health --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        4. Health &amp; Conduct
                    </h2>
                    <ul class="list-unstyled" style="font-size: 0.9rem; line-height: 1.9; color: var(--zp-ink-soft)">
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>Travellers are responsible for their own health, fitness, and any necessary vaccinations or medical clearances required for international travel to Iraq.</span>
                        </li>
                        <li class="mb-2 d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>The Arbaeen Walk (Najaf to Karbala) is physically demanding and optional. Non-walkers are not penalised or subject to additional charges.</span>
                        </li>
                        <li class="d-flex gap-2">
                            <span class="text-gold fw-700" style="font-size:0.65rem;margin-top:0.45rem;flex-shrink:0">✦</span>
                            <span>All travellers are expected to conduct themselves in a manner befitting the sacred nature of the journey and in accordance with Iraqi law and the group's code of conduct.</span>
                        </li>
                    </ul>
                </div>

                {{-- Section: Force Majeure --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        5. Force Majeure &amp; Itinerary Changes
                    </h2>
                    <p style="font-size: 0.9rem; line-height: 1.9; color: var(--zp-ink-soft)">
                        Bhojani Brothers Travel &amp; Tour and Ziarat Planner reserve the right to alter or
                        cancel any part of the itinerary — including hotel assignments, transport routes,
                        or departure cities — due to circumstances beyond our control, including but not
                        limited to government travel advisories, airline schedule changes, natural disasters,
                        civil unrest, or Iraqi border/security conditions. In such cases, reasonable
                        alternative arrangements will be made. Refunds for force majeure events are subject
                        to what is recoverable from airlines, hotels, and visa authorities.
                    </p>
                </div>

                {{-- Section: Governing Law --}}
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-3" style="font-size: 1.15rem; letter-spacing: -0.01em">
                        6. Governing Terms
                    </h2>
                    <p style="font-size: 0.9rem; line-height: 1.9; color: var(--zp-ink-soft)">
                        These terms are governed by the laws of Pakistan. Any dispute arising from this
                        booking shall be resolved amicably. By completing registration and paying the
                        Stage 1 deposit, the lead registrant confirms that they have read, understood,
                        and agreed to these terms on behalf of all travellers in their booking.
                    </p>
                </div>

                {{-- Questions --}}
                <div class="p-4 p-md-5 rounded-4 text-center"
                     style="background: var(--zp-cream-warm); border: 1px solid rgba(201,169,97,0.3)">
                    <p class="fw-600 mb-2" style="font-size: 0.95rem; color: var(--zp-ink)">Questions about these terms?</p>
                    <p class="text-muted mb-4" style="font-size: 0.875rem">
                        Contact us before registering and we will clarify anything.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary px-4">Contact Us</a>
                        <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode($whatsappMessage) }}"
                           class="btn btn-maroon px-4" target="_blank" rel="noopener">
                            Ask on WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
