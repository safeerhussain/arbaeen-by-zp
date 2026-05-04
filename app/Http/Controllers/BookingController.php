<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\Document;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function create(Request $request): View
    {
        return view('registration.index', [
            'selectedGroup' => $request->query('group'),
            'groups' => config('arbaeen.groups'),
            'pricing' => config('arbaeen.pricing'),
            'passengerTypes' => config('arbaeen.passenger_types'),
            'maxFamily' => config('arbaeen.booking.max_family_members'),
            'campaignDiscount' => config('arbaeen.campaign_discount'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.register'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $personCount = count($request->input('persons', []));
        $attributes = $this->buildAttributes($personCount);

        $data = $request->validate([
            'group' => ['required', 'in:AR01,AR02'],
            'departure_city' => ['required', 'in:karachi,lahore,islamabad'],
            'package_type' => ['required', 'in:full,ground_only'],
            'campaign_discount' => ['nullable', 'boolean'],
            'heard_about_us' => ['nullable', 'string', 'max:100'],
            'previous_arbaeen' => ['nullable', 'boolean'],
            'public_feed_consent' => ['nullable', 'boolean'],
            'agree_terms' => ['accepted'],
            'persons' => ['required', 'array', 'min:1', 'max:15'],
            'persons.*.full_name' => ['required', 'string', 'max:100'],
            'persons.*.fathers_name' => ['nullable', 'string', 'max:100'],
            'persons.*.gender' => ['required', 'in:male,female'],
            'persons.*.date_of_birth' => ['required', 'date', 'before:today'],
            'persons.*.passenger_type' => ['required', 'in:adult,child_with_bed,child_without_bed,infant'],
            'persons.*.relationship' => ['nullable', 'string', 'max:50'],
            'persons.*.passport_expiry' => ['nullable', 'date'],
            'persons.*.passport_renewal_confirmed' => ['nullable', 'boolean'],
            'persons.*.passport_scan' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'persons.*.passport_photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:3072'],
            'persons.0.mobile' => ['required', 'string', 'max:20'],
            'persons.0.alternate_mobile' => ['nullable', 'string', 'max:20'],
            'persons.0.email' => ['required', 'email', 'max:150'],
            'persons.0.city' => ['required', 'string', 'max:100'],
            'persons.0.wheelchair_required' => ['nullable', 'boolean'],
            'persons.0.medical_notes' => ['nullable', 'string', 'max:500'],
        ], [], $attributes);

        $group = $data['group'];
        $groupConfig = config("arbaeen.groups.{$group}");
        $passportMinDate = Carbon::parse($groupConfig['passport_min_expiry']);
        $pricingKey = $data['package_type'] === 'ground_only' ? 'ground_only' : $data['departure_city'];
        $pricing = config('arbaeen.pricing');

        $booking = DB::transaction(function () use ($data, $request, $group, $pricingKey, $pricing, $passportMinDate) {
            $seq = str_pad(Booking::where('group', $group)->count() + 1, 3, '0', STR_PAD_LEFT);
            $bookingId = "{$group}-{$seq}";

            $booking = Booking::create([
                'booking_id' => $bookingId,
                'group' => $group,
                'status' => 'pending',
                'departure_city' => $data['departure_city'],
                'package_type' => $data['package_type'],
                'campaign_discount' => (bool) ($data['campaign_discount'] ?? false),
                'heard_about_us' => $data['heard_about_us'] ?? null,
                'previous_arbaeen' => (bool) ($data['previous_arbaeen'] ?? false),
                'public_feed_consent' => (bool) ($data['public_feed_consent'] ?? false),
            ]);

            foreach ($data['persons'] as $i => $personData) {
                $position = $i + 1;
                $passengerType = $personData['passenger_type'];
                $priceUsd = $pricing[$pricingKey][$passengerType] ?? 0;
                $expiryDate = Carbon::parse($personData['passport_expiry']);
                $needsRenewal = $expiryDate->lt($passportMinDate);

                $personPayload = [
                    'booking_id' => $booking->id,
                    'person_id' => "{$bookingId}-".str_pad($position, 2, '0', STR_PAD_LEFT),
                    'position' => $position,
                    'full_name' => $personData['full_name'],
                    'fathers_name' => $personData['fathers_name'] ?? null,
                    'gender' => $personData['gender'],
                    'date_of_birth' => $personData['date_of_birth'],
                    'passenger_type' => $passengerType,
                    'relationship' => $position === 1 ? null : ($personData['relationship'] ?? null),
                    'passport_expiry' => $personData['passport_expiry'],
                    'passport_renewal_required' => $needsRenewal,
                    'passport_status' => 'pending_review',
                    'price_usd' => $priceUsd,
                ];

                if ($position === 1) {
                    $personPayload['mobile'] = $personData['mobile'];
                    $personPayload['alternate_mobile'] = $personData['alternate_mobile'] ?? null;
                    $personPayload['email'] = $personData['email'];
                    $personPayload['city'] = $personData['city'];
                    $personPayload['wheelchair_required'] = (bool) ($personData['wheelchair_required'] ?? false);
                    $personPayload['medical_notes'] = $personData['medical_notes'] ?? null;
                }

                $person = Person::create($personPayload);

                foreach (['passport_scan' => 'passport', 'passport_photo' => 'photo'] as $inputKey => $docType) {
                    $file = $request->file("persons.{$i}.{$inputKey}");
                    if ($file && $file->isValid()) {
                        $path = $file->store("uploads/{$bookingId}", 'local');
                        Document::create([
                            'person_id' => $person->id,
                            'type' => $docType,
                            'original_filename' => $file->getClientOriginalName(),
                            'stored_path' => $path,
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }

            return $booking;
        });

        $lead = $booking->lead;
        if ($lead?->email) {
            Mail::to($lead->email)->queue(new BookingConfirmedMail($booking));
        }

        return redirect()->route('register.confirmed', $booking->booking_id);
    }

    public function confirmed(string $bookingId): View|RedirectResponse
    {
        $booking = Booking::with(['persons', 'lead'])
            ->where('booking_id', $bookingId)
            ->first();

        if (! $booking) {
            return redirect()->route('register');
        }

        return view('registration.confirmed', [
            'booking' => $booking,
            'group' => config("arbaeen.groups.{$booking->group}"),
            'contacts' => config('arbaeen.contacts'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.register'),
        ]);
    }

    /** @return array<string, string> */
    private function buildAttributes(int $personCount): array
    {
        $attrs = [
            'persons.0.full_name' => "Lead Traveller's Full Name",
            'persons.0.fathers_name' => "Lead Traveller's Father's Name",
            'persons.0.gender' => "Lead Traveller's Gender",
            'persons.0.date_of_birth' => "Lead Traveller's Date of Birth",
            'persons.0.passenger_type' => "Lead Traveller's Passenger Type",
            'persons.0.passport_expiry' => "Lead Traveller's Passport Expiry Date",
            'persons.0.passport_scan' => "Lead Traveller's Passport Scan",
            'persons.0.passport_photo' => "Lead Traveller's Passport Photo",
            'persons.0.mobile' => "Lead Traveller's Mobile Number",
            'persons.0.email' => "Lead Traveller's Email Address",
            'persons.0.city' => "Lead Traveller's City",
        ];

        for ($i = 1; $i < $personCount; $i++) {
            $pos = $i + 1;
            $attrs["persons.{$i}.full_name"] = "Traveller {$pos}'s Full Name";
            $attrs["persons.{$i}.gender"] = "Traveller {$pos}'s Gender";
            $attrs["persons.{$i}.date_of_birth"] = "Traveller {$pos}'s Date of Birth";
            $attrs["persons.{$i}.passport_expiry"] = "Traveller {$pos}'s Passport Expiry Date";
            $attrs["persons.{$i}.passport_scan"] = "Traveller {$pos}'s Passport Scan";
            $attrs["persons.{$i}.passport_photo"] = "Traveller {$pos}'s Passport Photo";
        }

        return $attrs;
    }
}
