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
            'passport_status' => ['required', 'in:pending_review,approved,change_requested'],
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
