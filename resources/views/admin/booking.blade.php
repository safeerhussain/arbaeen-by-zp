@extends('layouts.admin')

@section('title', $booking->booking_id . ' — Arbaeen 2026 Admin')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">&larr; Dashboard</a>
    <h1 class="fw-700 mb-0" style="font-size:1.1rem;color:var(--zp-ink);font-family:monospace">
        {{ $booking->booking_id }}
    </h1>
    @php
    $statusColors = ['pending' => 'rgba(232,101,31,0.15);color:var(--zp-orange)', 'confirmed' => 'rgba(40,167,69,0.15);color:#155724', 'cancelled' => 'rgba(220,53,69,0.15);color:#721c24'];
    @endphp
    <span class="badge" style="font-size:0.8rem;background:{{ $statusColors[$booking->status] ?? '' }}">
        {{ ucfirst($booking->status) }}
    </span>
</div>

<div class="row g-4">

    {{-- Left column --}}
    <div class="col-lg-8">

        {{-- Booking info --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                <h2 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">Booking Details</h2>
            </div>
            <div class="card-body p-4">
                <div class="row g-3" style="font-size:0.875rem">
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Booking #</p>
                        <p class="fw-600 mb-0" style="font-family:monospace">{{ $booking->booking_id }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Group</p>
                        <p class="fw-600 mb-0">{{ $booking->group }} — {{ $group['name'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Departure</p>
                        <p class="fw-600 mb-0 text-capitalize">{{ $booking->departure_city }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Package</p>
                        <p class="fw-600 mb-0 text-capitalize">{{ str_replace('_', ' ', $booking->package_type) }} Package</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Registered</p>
                        <p class="fw-600 mb-0">{{ $booking->created_at->timezone('Asia/Karachi')->format('j M Y, H:i') }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Heard Via</p>
                        <p class="fw-600 mb-0 text-capitalize">{{ $booking->heard_about_us ?? '—' }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Prev. Arbaeen</p>
                        <p class="fw-600 mb-0">{{ $booking->previous_arbaeen ? 'Yes' : 'No' }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Flags</p>
                        <p class="mb-0" style="font-size:0.82rem">
                            @if($booking->campaign_discount)<span class="badge me-1" style="background:rgba(232,101,31,0.12);color:var(--zp-orange)">Z. Ashura Disc.</span>@endif
                            @if($booking->public_feed_consent)<span class="badge me-1" style="background:rgba(0,123,255,0.12);color:#0056b3">Marketing Consent</span>@endif
                            @if(!$booking->campaign_discount && !$booking->public_feed_consent)<span class="text-muted">—</span>@endif
                        </p>
                    </div>
                    @if($booking->notes)
                    <div class="col-12">
                        <p class="text-muted mb-1" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em">Notes</p>
                        <p class="mb-0">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Persons table --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                <h2 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">
                    Travellers ({{ $booking->persons->count() }})
                </h2>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size:0.85rem">
                    @php
                    $docColors = [
                        'pending_review'   => 'rgba(232,101,31,0.12);color:var(--zp-orange)',
                        'approved'         => 'rgba(40,167,69,0.12);color:#155724',
                        'change_requested' => 'rgba(255,193,7,0.18);color:#856404',
                    ];
                    $docLabels = [
                        'pending_review'   => 'Pending Review',
                        'approved'         => 'Approved',
                        'change_requested' => 'Change Requested',
                    ];
                    @endphp
                    <thead style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-ink-soft);background:rgba(0,0,0,0.02)">
                        <tr>
                            <th class="py-3 ps-4">#</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Gender</th>
                            <th class="py-3">DOB</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Passport Exp.</th>
                            <th class="py-3">Doc Status</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 pe-4"></th>
                        </tr>
                    </thead> 
                    <tbody>
                        @foreach($booking->persons as $person)
                        <tr>
                            <td class="py-3 ps-4 text-muted" style="font-family:monospace">{{ $person->position }}</td>
                            <td class="py-3">
                                <span class="fw-600">{{ $person->full_name }}</span>
                                @if($person->position === 1)
                                <span class="badge ms-1" style="font-size:0.6rem;background:rgba(92,15,30,0.1);color:var(--zp-maroon)">Lead</span>
                                @endif
                                @if($person->fathers_name)
                                <p class="mb-0 text-muted" style="font-size:0.75rem">S/o D/o {{ $person->fathers_name }}</p>
                                @endif
                                @if($person->position === 1)
                                <p class="mb-0 text-muted" style="font-size:0.75rem">{{ $person->mobile }} | {{ $person->email ?? '—' }}</p>
                                @else
                                <p class="mb-0 text-muted text-capitalize" style="font-size:0.75rem">{{ $person->relationship ?? '' }}</p>
                                @endif
                            </td>
                            <td class="py-3 text-capitalize">{{ $person->gender }}</td>
                            <td class="py-3 text-muted" style="font-size:0.8rem">{{ $person->date_of_birth->format('j M Y') }}</td>
                            <td class="py-3 text-capitalize text-muted" style="font-size:0.78rem">{{ str_replace('_', ' ', $person->passenger_type) }}</td>
                            <td class="py-3 text-muted" style="font-size:0.8rem">
                                {{ $person->passport_expiry ? $person->passport_expiry->format('j M Y') : '—' }}
                            </td>
                            <td class="py-3">
                                <span class="badge" style="font-size:0.65rem;background:{{ $docColors[$person->passport_status] ?? '' }}">
                                    {{ $docLabels[$person->passport_status] ?? $person->passport_status }}
                                </span>
                                @if($person->passport_renewal_required && $person->passport_status !== 'approved')
                                <span class="badge ms-1" style="font-size:0.6rem;background:rgba(220,53,69,0.1);color:#721c24">PP Renewal Due</span>
                                @endif
                            </td>
                            <td class="py-3 fw-600 text-maroon">
                                @if($person->price_usd === 0) Free @else ${{ number_format($person->price_usd) }} @endif
                            </td>
                            <td class="py-3 pe-4">
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        style="padding:0.2rem 0.5rem;font-size:0.7rem"
                                        data-bs-toggle="modal"
                                        data-bs-target="#personModal-{{ $person->id }}"
                                        title="View traveller details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="background:rgba(92,15,30,0.03);font-size:0.85rem">
                        <tr>
                            <td colspan="7" class="py-2 ps-4 text-muted fw-600">Total Package Price</td>
                            <td class="py-2 pe-4 fw-700 text-maroon" style="font-size:0.95rem">
                                ${{ number_format($booking->persons->sum('price_usd')) }}
                            </td>
                            <td> </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    {{-- Right column --}}
    <div class="col-lg-4">

        {{-- Status update --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                <h2 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">Booking Status</h2>
            </div>
            <div class="card-body p-3">
                <form method="POST" action="{{ route('admin.booking.status', $booking->booking_id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500" style="font-size:0.82rem">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500" style="font-size:0.82rem">Internal Notes</label>
                        <textarea name="notes" class="form-control form-control-sm" rows="2"
                                  style="font-size:0.82rem" placeholder="Optional">{{ $booking->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-600">Update Status</button>
                </form>
            </div>
        </div>

        {{-- Payment stages --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.06)">
                <h2 class="fw-700 mb-0" style="font-size:0.9rem;color:var(--zp-ink)">Payment Stages</h2>
            </div>
            <div class="card-body p-3">
                @php
                $paidStages = $booking->paymentStages->keyBy('stage');
                $typeLabels = ['adult' => 'Adult', 'child_with_bed' => 'Child (w/ bed)', 'child_without_bed' => 'Child (no bed)', 'infant' => 'Infant'];
                $byType = $booking->persons->groupBy('passenger_type');
                $totalPackage = $booking->persons->sum('price_usd');
                $discountUsd = $booking->campaign_discount ? 50 : 0;
                $netTotal = $totalPackage - $discountUsd;

                $schedule = collect($paymentSchedule);
                $stageExpected = [];
                foreach ($schedule as $s) {
                    if ($s['stage'] < 4) {
                        $stageExpected[$s['stage']] = ($s['amount'] ?? 0) * $booking->persons->count();
                    }
                }
                $paidTotal = $paidStages->whereNotNull('paid_at')->sum('amount_usd');
                $stageExpected[4] = max(0, $netTotal - array_sum(array_slice($stageExpected, 0, 3)));
                @endphp

                {{-- Package summary --}}
                <div class="mb-4 p-3 rounded-2" style="background:rgba(92,15,30,0.03);border:1px solid rgba(0,0,0,0.07)">
                    <p class="fw-700 mb-2" style="font-size:0.68rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--zp-maroon)">Package Breakdown</p>
                    @foreach($byType as $type => $persons)
                    <div class="d-flex justify-content-between" style="font-size:0.78rem;margin-bottom:0.2rem">
                        <span class="text-muted">{{ $typeLabels[$type] ?? $type }} × {{ $persons->count() }}</span>
                        <span class="fw-600">${{ number_format($persons->sum('price_usd')) }}</span>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-between mt-2 pt-2" style="font-size:0.8rem;border-top:1px solid rgba(0,0,0,0.07)">
                        <span class="text-muted">Package Total</span>
                        <span class="fw-600">${{ number_format($totalPackage) }}</span>
                    </div>
                    @if($booking->campaign_discount)
                    <div class="d-flex justify-content-between mt-1" style="font-size:0.78rem">
                        <span style="color:var(--zp-orange)">Z. Ashura Discount (PKR 15,000)</span>
                        <span class="fw-700" style="color:var(--zp-orange)">−$50</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between mt-2 pt-2" style="font-size:0.85rem;font-weight:700;border-top:1px solid rgba(0,0,0,0.1)">
                        <span>Net Total</span>
                        <span class="text-maroon">${{ number_format($netTotal) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-1" style="font-size:0.72rem;color:var(--zp-ink-soft)">
                        <span>Collected so far</span>
                        <span>${{ number_format($paidTotal) }}</span>
                    </div>
                </div>

                {{-- Stage rows --}}
                @foreach($paymentSchedule as $stage)
                @php $paid = $paidStages->get($stage['stage']); @endphp
                <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color:rgba(0,0,0,0.06)!important">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <span class="fw-600" style="font-size:0.82rem;color:var(--zp-ink)">
                                Stage {{ $stage['stage'] }}: {{ $stage['label'] }}
                            </span>
                            @if($stage['amount'])
                            <p class="mb-0 text-muted" style="font-size:0.7rem">${{ $stage['amount'] }}/person × {{ $booking->persons->count() }}</p>
                            @else
                            <p class="mb-0 text-muted" style="font-size:0.7rem">Remaining balance</p>
                            @endif
                        </div>
                        <span class="fw-700 text-maroon" style="font-size:0.85rem">
                            ${{ number_format($stageExpected[$stage['stage']]) }}
                            @if(!$paid)<span class="fw-400 text-muted" style="font-size:0.68rem"> est.</span>@endif
                        </span>
                    </div>
                    @if($paid)
                    <div class="d-flex justify-content-between align-items-center mt-1 p-2 rounded-2" style="background:rgba(40,167,69,0.07)">
                        <p class="text-success mb-0 fw-600" style="font-size:0.78rem">
                            ✓ {{ $paid->paid_at->timezone('Asia/Karachi')->format('j M Y') }}
                            @if($paid->notes)<span class="fw-400 text-muted"> · {{ $paid->notes }}</span>@endif
                        </p>
                        <span class="fw-700 text-success" style="font-size:0.82rem">${{ number_format($paid->amount_usd) }}</span>
                    </div>
                    @else
                    <p class="text-muted mb-2" style="font-size:0.72rem">Not yet paid</p>
                    <form method="POST" action="{{ route('admin.booking.payment.paid', [$booking->booking_id, $stage['stage']]) }}"
                          class="d-flex gap-2 align-items-end flex-wrap">
                        @csrf
                        <div>
                            <label class="form-label mb-1" style="font-size:0.7rem;color:var(--zp-ink-soft)">Amount (USD)</label>
                            <input type="number" name="amount_usd" class="form-control form-control-sm"
                                   value="{{ $stageExpected[$stage['stage']] }}"
                                   style="font-size:0.78rem;width:90px" min="0" step="1">
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label mb-1" style="font-size:0.7rem;color:var(--zp-ink-soft)">Note</label>
                            <input type="text" name="notes" class="form-control form-control-sm"
                                   placeholder="Optional" style="font-size:0.78rem">
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-sm fw-600 flex-shrink-0"
                                style="font-size:0.75rem;white-space:nowrap">
                            Mark Paid
                        </button>
                    </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- Per-person detail modals --}}
@foreach($booking->persons as $person)
@php
$passportDoc = $person->documents->firstWhere('type', 'passport');
$photoDoc    = $person->documents->firstWhere('type', 'photo');
@endphp
<div class="modal fade" id="personModal-{{ $person->id }}" tabindex="-1" aria-labelledby="personModalLabel-{{ $person->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:rgba(92,15,30,0.04);border-bottom:1px solid rgba(0,0,0,0.08)">
                <div>
                    <h5 class="modal-title fw-700" id="personModalLabel-{{ $person->id }}" style="font-size:1rem;color:var(--zp-ink)">
                        {{ $person->full_name }}
                        @if($person->position === 1)
                        <span class="badge ms-2" style="font-size:0.6rem;background:rgba(92,15,30,0.1);color:var(--zp-maroon);vertical-align:middle">Lead</span>
                        @endif
                    </h5>
                    <p class="mb-0 text-muted" style="font-size:0.75rem;font-family:monospace">{{ $person->person_id }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">

                {{-- Person info --}}
                <div class="px-4 pt-4 pb-3">
                    <p class="fw-700 mb-2" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--zp-maroon)">Traveller Information</p>
                    <table class="table table-sm table-borderless mb-0" style="font-size:0.85rem">
                        <tbody>
                            <tr>
                                <td class="text-muted ps-0" style="width:38%">Full Name</td>
                                <td class="fw-500">{{ $person->full_name }}</td>
                            </tr>
                            @if($person->fathers_name)
                            <tr>
                                <td class="text-muted ps-0">Father's Name</td>
                                <td class="fw-500">{{ $person->fathers_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted ps-0">Gender</td>
                                <td class="fw-500 text-capitalize">{{ $person->gender }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Date of Birth</td>
                                <td class="fw-500">{{ $person->date_of_birth->format('j M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">Passenger Type</td>
                                <td class="fw-500 text-capitalize">{{ str_replace('_', ' ', $person->passenger_type) }}</td>
                            </tr>
                            @if($person->position !== 1 && $person->relationship)
                            <tr>
                                <td class="text-muted ps-0">Relationship</td>
                                <td class="fw-500 text-capitalize">{{ $person->relationship }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted ps-0">Passport Expiry</td>
                                <td class="fw-500">
                                    {{ $person->passport_expiry ? $person->passport_expiry->format('j M Y') : '—' }}
                                    @if($person->passport_renewal_required && $person->passport_status !== 'approved')
                                    <span class="badge ms-1" style="font-size:0.6rem;background:rgba(220,53,69,0.12);color:#721c24">PP Renewal Due</span>
                                    @endif
                                </td>
                            </tr>
                            @if($person->position === 1)
                            <tr>
                                <td class="text-muted ps-0">Mobile</td>
                                <td class="fw-500">{{ $person->mobile }}</td>
                            </tr>
                            @if($person->alternate_mobile)
                            <tr>
                                <td class="text-muted ps-0">Alt. Mobile</td>
                                <td class="fw-500">{{ $person->alternate_mobile }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted ps-0">Email</td>
                                <td class="fw-500">{{ $person->email ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0">City</td>
                                <td class="fw-500">{{ $person->city ?? '—' }}</td>
                            </tr>
                            @if($person->wheelchair_required)
                            <tr>
                                <td class="text-muted ps-0">Wheelchair</td>
                                <td class="fw-500">Required</td>
                            </tr>
                            @endif
                            @if($person->medical_notes)
                            <tr>
                                <td class="text-muted ps-0">Medical Notes</td>
                                <td class="fw-500">{{ $person->medical_notes }}</td>
                            </tr>
                            @endif
                            @endif
                            <tr>
                                <td class="text-muted ps-0">Price (USD)</td>
                                <td class="fw-600 text-maroon">
                                    @if($person->price_usd === 0) Free @else ${{ number_format($person->price_usd) }} @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr class="my-0" style="border-color:rgba(0,0,0,0.07)">

                {{-- Documents --}}
                <div class="px-4 py-3">
                    <p class="fw-700 mb-3" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--zp-maroon)">Documents</p>
                    <div class="row g-3">
                        @foreach([['Passport Scan', $passportDoc], ['Passport Photo', $photoDoc]] as [$docLabel, $doc])
                        <div class="col-md-6">
                            <div class="p-3 rounded-2" style="background:rgba(0,0,0,0.025);border:1px solid rgba(0,0,0,0.07)">
                                <p class="fw-600 mb-1" style="font-size:0.78rem;color:var(--zp-ink)">{{ $docLabel }}</p>
                                @if($doc)
                                <p class="text-muted mb-2" style="font-size:0.72rem;word-break:break-all">{{ $doc->original_filename }}</p>
                                <p class="text-muted mb-2" style="font-size:0.7rem">{{ number_format($doc->file_size / 1024, 1) }} KB &middot; uploaded {{ $doc->uploaded_at->timezone('Asia/Karachi')->format('j M Y') }}</p>
                                <a href="{{ route('admin.document.serve', $doc->id) }}" target="_blank" rel="noopener"
                                   class="btn btn-sm btn-outline-primary" style="font-size:0.72rem;padding:0.2rem 0.6rem">
                                    View / Download
                                </a>
                                @else
                                <p class="text-danger mb-0" style="font-size:0.78rem">Not uploaded</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <hr class="my-0" style="border-color:rgba(0,0,0,0.07)">

                {{-- Doc status update --}}
                <div class="px-4 py-3">
                    <p class="fw-700 mb-3" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--zp-maroon)">Document Status</p>
                    <form method="POST" action="{{ route('admin.person.doc-status', $person->id) }}" class="d-flex align-items-end gap-3">
                        @csrf
                        <div class="flex-grow-1">
                            <label class="form-label fw-500 mb-1" style="font-size:0.8rem">Update Status</label>
                            <select name="passport_status" class="form-select form-select-sm" style="font-size:0.82rem">
                                <option value="pending_review"   {{ $person->passport_status === 'pending_review'   ? 'selected' : '' }}>Pending Review</option>
                                <option value="approved"         {{ $person->passport_status === 'approved'         ? 'selected' : '' }}>Approved</option>
                                <option value="change_requested" {{ $person->passport_status === 'change_requested' ? 'selected' : '' }}>Change Requested</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm fw-600" style="font-size:0.8rem;white-space:nowrap">
                            Save Status
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
