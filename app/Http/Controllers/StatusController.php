<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatusController extends Controller
{
    public function index(Request $request): View
    {
        $booking = null;
        $error = null;

        if ($request->filled('booking_id') && $request->filled('lead_dob')) {
            $bookingId = strtoupper(trim($request->input('booking_id')));
            $leadDob = $request->input('lead_dob');

            $booking = Booking::with(['persons', 'paymentStages'])
                ->where('booking_id', $bookingId)
                ->first();

            if (! $booking) {
                $error = 'No booking found for reference '.$bookingId.'. Please check and try again.';
            } else {
                $lead = $booking->persons->firstWhere('position', 1);
                if (! $lead || $lead->date_of_birth->format('Y-m-d') !== $leadDob) {
                    $booking = null;
                    $error = 'Details do not match our records. Please check your booking reference and lead traveller date of birth.';
                }
            }
        } elseif ($request->filled('booking_id') || $request->filled('lead_dob')) {
            $error = 'Please enter both your booking reference and lead traveller date of birth.';
        }

        return view('status.index', [
            'booking' => $booking,
            'group' => $booking ? config("arbaeen.groups.{$booking->group}") : null,
            'error' => $error,
            'whatsappMessage' => config('arbaeen.whatsapp_messages.status'),
        ]);
    }
}
