@extends('layouts.admin')

@section('title', 'Dashboard — Arbaeen 2026 Admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="fw-700 mb-0" style="font-size:1.25rem;color:var(--zp-ink)">Bookings Dashboard</h1>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <a href="{{ route('admin.group.download', 'AR01') }}" class="btn btn-sm btn-outline-secondary">
            ↓ AR01 List
        </a>
        <a href="{{ route('admin.group.download', 'AR02') }}" class="btn btn-sm btn-outline-secondary">
            ↓ AR02 List
        </a>
        <a href="{{ route('register') }}" class="btn btn-orange btn-sm" target="_blank">
            View Registration Form ↗
        </a>
    </div>
</div>

{{-- Stats strip --}}
<div class="row g-3 mb-4">
    @foreach([
        ['Total Bookings', $stats['total'], 'var(--zp-ink)'],
        ['Total Travelers', $stats['total_travelers'], 'var(--zp-maroon)'],
        ['Arbaeen Discount', $stats['zp_discount_availed'], '#0a6952'],
        ['Confirmed Bookings', $stats['confirmed'], '#155724'],
        ['Pending Deposit', $stats['pending'], 'var(--zp-orange)'],
        ['Cancelled', $stats['cancelled'], '#721c24'],
        ['AR01', $stats['ar01_total'], 'var(--zp-maroon)'],
        ['AR02', $stats['ar02_total'], 'var(--zp-maroon)'],
    ] as $stat)
    <div class="col-6 col-md-4 col-lg-3 col-xl-auto flex-xl-fill">
        <div class="card border-0 shadow-sm text-center p-3">
            <p class="fw-700 mb-0" style="font-size:1.75rem;color:{{ $stat[2] }}">{{ $stat[1] }}</p>
            <p class="text-muted mb-0" style="font-size:0.72rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase">{{ $stat[0] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Filters + Live Search --}}
<div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-3">
    <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
        <select name="group" class="form-select form-select-sm" style="width:auto">
            <option value="">All Groups</option>
            <option value="AR01" {{ request('group') === 'AR01' ? 'selected' : '' }}>AR01</option>
            <option value="AR02" {{ request('group') === 'AR02' ? 'selected' : '' }}>AR02</option>
        </select>
        <select name="status" class="form-select form-select-sm" style="width:auto">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
    </form>
    <input type="search" id="live-search" class="form-control form-control-sm"
           placeholder="Search name, ref, mobile…" style="width:230px;max-width:100%">
</div>

{{-- Bookings table --}}
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="bookings-table" style="font-size:0.85rem">
            <thead style="font-size:0.7rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-ink-soft);background:rgba(0,0,0,0.02)">
                <tr>
                    <th class="py-3 d-none d-md-table-cell" data-sort="date" style="cursor:pointer;user-select:none">Registered <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3 ps-4" data-sort="ref" style="cursor:pointer;user-select:none">Ref <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3" data-sort="group" style="cursor:pointer;user-select:none">Group <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3" data-sort="name" style="cursor:pointer;user-select:none">Lead Name <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3 d-none d-md-table-cell">Mobile</th>
                    <th class="py-3 d-none d-md-table-cell" data-sort="city" style="cursor:pointer;user-select:none">Departure City <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3 d-none d-lg-table-cell">Package</th>
                    <th class="py-3" data-sort="travelers" style="cursor:pointer;user-select:none">Travellers <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3" data-sort="status" style="cursor:pointer;user-select:none">Status <span class="sort-indicator" style="opacity:0.4">↕</span></th>
                    <th class="py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr data-ref="{{ $booking->booking_id }}"
                    data-name="{{ strtolower($booking->lead?->full_name ?? '') }}"
                    data-mobile="{{ $booking->lead?->mobile ?? '' }}"
                    data-group="{{ $booking->group }}"
                    data-status="{{ $booking->status }}"
                    data-city="{{ strtolower($booking->departure_city ?? '') }}"
                    data-travelers="{{ $booking->persons_count }}"
                    data-date="{{ $booking->created_at->timestamp }}">
                    <td class="py-3 d-none d-md-table-cell text-muted" style="font-size:0.78rem">
                        {{ $booking->created_at->timezone('Asia/Karachi')->format('j M, H:i') }}
                    </td>
                    <td class="py-3 ps-4 fw-700 text-maroon" style="font-family:monospace;font-size:0.9rem">
                        {{ $booking->booking_id }}
                    </td>
                    <td class="py-3">
                        <span class="badge" style="background:rgba(92,15,30,0.1);color:var(--zp-maroon);font-size:0.7rem">
                            {{ $booking->group }}
                        </span>
                    </td>
                    <td class="py-3 fw-500">{{ $booking->lead?->full_name ?? '—' }}</td>
                    <td class="py-3 d-none d-md-table-cell text-muted">{{ $booking->lead?->mobile ?? '—' }}</td>
                    <td class="py-3 d-none d-md-table-cell text-muted text-capitalize">{{ $booking->departure_city }}</td>
                    <td class="py-3 d-none d-lg-table-cell text-muted text-capitalize" style="font-size:0.78rem">
                        {{ str_replace('_', ' ', $booking->package_type) }}<br>
                        <span style="font-size:0.72rem;opacity:0.7;text-transform:capitalize">{{ $booking->departure_city }}</span>
                    </td>
                    <td class="py-3 text-center fw-600">
                        {{ $booking->persons_count }}
                        @if($booking->discount_persons_count > 0)
                        <span class="badge d-block mx-auto mt-1" style="background:rgba(10,105,82,0.12);color:#0a6952;font-size:0.62rem;font-weight:600;letter-spacing:0.03em;width:fit-content">
                            Arbaeen Disc. ×{{ $booking->discount_persons_count }}
                        </span>
                        @endif
                    </td>
                    <td class="py-3">
                        @php
                        $statusStyles = [
                            'pending' => 'rgba(232,101,31,0.12);color:var(--zp-orange)',
                            'confirmed' => 'rgba(40,167,69,0.12);color:#155724',
                            'cancelled' => 'rgba(220,53,69,0.12);color:#721c24',
                        ];
                        @endphp
                        <span class="badge" style="font-size:0.7rem;background:{{ $statusStyles[$booking->status] ?? 'rgba(0,0,0,0.08);color:var(--zp-ink-soft)' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    
                    <td class="py-3 pe-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.booking', $booking->booking_id) }}"
                               class="btn btn-outline-primary btn-sm" style="font-size:0.8rem;padding:0.35rem 0.85rem">
                                View
                            </a>
                            @php
                                $rawMobile = $booking->lead?->mobile ?? '';
                                $digits = preg_replace('/\D/', '', $rawMobile);
                                $waNumber = match(true) {
                                    str_starts_with($digits, '92') => $digits,
                                    str_starts_with($digits, '0')  => '92' . substr($digits, 1),
                                    default                        => '92' . $digits,
                                };
                                $waMessage = urlencode(
                                    "Assalamualaikum " . ($booking->lead?->full_name ?? 'there') . ",\n\n" .
                                    "This is regarding your Arbaeen 2026 booking (Ref: " . $booking->booking_id . ").\n\n" .
                                    "Please let us know if you have any questions. JazakAllah Khair.\n\n" .
                                    "— Ziyarat Planner Team"
                                );
                            @endphp
                            @if($rawMobile)
                            <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}"
                               target="_blank"
                               class="btn btn-sm"
                               style="font-size:0.8rem;padding:0.35rem 0.85rem;background:#25D366;color:#fff;border:none"
                               title="WhatsApp {{ $rawMobile }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16" style="margin-top:-1px">
                                    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="py-5 text-center text-muted" style="font-size:0.875rem">
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const table = document.getElementById('bookings-table');
    if (!table) { return; }
    const tbody = table.querySelector('tbody');
    const allRows = () => Array.from(tbody.querySelectorAll('tr[data-ref]'));

    // Live search
    document.getElementById('live-search').addEventListener('input', function () {
        const term = this.value.toLowerCase().trim();
        allRows().forEach(row => {
            if (!term) { row.style.display = ''; return; }
            const haystack = [row.dataset.ref, row.dataset.name, row.dataset.mobile,
                              row.dataset.group, row.dataset.status, row.dataset.city].join(' ').toLowerCase();
            row.style.display = haystack.includes(term) ? '' : 'none';
        });
        const empty = tbody.querySelector('tr:not([data-ref])');
        if (empty) { empty.style.display = allRows().every(r => r.style.display === 'none') ? '' : 'none'; }
    });

    // Sortable headers
    let activeCol = null, dir = 1;
    table.querySelectorAll('th[data-sort]').forEach(th => {
        th.addEventListener('click', function () {
            const col = this.dataset.sort;
            dir = (activeCol === col) ? dir * -1 : 1;
            activeCol = col;
            table.querySelectorAll('th[data-sort] .sort-indicator').forEach(s => { s.textContent = '↕'; s.style.opacity = '0.4'; });
            const ind = this.querySelector('.sort-indicator');
            ind.textContent = dir === 1 ? '↑' : '↓';
            ind.style.opacity = '1';
            const sorted = allRows().sort((a, b) => {
                const av = a.dataset[col] ?? '', bv = b.dataset[col] ?? '';
                return (isNaN(av) || isNaN(bv) ? av.localeCompare(bv) : Number(av) - Number(bv)) * dir;
            });
            sorted.forEach(r => tbody.appendChild(r));
        });
    });
})();
</script>
@endpush
