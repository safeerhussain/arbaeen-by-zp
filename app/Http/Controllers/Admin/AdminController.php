<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Document;
use App\Models\PaymentStage;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function loginForm(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard(Request $request): View
    {
        $query = Booking::with('lead')
            ->withCount('persons')
            ->latest();

        if ($request->filled('group')) {
            $query->where('group', $request->input('group'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $bookings = $query->get();

        $stats = [
            'total' => Booking::count(),
            'total_travelers' => Person::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'ar01_total' => Booking::where('group', 'AR01')->count(),
            'ar02_total' => Booking::where('group', 'AR02')->count(),
        ];

        return view('admin.dashboard', compact('bookings', 'stats'));
    }

    public function show(string $bookingId): View|RedirectResponse
    {
        $booking = Booking::with(['persons.documents', 'paymentStages'])
            ->where('booking_id', $bookingId)
            ->first();

        if (! $booking) {
            return redirect()->route('admin.dashboard')->with('error', 'Booking not found.');
        }

        $group = config("arbaeen.groups.{$booking->group}");
        $pricing = config('arbaeen.pricing');
        $paymentSchedule = config('arbaeen.payment_schedule');

        return view('admin.booking', compact('booking', 'group', 'pricing', 'paymentSchedule'));
    }

    public function updateStatus(Request $request, string $bookingId): RedirectResponse
    {
        $booking = Booking::where('booking_id', $bookingId)->firstOrFail();

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $booking->update([
            'status' => $data['status'],
            'notes' => $data['notes'] ?? $booking->notes,
            'confirmed_at' => $data['status'] === 'confirmed' ? now() : $booking->confirmed_at,
        ]);

        return back()->with('success', 'Booking status updated.');
    }

    public function updatePersonDocStatus(Request $request, int $personId): RedirectResponse
    {
        $person = Person::findOrFail($personId);

        $data = $request->validate([
            'passport_status' => ['required', 'in:pending_review,approved,change_requested,missing'],
        ]);

        $person->update(['passport_status' => $data['passport_status']]);

        return back()->with('success', "Document status updated for {$person->full_name}.");
    }

    public function serveDocument(int $documentId): Response
    {
        $document = Document::findOrFail($documentId);

        if (! Storage::disk('local')->exists($document->stored_path)) {
            abort(404);
        }

        $contents = Storage::disk('local')->get($document->stored_path);

        return response($contents, 200, [
            'Content-Type' => $document->mime_type,
            'Content-Disposition' => 'inline; filename="'.$document->original_filename.'"',
        ]);
    }

    public function downloadGroupList(string $group): StreamedResponse
    {
        $group = strtoupper($group);
        abort_unless(in_array($group, ['AR01', 'AR02']), 404);

        $bookings = Booking::with([
            'persons' => fn ($q) => $q->orderBy('position'),
            'paymentStages',
        ])
            ->where('group', $group)
            ->get()
            ->sortBy(fn ($b) => strtolower($b->persons->firstWhere('position', 1)?->full_name ?? ''))
            ->values();

        $filename = $group.'_group_list_'.now()->format('Ymd_His').'.csv';

        $columns = [
            // Identity
            'Booking ID', 'Full Name', "Father's Name",
            // Booking status
            'Status', 'Departure City',
            // Traveller details
            'Gender', 'Date of Birth', 'Passenger Type', 'City',
            // Passport / docs
            'Passport Status', 'Passport Expiry', 'Passport Renewal Required',
            // Payment
            'Total Paid (USD)', 'Stages Paid', 'Price (USD)',
            // Special needs
            'Wheelchair Required', 'Medical Notes',
            // Booking metadata
            'Package Type', 'Campaign Discount', 'Previous Arbaeen', 'Confirmed At', 'Registered At',
            // Contact
            'Lead Name', 'Is Lead', 'Relationship', 'Mobile', 'Alternate Mobile', 'Email',
            // Admin reference
            'Person ID', 'Position',
        ];

        $callback = function () use ($bookings, $columns): void {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($handle, $columns);

            foreach ($bookings as $booking) {
                $leadName = $booking->persons->firstWhere('position', 1)?->full_name ?? '';
                $totalPaid = $booking->paymentStages->sum('amount_usd');
                $stagesPaid = $booking->paymentStages->pluck('stage')->sort()->implode(', ');

                foreach ($booking->persons->sortBy('position') as $person) {
                    fputcsv($handle, [
                        // Identity
                        $booking->booking_id,
                        $person->full_name,
                        $person->fathers_name ?? '',
                        // Booking status
                        ucfirst($booking->status),
                        ucfirst($booking->departure_city),
                        // Traveller details
                        ucfirst($person->gender),
                        $person->date_of_birth?->format('d M Y') ?? '',
                        ucwords(str_replace('_', ' ', $person->passenger_type)),
                        $person->city ?? '',
                        // Passport / docs
                        ucwords(str_replace('_', ' ', $person->passport_status)),
                        $person->passport_expiry?->format('d M Y') ?? '',
                        $person->passport_renewal_required ? 'Yes' : 'No',
                        // Payment
                        $totalPaid,
                        $stagesPaid,
                        $person->price_usd,
                        // Special needs
                        $person->wheelchair_required ? 'Yes' : 'No',
                        $person->medical_notes ?? '',
                        // Booking metadata
                        $booking->package_type === 'full' ? 'Full Package' : 'Ground Only',
                        $booking->campaign_discount ? 'Yes' : 'No',
                        $booking->previous_arbaeen ? 'Yes' : 'No',
                        $booking->confirmed_at ? $booking->confirmed_at->format('d M Y') : '',
                        $booking->created_at->format('d M Y'),
                        // Contact
                        $leadName,
                        $person->position === 1 ? 'Yes' : 'No',
                        $person->relationship ?? '',
                        $person->mobile ?? '',
                        $person->alternate_mobile ?? '',
                        $person->email ?? '',
                        // Admin reference
                        $person->person_id,
                        $person->position,
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function markPaymentPaid(Request $request, string $bookingId, int $stage): RedirectResponse
    {
        $booking = Booking::where('booking_id', $bookingId)->firstOrFail();
        $scheduleStage = collect(config('arbaeen.payment_schedule'))->firstWhere('stage', $stage);

        $data = $request->validate([
            'amount_usd' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        PaymentStage::updateOrCreate(
            ['booking_id' => $booking->id, 'stage' => $stage],
            [
                'amount_usd' => $data['amount_usd'] ?? ($scheduleStage['amount'] ?? 0),
                'notes' => $data['notes'] ?? null,
                'paid_at' => now(),
            ]
        );

        return back()->with('success', "Stage {$stage} marked as paid.");
    }
}
