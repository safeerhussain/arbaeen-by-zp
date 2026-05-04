<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class FeedController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Booking::with('lead')
            ->where('public_feed_consent', true)
            ->whereIn('status', ['pending', 'confirmed'])
            ->latest()
            ->limit(30)
            ->get()
            ->map(function (Booking $booking) {
                $lead = $booking->lead;

                return [
                    'name' => $lead ? explode(' ', trim($lead->full_name))[0] : 'Zaair',
                    'city' => $lead?->city ?? 'Pakistan',
                    'group' => $booking->group,
                ];
            });

        return response()->json($items);
    }
}
