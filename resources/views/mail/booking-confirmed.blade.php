<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Received — {{ $booking->booking_id }}</title>
    <style>
        body { margin: 0; padding: 0; background: #F4EAD5; font-family: -apple-system, 'Segoe UI', sans-serif; color: #2A1810; }
        .wrapper { max-width: 580px; margin: 0 auto; padding: 2rem 1rem; }
        .header { background: #3D0A14; border-radius: 0.75rem 0.75rem 0 0; padding: 2rem; text-align: center; }
        .header h1 { color: #C9A961; margin: 0; font-size: 1.1rem; font-weight: 700; letter-spacing: -0.01em; }
        .header p { color: rgba(255,255,255,0.55); margin: 0.25rem 0 0; font-size: 0.78rem; }
        .body { background: #fff; padding: 2rem; }
        .ref-box { background: #FBF6EC; border: 1px solid rgba(201,169,97,0.4); border-radius: 0.5rem; padding: 1.25rem; text-align: center; margin: 1.5rem 0; }
        .ref-box .ref { font-size: 1.5rem; font-weight: 700; color: #5C0F1E; font-family: monospace; letter-spacing: 0.05em; }
        .table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .table td { padding: 0.6rem 0; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .table td:first-child { color: #5A3A28; width: 45%; }
        .table td:last-child { font-weight: 600; }
        .next-steps { background: #FBF6EC; border-radius: 0.5rem; padding: 1.25rem; margin-top: 1.5rem; }
        .next-steps h3 { font-size: 0.875rem; color: #5C0F1E; margin: 0 0 0.75rem; font-weight: 700; }
        .next-steps ol { margin: 0; padding-left: 1.25rem; font-size: 0.825rem; color: #5A3A28; line-height: 1.8; }
        .footer { background: #3D0A14; border-radius: 0 0 0.75rem 0.75rem; padding: 1.25rem 2rem; text-align: center; }
        .footer p { color: rgba(255,255,255,0.45); margin: 0; font-size: 0.75rem; line-height: 1.7; }
        .footer a { color: #C9A961; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    <div class="header">
        <h1>Arbaeen 2026</h1>
        <p>Ziarat Planner × Bhojani Brothers Travel & Tour</p>
    </div>

    <div class="body">
        <p style="font-size:0.95rem;margin-top:0">
            Assalamu Alaikum <strong>{{ $booking->lead?->full_name }}</strong>,
        </p>
        <p style="font-size:0.875rem;line-height:1.8;color:#5A3A28">
            Your Arbaeen 2026 registration has been received. Your booking reference is below.
            To confirm your seat, please visit the Bhojani Brothers office and pay the
            Stage 1 deposit of <strong>$150 per person</strong>.
        </p>

        <div class="ref-box">
            <p style="margin:0 0 0.25rem;font-size:0.7rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:#5A3A28;opacity:0.6">
                Booking Reference
            </p>
            <div class="ref">{{ $booking->booking_id }}</div>
            <p style="margin:0.5rem 0 0;font-size:0.78rem;color:#5A3A28">Keep this reference for all communications</p>
        </div>

        <table class="table">
            <tr>
                <td>Group</td>
                <td>{{ $booking->group }} — {{ config("arbaeen.groups.{$booking->group}.name") }}</td>
            </tr>
            <tr>
                <td>Travel Dates</td>
                <td>{{ config("arbaeen.groups.{$booking->group}.travel_dates") }}</td>
            </tr>
            <tr>
                <td>Departure City</td>
                <td style="text-transform:capitalize">{{ $booking->departure_city }}</td>
            </tr>
            <tr>
                <td>Package</td>
                <td style="text-transform:capitalize">{{ str_replace('_', ' ', $booking->package_type) }}</td>
            </tr>
            <tr>
                <td>Travellers</td>
                <td>{{ $booking->persons->count() }} person{{ $booking->persons->count() > 1 ? 's' : '' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td style="color:#E8651F">Pending deposit</td>
            </tr>
        </table>

        <div class="next-steps">
            <h3>Next Steps</h3>
            <ol>
                <li>Visit Bhojani Brothers office, Karachi and pay $150 per person (Stage 1 deposit)</li>
                <li>Bring a copy of all travellers' passports</li>
                <li>Quote your booking reference: <strong>{{ $booking->booking_id }}</strong></li>
                <li>Our team will confirm your seat and begin eVisa processing</li>
            </ol>
        </div>

        <p style="font-size:0.825rem;color:#5A3A28;margin-top:1.5rem;line-height:1.75">
            Questions? Call or WhatsApp:
            <a href="tel:+923353151571" style="color:#5C0F1E;font-weight:600">+92 335 3151571</a>
        </p>
    </div>

    <div class="footer">
        <p>
            Bhojani Brothers Travel &amp; Tour · D1, Madni Heights, Soldier Bazar No.3, Karachi<br>
            <a href="{{ config('app.url') }}">{{ parse_url(config('app.url'), PHP_URL_HOST) }}</a>
        </p>
    </div>

</div>
</body>
</html>
