{{-- Package Hero --}}
<section class="hero-section section-py" style="min-height: 52vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-xl-7">

                <div class="hero-eyebrow">Group {{ $group['code'] }} &middot; Arbaeen 2026</div>

                <h1 class="display-3 fw-300 text-white mb-3 ls-tight">
                    {{ $group['name'] }}
                </h1>

                <p class="mb-1" style="font-size: 0.85rem; color: rgba(201,169,97,0.7)">
                    {{ $group['islamic_dates'] }}
                </p>
                <p class="mb-5 fw-600 ls-tight" style="font-size: 1.15rem; color: var(--zp-gold)">
                    {{ $group['travel_dates'] }}
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="{{ route('register') }}?group={{ $group['code'] }}" class="btn btn-orange btn-lg px-5 py-3">
                        Begin Registration &rarr;
                    </a>
                    <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode($whatsappMessage) }}"
                       class="btn btn-outline-light btn-lg px-5 py-3" target="_blank" rel="noopener">
                        Ask on WhatsApp
                    </a>
                </div>

                <div class="mt-4">
                    <a href="/package-pdfs/{{ $group['code'] }}_Poster.pdf" download
                       class="d-inline-flex align-items-center gap-2"
                       style="color:rgba(201,169,97,0.8);font-size:0.82rem;font-weight:600;letter-spacing:0.04em;text-decoration:none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                        </svg>
                        Download Day-by-Day Itinerary PDF
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Stats strip --}}
<div style="background: var(--zp-cream-warm); border-bottom: 1px solid rgba(201,169,97,0.3);">
    <div class="container">
        <div class="row g-0 text-center py-4">
            @foreach([
                ['Departure',  \Carbon\Carbon::parse($group['departure'])->format('j M Y')],
                ['Return',     \Carbon\Carbon::parse($group['return_date'])->format('j M Y')],
                ['Duration',   '15 Days · 14 Nights'],
                ['Capacity',   $group['max_capacity'] . ' Zaireen Max'],
            ] as $stat)
            <div class="col-6 col-md-3 py-2 {{ !$loop->last ? 'border-end-md' : '' }}">
                <p class="mb-1" style="font-size:0.6rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--zp-orange)">
                    {{ $stat[0] }}
                </p>
                <p class="mb-0 fw-600" style="font-size:0.95rem;color:var(--zp-ink)">
                    {{ $stat[1] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</div>



{{-- Pricing --}}
<section class="section-py" style="background: #fff;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Package Pricing</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Rates &amp; Pricing</h2>
            <p class="text-muted mt-2" style="max-width:520px;margin:0.75rem auto 0;font-size:0.875rem">
                All prices in USD per person. Ground-only rate excludes international airfare & visa cost.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Desktop table (md+) --}}
                <div class="d-none d-md-block table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr style="font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-ink-soft)">
                                <th class="py-3 fw-700">Passenger Type</th>
                                <th class="text-center py-3 fw-700">Karachi</th>
                                <th class="text-center py-3 fw-700">Lahore</th>
                                <th class="text-center py-3 fw-700">Islamabad</th>
                                <th class="text-center py-3 fw-700">Ground Only</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:0.9rem">
                            @foreach([
                                ['Adult (12+ yrs)',              'adult'],
                                ['Child — with bed (2–11 yrs)',   'child_with_bed'],
                                ['Child — no bed (2–11 yrs)',     'child_without_bed'],
                                ['Infant (0–1 yr)',               'infant'],
                            ] as [$label, $key])
                            <tr>
                                <td class="fw-500 py-3">{{ $label }}</td>
                                @foreach(['karachi', 'lahore', 'islamabad', 'ground_only'] as $city)
                                <td class="text-center fw-700 py-3 text-maroon">
                                    @if($pricing[$city][$key] === 0)
                                        <span class="badge bg-secondary fw-500" style="font-size:0.72rem">Free</span>
                                    @else
                                        ${{ number_format($pricing[$city][$key]) }}
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards (< md) --}}
                <div class="d-md-none">
                    @foreach([
                        ['Adult (12+ yrs)',              'adult'],
                        ['Child — with bed (2–11 yrs)',   'child_with_bed'],
                        ['Child — no bed (2–11 yrs)',     'child_without_bed'],
                        ['Infant (0–1 yr)',               'infant'],
                    ] as [$label, $key])
                    <div class="rounded-3 mb-3 overflow-hidden" style="border:1px solid rgba(92,15,30,0.15)">
                        <div class="px-3 py-2 fw-600" style="font-size:0.85rem;background:rgba(92,15,30,0.05);color:var(--zp-ink);border-bottom:1px solid rgba(92,15,30,0.12)">
                            {{ $label }}
                        </div>
                        <div class="row g-0">
                            @foreach([
                                ['Karachi',      'karachi'],
                                ['Lahore',       'lahore'],
                                ['Islamabad',    'islamabad'],
                                ['Ground Only',  'ground_only'],
                            ] as [$cityLabel, $city])
                            <div class="col-6 px-3 py-2 {{ !$loop->last && $loop->index < 2 ? 'border-bottom' : '' }} {{ $loop->index % 2 === 0 ? 'border-end' : '' }}"
                                 style="border-color:rgba(92,15,30,0.1)!important">
                                <p class="mb-1" style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--zp-ink-soft)">
                                    {{ $cityLabel }}
                                </p>
                                <p class="mb-0 fw-700 text-maroon" style="font-size:0.95rem">
                                    @if($pricing[$city][$key] === 0)
                                        <span class="badge bg-secondary fw-500" style="font-size:0.72rem">Free</span>
                                    @else
                                        ${{ number_format($pricing[$city][$key]) }}
                                    @endif
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                @php $discount = config('arbaeen.campaign_discount'); @endphp
                <div class="d-flex gap-3 align-items-start mt-4 p-4 rounded-3"
                     style="background:rgba(201,169,97,0.1);border:1px solid rgba(201,169,97,0.35)">
                    <span class="text-gold fw-700" style="font-size:1rem;flex-shrink:0">✦</span>
                    <div>
                        <p class="mb-1 fw-600" style="font-size:0.875rem;color:var(--zp-ink)">
                            Discount: {{ $discount['label'] }}
                        </p>
                        <p class="mb-0" style="font-size:0.825rem;color:var(--zp-ink-soft);line-height:1.65">
                            Pilgrims who complete the 40-day Ziyarat-e-Ashura campaign receive
                            <strong>PKR {{ number_format($discount['amount']) }}</strong> off their remaining balance.
                            Campaign participation is registered separately.
                        </p>
                    </div>
                </div>

                <p class="mt-3 text-center text-muted" style="font-size:0.78rem">
                    Prices are per person and include all group taxes and surcharges.
                    Contact us to confirm current availability and pricing.
                </p>
                <ul class="list-unstyled mt-3 text-center" style="font-size:0.78rem;color:var(--zp-ink-soft);line-height:1.8">
                    <li>In view of current regional conditions, package prices and travel dates are subject to change at any time.</li>
                    <li>Any additional costs due to new regulations by the Pakistani government or any other authority will be charged separately.</li>
                    <li>All amounts are charged in PKR based on the exchange rate on the date of payment.</li>
                </ul>
            </div>
        </div>

    </div>
</section>

{{-- Itinerary Download Banner --}}
<div style="background: linear-gradient(90deg, var(--zp-maroon) 0%, #6b1020 100%); border-bottom: 1px solid rgba(201,169,97,0.25);">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <span style="font-size:1.5rem;line-height:1;flex-shrink:0">📄</span>
                <div>
                    <p class="mb-0 fw-700 text-white" style="font-size:0.95rem;letter-spacing:-0.01em">
                        Group {{ $group['code'] }} — Day-by-Day Itinerary
                    </p>
                    <p class="mb-0" style="font-size:0.78rem;color:rgba(255,255,255,0.6);margin-top:2px">
                        Full programme, city schedule &amp; key dates in one PDF
                    </p>
                </div>
            </div>
            <a href="/package-pdfs/{{ $group['code'] }}_Poster.pdf" download
               class="btn btn-lg flex-shrink-0 d-inline-flex align-items-center gap-2 fw-700"
               style="background:var(--zp-gold);color:var(--zp-ink);border:none;font-size:0.875rem;padding:0.65rem 1.75rem;border-radius:0.5rem;white-space:nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
                </svg>
                Download Itinerary PDF
            </a>
        </div>
    </div>
</div>

{{-- What's Included --}}
<section class="section-py bg-cream">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">What's Covered</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Everything Included</h2>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach([
                ['✈️', 'International Airfare',    'Return flights from Karachi, Lahore, or Islamabad to Iraq (Baghdad or Najaf).'],
                ['🛂', 'Iraq eVisa',               'Full visa processing and eVisa application included in the package price.'],
                ['🏨', 'Hotel Accommodation',      '14 nights in quality hotels — Karbala (6), Kadhimiya (2), Najaf (6) — all within walking distance from Haramin.'],
                ['🍽️', 'All Meals',               'Breakfast, lunch, and dinner throughout the entire 15-day trip. Except during the Walk'],
                ['🚌', 'AC Transport',             'All transfers included — airport pickups, city buses, and Arbaeen Walk transport arrangements.'],
                ['👳', 'Group Maulana',            'A religious scholar accompanies the group throughout for daily majalis and spiritual guidance.'],
                ['🎵', 'Noha Khuwan',              'Group Noha reciter present throughout the journey.'],
                ['🧳', 'Luggage Handling',         'Assistance with luggage at all hotels and during all transfers. Airport luggage assistance not included.'],
            ] as [$icon, $title, $desc])
            <div class="col-md-6 col-lg-3">
                <div class="info-card h-100">
                    <div class="info-card-icon">{{ $icon }}</div>
                    <h5 class="fw-600 mb-2" style="font-size:0.95rem;color:var(--zp-ink)">{{ $title }}</h5>
                    <p class="mb-0 text-muted" style="font-size:0.8rem;line-height:1.65">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Hotels --}}
<section class="section-py" style="background:#fff;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Accommodation</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Hotels &amp; Cities</h2>
        </div>

        <div class="row g-4 justify-content-center mb-4">
            @foreach($hotels as $hotel)
            <div class="col-md-4">
                <div class="city-card h-100">
                    <div class="city-nights">{{ $hotel['nights'] }} Nights</div>
                    <h3 class="fw-700 text-maroon mb-2" style="font-size:1.35rem;letter-spacing:-0.01em">
                        {{ $hotel['city'] }}
                    </h3>
                    <p class="mb-0 text-muted" style="font-size:0.875rem;line-height:1.65">
                        {{ $hotel['note'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="p-4 rounded-3" style="background:rgba(92,15,30,0.04);border:1px solid rgba(92,15,30,0.1)">
                    <p class="fw-600 mb-1" style="font-size:0.875rem;color:var(--zp-maroon)">
                        Arbaeen Walk &mdash; {{ $group['arbaeen_day'] }}
                    </p>
                    <p class="mb-0 text-muted" style="font-size:0.825rem;line-height:1.7">
                        The Arbaeen Walk is optional. Non-walkers remain at the Najaf hotel with their luggage
                        and are transported by group bus to Karbala to perform Ziyarat-e-Arbaeen on 20 Safar,
                        returning the same day.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Payment Schedule --}}
<section class="section-py bg-cream-warm">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Payment</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Payment Schedule</h2>
            <p class="text-muted mt-2" style="max-width:500px;margin:0.75rem auto 0;font-size:0.875rem">
                Payments are collected in stages. A $150 deposit secures your seat at registration.
            </p>
        </div>

        <div class="row g-3 justify-content-center mb-4">
            @foreach($paymentSchedule as $stage)
            <div class="col-md-6 col-lg-3">
                <div class="info-card h-100">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="d-flex align-items-center justify-content-center fw-700 text-white flex-shrink-0"
                              style="width:28px;height:28px;border-radius:50%;background:var(--zp-maroon);font-size:0.72rem">
                            {{ $stage['stage'] }}
                        </span>
                        <span class="fw-600" style="font-size:0.85rem;color:var(--zp-ink)">{{ $stage['label'] }}</span>
                    </div>
                    <p class="mb-2 fw-700 ls-tight" style="font-size:1.5rem;color:var(--zp-maroon)">
                        @if($stage['amount'])
                            ${{ $stage['amount'] }}
                        @else
                            Balance
                        @endif
                    </p>
                    <p class="mb-0 text-muted" style="font-size:0.78rem;line-height:1.65">{{ $stage['note'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('payment-info') }}" class="btn btn-outline-primary px-4">
                Full Payment Details &amp; Methods &rarr;
            </a>
        </div>

    </div>
</section>

{{-- Important Notices --}}
<section class="section-py" style="background:#fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <div class="text-center mb-4">
                    <div class="section-tag mx-auto d-inline-flex">Before You Register</div>
                    <h2 class="display-6 fw-600 ls-tight mt-1">Important Notes</h2>
                </div>
                <div class="p-4 p-md-5 rounded-4 mb-3"
                     style="background:rgba(232,101,31,0.07);border:1.5px solid rgba(232,101,31,0.4)">
                    <div class="d-flex gap-3 align-items-start">
                        <span style="font-size:1.4rem;flex-shrink:0;line-height:1.3">✈️</span>
                        <div>
                            <h4 class="fw-700 text-maroon mb-2" style="font-size:1rem">Ticket &amp; Visa Cost — Estimated at USD 800/person</h4>
                            <p class="mb-0" style="font-size:0.875rem;line-height:1.75;color:var(--zp-ink-soft)">
                                Ticket and visa costs are currently estimated at <strong class="text-ink">USD 800 per person</strong>.
                                Any increase due to changes in airline fares or visa policies will be payable by the pilgrim.
                                Any reduction in cost will be adjusted as a discount or refund to the pilgrim.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 p-md-5 rounded-4 mb-3"
                     style="background:rgba(92,15,30,0.03);border:1.5px solid rgba(92,15,30,0.12)">
                    <div class="d-flex gap-3 align-items-start">
                        <span style="font-size:1.4rem;flex-shrink:0;line-height:1.3">📋</span>
                        <div>
                            <h4 class="fw-700 text-maroon mb-2" style="font-size:1rem">Passport Validity Requirement</h4>
                            <p class="mb-2" style="font-size:0.875rem;line-height:1.75;color:var(--zp-ink-soft)">
                                Iraq requires passports to be valid for at least 6 months beyond your return date.
                                For Group <strong class="text-ink">{{ $group['code'] }}</strong>, your passport
                                must be valid until at least:
                            </p>
                            <p class="mb-2 fw-700 text-maroon" style="font-size:1.05rem">
                                {{ \Carbon\Carbon::parse($group['passport_min_expiry'])->format('j F Y') }}
                            </p>
                            <p class="mb-0" style="font-size:0.825rem;color:var(--zp-orange);font-weight:600">
                                The registration form checks your passport expiry automatically.
                                Passports expiring before this date cannot be accepted for this group.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-3 mb-3"
                     style="background:rgba(232,101,31,0.05);border:1px solid rgba(232,101,31,0.2)">
                    <div class="d-flex gap-3 align-items-start">
                        <span style="font-size:1.2rem;flex-shrink:0;line-height:1.4">💳</span>
                        <div>
                            <h4 class="fw-600 mb-1" style="font-size:0.9rem;color:var(--zp-ink)">Payments at Bhojani Office Only</h4>
                            <p class="mb-0" style="font-size:0.825rem;color:var(--zp-ink-soft);line-height:1.65">
                                All payments are collected at Bhojani Brothers Travel &amp; Tour, Karachi office —
                                via bank transfer or cash. No online payment gateway is available this season.
                                See the <a href="{{ route('payment-info') }}" class="text-maroon fw-500">Payment Info</a> page for full details.
                            </p>
                        </div>
                    </div>
                </div>


                <div class="p-4 rounded-3"
                     style="background:rgba(8,145,178,0.05);border:1px solid rgba(8,145,178,0.2)">
                    <div class="d-flex gap-3 align-items-start">
                        <span style="font-size:1.2rem;flex-shrink:0;line-height:1.4">🚶</span>
                        <div>
                            <h4 class="fw-600 mb-1" style="font-size:0.9rem;color:var(--zp-ink)">Arbaeen Walk is Optional</h4>
                            <p class="mb-0" style="font-size:0.825rem;color:var(--zp-ink-soft);line-height:1.65">
                                Elderly, families with young children, and those with health conditions are not
                                required to walk. Group transport arrangements are made for non-walkers to
                                perform Ziyarat-e-Arbaeen in Karbala on 20 Safar.
                            </p>
                        </div>
                    </div>
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
                <p class="mb-3" style="font-size:0.7rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:var(--zp-gold)">
                    ✦ &nbsp; Group {{ $group['code'] }} &nbsp; ✦
                </p>
                <h2 class="display-6 fw-600 ls-tight text-white mb-3">
                    Ready to Begin Your Journey?
                </h2>
                <p class="mb-5" style="opacity:0.65;font-size:0.9rem">
                    {{ $group['travel_dates'] }} &middot; Maximum {{ $group['max_capacity'] }} zaireen
                </p>
                <a href="{{ route('register') }}?group={{ $group['code'] }}" class="btn btn-orange btn-lg px-5 py-3">
                    Begin Registration &rarr;
                </a>
                <p class="mt-4" style="font-size:0.8rem;opacity:0.5">
                    Questions? WhatsApp us at
                    <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode($whatsappMessage) }}"
                       class="text-gold-soft" style="text-decoration:none" target="_blank" rel="noopener">
                        {{ config('arbaeen.whatsapp.display') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
