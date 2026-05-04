@extends('layouts.app')

@section('title', 'Check Booking Status — Arbaeen 2026')
@section('meta_description', 'Check your Arbaeen 2026 booking status. Enter your booking reference to see registration details, payment stages, and traveller information.')

@section('content')

{{-- Hero --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Check Booking Status</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem">
            Enter your booking reference to view status and traveller details
        </p>
    </div>
</section>

{{-- Lookup form --}}
<section class="section-py-sm" style="background: var(--zp-cream-warm); border-bottom: 1px solid rgba(201,169,97,0.2);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="GET" action="{{ route('status') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-sm-6">
                            <label class="form-label fw-600 mb-2" style="font-size:0.875rem">Booking Reference</label>
                            <input type="text" id="booking-ref" name="booking_id" class="form-control form-control-lg"
                                   placeholder="AR01-001"
                                   value="{{ request('booking_id') }}"
                                   maxlength="8"
                                   autocomplete="off"
                                   style="text-transform:uppercase;font-family:monospace;letter-spacing:0.08em">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-600 mb-2" style="font-size:0.875rem">Lead Traveller Date of Birth</label>
                            <input type="date" name="lead_dob" class="form-control form-control-lg"
                                   value="{{ request('lead_dob') }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-maroon px-5 fw-600 w-100">Check Booking Status</button>
                        </div>
                    </div>
                </form>

                <script>
                (function () {
                    const input = document.getElementById('booking-ref');
                    if (!input) { return; }

                    input.addEventListener('input', function (e) {
                        let raw = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                        // Format: ARXX-XXX (4 chars, dash, 3 chars)
                        if (raw.length > 4) {
                            raw = raw.slice(0, 4) + '-' + raw.slice(4, 7);
                        }
                        this.value = raw;
                    });

                    input.addEventListener('keydown', function (e) {
                        // Allow backspace to remove dash naturally
                        if (e.key === 'Backspace' && this.value.endsWith('-')) {
                            this.value = this.value.slice(0, -1);
                            e.preventDefault();
                        }
                    });
                })();
                </script>
            </div>
        </div>
    </div>
</section>

<section class="section-py" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if($error)
                <div class="alert alert-danger" style="font-size:0.875rem">{{ $error }}</div>
                @endif

                @if($booking)

                {{-- Status header --}}
                <div class="p-4 rounded-3 mb-4"
                     style="background: {{ $booking->status === 'confirmed' ? 'rgba(40,167,69,0.07)' : ($booking->status === 'cancelled' ? 'rgba(220,53,69,0.07)' : 'rgba(201,169,97,0.1)') }};
                            border: 1px solid {{ $booking->status === 'confirmed' ? 'rgba(40,167,69,0.25)' : ($booking->status === 'cancelled' ? 'rgba(220,53,69,0.25)' : 'rgba(201,169,97,0.3)') }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="fw-700 text-maroon mb-0" style="font-size:1.35rem;letter-spacing:0.03em;font-family:monospace">
                                {{ $booking->booking_id }}
                            </p>
                            <p class="text-muted mb-0" style="font-size:0.8rem">Submitted {{ $booking->created_at->timezone('Asia/Karachi')->format('j M Y') }}</p>
                        </div>
                        <span class="badge fs-6"
                              style="font-size:0.8rem!important;padding:0.5rem 1rem;
                                     background:{{ $booking->status === 'confirmed' ? 'rgba(40,167,69,0.15);color:#155724' : ($booking->status === 'cancelled' ? 'rgba(220,53,69,0.15);color:#721c24' : 'rgba(232,101,31,0.15);color:var(--zp-orange)') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="row g-3" style="font-size:0.85rem">
                        <div class="col-6 col-md-3">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Group</p>
                            <p class="fw-600 mb-0">{{ $booking->group }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Travel</p>
                            <p class="fw-600 mb-0">{{ $group['travel_dates'] }}</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Package</p>
                            <p class="fw-600 mb-0 text-capitalize">{{ str_replace('_', ' ', $booking->package_type) }} Package</p>
                        </div>
                        <div class="col-6 col-md-3">
                            <p class="text-muted mb-0" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Travellers</p>
                            <p class="fw-600 mb-0">{{ $booking->persons->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Persons table --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                        <h3 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">Registered Travellers</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.85rem">
                            <thead style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-ink-soft)">
                                <tr>
                                    <th class="py-3">#</th>
                                    <th class="py-3">Name</th>
                                    <th class="py-3 d-none d-md-table-cell">Gender</th>
                                    <th class="py-3 d-none d-md-table-cell">Type</th>
                                    <th class="py-3">Doc Status</th>
                                    <th class="py-3">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->persons as $person)
                                <tr>
                                    <td class="py-3 text-muted" style="font-family:monospace">{{ $person->position }}</td>
                                    <td class="py-3">
                                        <span class="fw-600">{{ $person->full_name }}</span>
                                        @if($person->position === 1)
                                        <span class="badge ms-1" style="font-size:0.6rem;background:rgba(92,15,30,0.1);color:var(--zp-maroon)">Lead</span>
                                        @endif
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell text-capitalize">{{ $person->gender }}</td>
                                    <td class="py-3 d-none d-md-table-cell text-capitalize" style="font-size:0.78rem">
                                        {{ str_replace('_', ' ', $person->passenger_type) }}
                                    </td>
                                    <td class="py-3">
                                        @php
                                        $docBadge = match($person->passport_status) {
                                            'approved'         => ['rgba(40,167,69,0.12);color:#155724', 'Approved'],
                                            'change_requested' => ['rgba(255,193,7,0.18);color:#856404', 'Change Requested'],
                                            default            => ['rgba(232,101,31,0.12);color:var(--zp-orange)', 'Pending Review'],
                                        };
                                        @endphp
                                        <span class="badge" style="font-size:0.65rem;background:{{ $docBadge[0] }}">
                                            {{ $docBadge[1] }}
                                        </span>
                                        @if($person->passport_renewal_required && $person->passport_status !== 'approved')
                                        <span class="badge mt-1" style="font-size:0.6rem;background:rgba(220,53,69,0.1);color:#721c24">
                                            PP Renewal Pending
                                        </span>
                                        @endif
                                    </td>
                                    <td class="py-3 fw-600 text-maroon">
                                        @if($person->price_usd === 0) Free @else ${{ number_format($person->price_usd) }} @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Payment stages --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                        <h3 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">Payment Stages</h3>
                    </div>
                    <div class="card-body p-0">
                        @php $paidStages = $booking->paymentStages->keyBy('stage'); @endphp
                        @foreach(config('arbaeen.payment_schedule') as $stage)
                        @php $paid = $paidStages->get($stage['stage']); @endphp
                        <div class="d-flex align-items-center gap-3 p-3 {{ !$loop->last ? 'border-bottom' : '' }}"
                             style="border-color:rgba(0,0,0,0.06)!important">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:36px;height:36px;border-radius:50%;
                                        {{ $paid ? 'background:rgba(40,167,69,0.15);color:#155724' : 'background:rgba(0,0,0,0.06);color:var(--zp-ink-soft)' }};
                                        font-size:0.8rem;font-weight:700">
                                {{ $paid ? '✓' : $stage['stage'] }}
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-600 mb-0" style="font-size:0.875rem;color:var(--zp-ink)">{{ $stage['label'] }}</p>
                                <p class="text-muted mb-0" style="font-size:0.78rem">
                                    @if($paid)
                                    Paid {{ $paid->paid_at->timezone('Asia/Karachi')->format('j M Y') }} — ${{ number_format($paid->amount_usd) }}
                                    @else
                                    Not yet paid
                                    @endif
                                </p>
                            </div>
                            <div class="text-end flex-shrink-0">
                                @if($stage['amount'])
                                <p class="fw-700 text-maroon mb-0" style="font-size:0.9rem">${{ $stage['amount'] }}/person</p>
                                @else
                                <p class="fw-600 text-muted mb-0" style="font-size:0.85rem">Balance</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Help --}}
                <div class="text-center">
                    <p class="text-muted mb-3" style="font-size:0.85rem">Questions about your booking?</p>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary px-4 me-2">Contact Us</a>
                    <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode('Assalamu Alaikum, I need help with booking ' . $booking->booking_id) }}"
                       class="btn text-white px-4" target="_blank" rel="noopener"
                       style="background:#25D366;border-color:#25D366">WhatsApp</a>
                </div>

                @elseif(!request()->filled('booking_id'))
                {{-- Empty state --}}
                <div class="text-center py-5">
                    <p style="font-size:3rem;opacity:0.3">🔎</p>
                    <p class="text-muted" style="font-size:0.875rem">
                        Enter your booking reference and lead traveller date of birth to check your registration status.
                    </p>
                    <p class="text-muted" style="font-size:0.8rem">
                        Your booking reference was shown on the confirmation page after registration (e.g., AR01-001).
                    </p>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-py-sm bg-cream">
    <div class="container text-center">
        <p class="text-muted mb-3" style="font-size:0.875rem">Haven't registered yet?</p>
        <a href="{{ route('register') }}" class="btn btn-orange px-5">Begin Registration &rarr;</a>
    </div>
</section>

@endsection
