@extends('layouts.app')

@section('title', 'Registration Received — ' . $booking->booking_id . ' | Arbaeen 2026')
@section('meta_description', 'Your Arbaeen 2026 registration has been received. Booking reference: ' . $booking->booking_id)

@section('content')

{{-- Hero --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Registration Received</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem">
            Your booking reference is <strong class="text-gold">{{ $booking->booking_id }}</strong>
        </p>
    </div>
</section>

{{-- Main content --}}
<section class="section-py" style="background: var(--zp-cream-warm);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- Success card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5 text-center">
                        <div class="d-flex align-items-center justify-content-center mx-auto mb-4"
                             style="width:72px;height:72px;border-radius:50%;background:rgba(92,15,30,0.08)">
                            <span style="font-size:2rem">✅</span>
                        </div>
                        <h2 class="fw-700 text-maroon mb-2" style="font-size:1.25rem">Registration Submitted</h2>
                        <p class="text-muted mb-4" style="font-size:0.875rem;line-height:1.75">
                            Your registration for <strong>{{ $group['name'] }} ({{ $booking->group }})</strong>
                            has been received. To confirm your seats, visit the Bhojani Brothers office
                            and pay the Stage 1 deposit of <strong>$150 per person</strong>.
                        </p>

                        <div class="p-4 rounded-3 mb-4 text-start"
                             style="background:rgba(201,169,97,0.12);border:1px solid rgba(201,169,97,0.3)">
                            <table class="table table-sm mb-0" style="font-size:0.875rem">
                                <tr>
                                    <td class="text-muted border-0 pb-2" style="width:45%">Booking Reference</td>
                                    <td class="fw-700 text-maroon border-0 pb-2" style="font-size:1.05rem">{{ $booking->booking_id }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0 pb-2">Group</td>
                                    <td class="fw-600 border-0 pb-2">{{ $booking->group }} — {{ $group['name'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0 pb-2">Travel Dates</td>
                                    <td class="fw-600 border-0 pb-2">{{ $group['travel_dates'] }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0 pb-2">Travellers</td>
                                    <td class="fw-600 border-0 pb-2">{{ $booking->persons->count() }} person{{ $booking->persons->count() > 1 ? 's' : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0 pb-2">Lead Contact</td>
                                    <td class="fw-600 border-0 pb-2">{{ $booking->lead?->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0">Status</td>
                                    <td class="border-0">
                                        <span class="badge" style="background:rgba(232,101,31,0.15);color:var(--zp-orange);font-size:0.75rem">
                                            Pending deposit
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted border-0 pt-2">Document Status</td>
                                    <td class="border-0 pt-2">
                                        @php
                                        $allMissing = $booking->persons->every(fn($p) => $p->passport_status === 'missing');
                                        $anyMissing = $booking->persons->contains(fn($p) => $p->passport_status === 'missing');
                                        @endphp
                                        @if($allMissing)
                                        <span class="badge" style="background:rgba(80,80,80,0.12);color:#4a4a4a;font-size:0.75rem">Missing</span>
                                        <p class="mb-0 text-muted mt-1" style="font-size:0.72rem">No documents uploaded. You can bring them to the office.</p>
                                        @elseif($anyMissing)
                                        <span class="badge" style="background:rgba(232,101,31,0.12);color:var(--zp-orange);font-size:0.75rem">Partial</span>
                                        <p class="mb-0 text-muted mt-1" style="font-size:0.72rem">Some travellers have missing documents. Our team will be in touch.</p>
                                        @else
                                        <span class="badge" style="background:rgba(232,101,31,0.12);color:var(--zp-orange);font-size:0.75rem">Pending Review</span>
                                        <p class="mb-0 text-muted mt-1" style="font-size:0.72rem">Our team will review your uploaded documents.</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="alert alert-warning text-start mb-0" style="font-size:0.825rem;border-color:rgba(201,169,97,0.4);background:rgba(201,169,97,0.1);color:var(--zp-ink)">
                            <strong>Important:</strong> Your seat is not confirmed until the $150 Stage 1 deposit
                            is paid at the Bhojani Brothers office. Please note your booking reference
                            <strong>{{ $booking->booking_id }}</strong> for all communications.
                        </div>
                    </div>
                </div>

                {{-- Pricing breakdown --}}
                @php
                $typeLabels = ['adult' => 'Adult', 'child_with_bed' => 'Child (with bed)', 'child_without_bed' => 'Child (without bed)', 'infant' => 'Infant'];
                $byType = $booking->persons->groupBy('passenger_type');
                $totalPackage = $booking->persons->sum('price_usd');
                $discountUsd = $booking->campaign_discount ? 50 : 0;
                $netTotal = $totalPackage - $discountUsd;
                $stage1Due = 150 * $booking->persons->count();
                @endphp
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-700 text-ink mb-4" style="font-size:1rem">Pricing Breakdown</h3>
                        <table class="table table-sm mb-0" style="font-size:0.875rem">
                            @foreach($byType as $type => $persons)
                            @php $unitPrice = $persons->first()->price_usd; @endphp
                            <tr>
                                <td class="text-muted border-0 pb-2">
                                    {{ $typeLabels[$type] ?? $type }}
                                    @if($persons->count() > 1) × {{ $persons->count() }}@endif
                                </td>
                                <td class="text-muted border-0 pb-2" style="width:30%">
                                    @if($persons->count() > 1)${{ number_format($unitPrice) }} each @endif
                                </td>
                                <td class="fw-600 border-0 pb-2 text-end">${{ number_format($persons->sum('price_usd')) }}</td>
                            </tr>
                            @endforeach
                            @if($booking->campaign_discount)
                            <tr>
                                <td class="border-0 pb-2" style="color:var(--zp-orange)">40-Day Ziyarat-e-Ashura Discount</td>
                                <td class="border-0 pb-2"></td>
                                <td class="fw-600 border-0 pb-2 text-end" style="color:var(--zp-orange)">−$50</td>
                            </tr>
                            @endif
                            <tr style="border-top:2px solid rgba(0,0,0,0.1)">
                                <td class="fw-700 pt-3 border-0" style="color:var(--zp-ink)">Total Package Price</td>
                                <td class="border-0 pt-3"></td>
                                <td class="fw-700 pt-3 border-0 text-end text-maroon" style="font-size:1.05rem">${{ number_format($netTotal) }}</td>
                            </tr>
                        </table>
                        <div class="mt-3 p-3 rounded-3" style="background:rgba(92,15,30,0.05);border:1px solid rgba(92,15,30,0.12)">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fw-700 mb-0" style="font-size:0.875rem;color:var(--zp-maroon)">Stage 1 Deposit Due Now</p>
                                    <p class="text-muted mb-0" style="font-size:0.75rem">$150 × {{ $booking->persons->count() }} person{{ $booking->persons->count() > 1 ? 's' : '' }} — payable at Bhojani Brothers office</p>
                                </div>
                                <span class="fw-700 text-maroon" style="font-size:1.1rem">${{ number_format($stage1Due) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $waContactLines = collect(config('arbaeen.contacts'))->map(fn ($c) => "{$c['name']} ({$c['role']}): {$c['phone']}")->implode("\n");
                $waText = implode("\n", [
                    'Assalamu Alaikum — here is my Arbaeen 2026 booking record:',
                    '',
                    'Booking Ref: '.$booking->booking_id,
                    'Group: '.$booking->group.' — '.$group['name'],
                    'Travel Dates: '.$group['travel_dates'],
                    'Travellers: '.$booking->persons->count().' person'.($booking->persons->count() > 1 ? 's' : ''),
                    'Lead Name: '.($booking->lead?->full_name ?? '—'),
                    'Stage 1 Deposit Due: $'.number_format($stage1Due).' (visit office to pay)',
                    '',
                    'Bhojani Brothers Travel & Tour',
                    config('arbaeen.office.address'),
                    $waContactLines,
                ]);
                @endphp

                {{-- Actions --}}
                <p class="text-center text-muted mb-2" style="font-size:0.78rem">Save your booking slip for your records</p>
                <div class="d-flex gap-3 flex-wrap justify-content-center mb-3">
                    <button type="button" onclick="window.print()" class="btn btn-maroon px-4">
                        &#8659; Download Slip
                    </button>
                    <a href="https://wa.me/?text={{ urlencode($waText) }}"
                       target="_blank" rel="noopener"
                       class="btn px-4 fw-600 text-white"
                       style="background:#25D366;border-color:#25D366">
                        Share to WhatsApp
                    </a>
                </div>

                {{-- Next steps --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-700 text-ink mb-4" style="font-size:1rem">What Happens Next</h3>
                        <div class="d-flex flex-column gap-3">
                            @foreach([
                                ['1', 'Pay Stage 1 Deposit', 'Visit the Bhojani Brothers office and pay $150 per person. This secures your seat and initiates visa processing.'],
                                ['2', 'Passport Collection', 'Our team will contact you to collect passport copies for Iraq eVisa processing.'],
                                ['3', 'Ticket Confirmation', 'Once tickets are confirmed, Stage 2 payment ($350 per person) is due.'],
                                ['4', 'Travel Documents', 'Visa and tickets are issued. Final balance is settled before or on arrival in Iraq.'],
                            ] as $step)
                            <div class="d-flex gap-3">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width:32px;height:32px;border-radius:50%;background:var(--zp-maroon);color:#fff;font-size:0.8rem;font-weight:700">
                                    {{ $step[0] }}
                                </div>
                                <div>
                                    <p class="fw-600 mb-0" style="font-size:0.875rem;color:var(--zp-ink)">{{ $step[1] }}</p>
                                    <p class="text-muted mb-0" style="font-size:0.8rem;line-height:1.65">{{ $step[2] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Contact section --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="fw-700 text-ink mb-3" style="font-size:1rem">Contact Us</h3>
                        <div class="row g-3">
                            @foreach($contacts as $contact)
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                                     style="background:var(--zp-cream-warm)">
                                    <div>
                                        <p class="fw-600 mb-0" style="font-size:0.85rem;color:var(--zp-ink)">{{ $contact['name'] }}</p>
                                        <p class="mb-0" style="font-size:0.75rem;color:var(--zp-ink-soft)">{{ $contact['role'] }}</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                                           class="btn btn-outline-primary btn-sm" style="font-size:0.7rem;padding:0.25rem 0.6rem">Call</a>
                                        <a href="https://wa.me/{{ ltrim($contact['wa'], '+') }}?text={{ urlencode('Assalamu Alaikum, my booking reference is ' . $booking->booking_id . '. I would like to pay the Stage 1 deposit.') }}"
                                           class="btn btn-sm text-white" target="_blank" rel="noopener"
                                           style="font-size:0.7rem;padding:0.25rem 0.6rem;background:#25D366;border-color:#25D366">WA</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <a href="{{ route('status') }}?booking_id={{ $booking->booking_id }}" class="btn btn-outline-primary px-4">
                        Check Booking Status
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">
                        Back to Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@push('body-end')
{{-- Print slip: must be direct child of <body> so print CSS can override body > * { display:none } --}}
<div id="print-slip">
    <div style="background:#5C0F1E;padding:20px 24px;text-align:center;border-radius:8px 8px 0 0">
        <p style="color:#C9A961;font-size:18px;font-weight:700;margin:0 0 4px">Arbaeen 2026</p>
        <p style="color:rgba(255,255,255,0.75);font-size:11px;margin:0">Bhojani Brothers Travel &amp; Tour &nbsp;&middot;&nbsp; Ziarat Planner</p>
    </div>

    <div style="background:#FBF6EC;border:1px solid rgba(201,169,97,0.4);border-top:none;padding:20px 24px;text-align:center">
        <p style="font-size:10px;letter-spacing:0.12em;color:#888;text-transform:uppercase;margin:0 0 6px">Booking Reference</p>
        <p style="font-size:28px;font-weight:700;color:#5C0F1E;font-family:monospace;letter-spacing:0.05em;margin:0 0 6px">{{ $booking->booking_id }}</p>
        <p style="font-size:10px;color:#aaa;margin:0">Keep this reference for all communications with Bhojani Brothers</p>
    </div>

    <div style="border:1px solid rgba(0,0,0,0.1);border-top:none;padding:20px 24px">
        <table style="width:100%;border-collapse:collapse;font-size:12px">
            <tr>
                <td style="color:#888;padding:5px 0;width:45%">Group</td>
                <td style="font-weight:600;padding:5px 0;color:#1a1a1a">{{ $booking->group }} &mdash; {{ $group['name'] }}</td>
            </tr>
            <tr>
                <td style="color:#888;padding:5px 0">Travel Dates</td>
                <td style="font-weight:600;padding:5px 0;color:#1a1a1a">{{ $group['travel_dates'] }}</td>
            </tr>
            <tr>
                <td style="color:#888;padding:5px 0">Travellers</td>
                <td style="font-weight:600;padding:5px 0;color:#1a1a1a">{{ $booking->persons->count() }} person{{ $booking->persons->count() > 1 ? 's' : '' }}</td>
            </tr>
            <tr>
                <td style="color:#888;padding:5px 0">Lead Name</td>
                <td style="font-weight:600;padding:5px 0;color:#1a1a1a">{{ $booking->lead?->full_name }}</td>
            </tr>
            <tr>
                <td style="color:#888;padding:5px 0">Mobile</td>
                <td style="font-weight:600;padding:5px 0;color:#1a1a1a">{{ $booking->lead?->mobile }}</td>
            </tr>
            <tr style="border-top:1px solid rgba(0,0,0,0.08)">
                <td style="color:#888;padding:9px 0 5px">Total Package</td>
                <td style="font-weight:600;padding:9px 0 5px;color:#1a1a1a">${{ number_format($netTotal) }}</td>
            </tr>
            <tr>
                <td style="color:#5C0F1E;padding:5px 0;font-weight:600">Stage 1 Deposit Due</td>
                <td style="font-weight:700;padding:5px 0;color:#5C0F1E;font-size:14px">${{ number_format($stage1Due) }}</td>
            </tr>
        </table>
        <p style="font-size:10px;color:#aaa;margin:12px 0 0;border-top:1px solid rgba(0,0,0,0.06);padding-top:10px">
            Stage 1 deposit of $150 per person is payable at the Bhojani Brothers office to confirm your seat.
        </p>
    </div>

    <div style="border:1px solid rgba(0,0,0,0.1);border-top:none;padding:16px 24px;background:#f9f6f0">
        <p style="font-size:10px;letter-spacing:0.1em;text-transform:uppercase;color:#888;margin:0 0 10px">Contact Bhojani Brothers</p>
        @foreach($contacts as $contact)
        <div style="margin-bottom:6px">
            <span style="font-size:12px;font-weight:600;color:#1a1a1a">{{ $contact['name'] }}</span>
            <span style="font-size:11px;color:#666"> &nbsp;&middot;&nbsp; {{ $contact['role'] }} &nbsp;&middot;&nbsp; {{ $contact['phone'] }}</span>
        </div>
        @endforeach
    </div>

    <div style="background:#5C0F1E;padding:14px 24px;text-align:center;border-radius:0 0 8px 8px">
        <p style="color:rgba(255,255,255,0.7);font-size:10px;margin:0 0 3px">{{ config('arbaeen.office.address') }}</p>
        <p style="color:rgba(255,255,255,0.45);font-size:9px;margin:0">Generated {{ now()->format('d M Y') }}</p>
    </div>
</div>

@endpush

@push('styles')
<style>
#print-slip { display: none; }

@media print {
    @page { margin: 1cm; size: A5 portrait; }
    body > * { display: none !important; }
    body { background: #fff !important; }
    #print-slip {
        display: block !important;
        max-width: 480px;
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
    }
    * { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
}
</style>
@endpush
