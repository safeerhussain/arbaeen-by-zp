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
                    <td class="py-3 text-center fw-600">{{ $booking->persons_count }}</td>
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
                        <a href="{{ route('admin.booking', $booking->booking_id) }}"
                           class="btn btn-outline-primary btn-sm" style="font-size:0.75rem;padding:0.25rem 0.7rem">
                            View
                        </a>
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
