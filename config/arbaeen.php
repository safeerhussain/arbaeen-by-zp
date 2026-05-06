<?php

return [

    'whatsapp' => [
        'primary' => '+923353151571',
        'display' => '+92 335 3151571',
        'default_text' => "Assalamu Alaikum, I'm interested in Arbaeen 2026 packages.",
    ],

    'contacts' => [
        [
            'name' => 'Syed Farhan Abbas',
            'phone' => '+92 335 3151571',
            'wa' => '+923353151571',
            'role' => 'Registration',
        ],
        [
            'name' => 'Muhammad Hamza',
            'phone' => '+92 330 3151571',
            'wa' => '+923303151571',
            'role' => 'Registration',
        ],
        [
            'name' => 'Hassan Raza',
            'phone' => '+92 335 3151506',
            'wa' => '+923353151506',
            'role' => 'Support',
        ],
    ],

    'office' => [
        'address' => 'D1, Madni Heights, Soldier Bazar No.3, Karachi, Pakistan',
        'landlines' => ['+92 21 32293 244', '+92 21 32293 644'],
    ],

    'groups' => [
        'AR01' => [
            'code' => 'AR01',
            'name' => 'Arbaeen in Karbala',
            'islamic_dates' => '8 Safar – 22 Safar 1448 AH',
            'travel_dates' => '23 July – 6 August 2026',
            'departure' => '2026-07-23',
            'return_date' => '2026-08-06',
            'max_capacity' => 135,
            'arbaeen_day' => 'Najaf base · Walk to Karbala · Ziyarat on 20 Safar',
            'passport_min_expiry' => '2027-02-06', // 6 months past return
        ],
        'AR02' => [
            'code' => 'AR02',
            'name' => 'Arbaeen + 28 Safar',
            'islamic_dates' => '16 Safar – 30 Safar 1448 AH',
            'travel_dates' => '31 July – 14 August 2026',
            'departure' => '2026-07-31',
            'return_date' => '2026-08-14',
            'max_capacity' => 135,
            'arbaeen_day' => 'Najaf base · Karbala for 28 & 29 Safar',
            'passport_min_expiry' => '2027-02-14', // 6 months past return
        ],
    ],

    'pricing' => [
        'karachi' => [
            'adult' => 1440,
            'child_with_bed' => 1090,
            'child_without_bed' => 1090,
            'infant' => 390,
        ],
        'lahore' => [
            'adult' => 1580,
            'child_with_bed' => 1220,
            'child_without_bed' => 1220,
            'infant' => 450,
        ],
        'islamabad' => [
            'adult' => 1580,
            'child_with_bed' => 1220,
            'child_without_bed' => 1220,
            'infant' => 450,
        ],
        'ground_only' => [
            'adult' => 650,
            'child_with_bed' => 600,
            'child_without_bed' => 300,
            'infant' => 0,
        ],
    ],

    'payment_schedule' => [
        ['stage' => 1, 'label' => 'At Registration',       'amount' => 150, 'note' => 'Covers visa processing cost. Non-refundable once visa has been processed.'],
        ['stage' => 2, 'label' => 'Upon Ticket Confirmation', 'amount' => 350, 'note' => 'Cancellation after this stage is subject to airline policy.'],
        ['stage' => 3, 'label' => 'Upon Ticket Issuance',   'amount' => 400, 'note' => 'Cancellation after ticket issuance: airline charges + $100 per person for service and Iraq ground.'],
        ['stage' => 4, 'label' => 'Remaining Balance',      'amount' => null, 'note' => 'Payable in USD on arrival in Iraq, or in PKR at the Bhojani office before departure.'],
    ],

    'campaign_discount' => [
        'label' => '40-Day Ziyarat-e-Ashura Campaign',
        'amount' => 15000, // PKR
    ],

    'hotels' => [
        ['city' => 'Karbala',   'nights' => 6, 'note' => 'Quality hotel within walking distance from Haram Imam Hussain (a.s.) & Hazrat Abbas (a.s.)'],
        ['city' => 'Kadhimiya', 'nights' => 2, 'note' => 'Quality hotel close to Haram Jawadain (a.s.) — Imam Musa Kazim (a.s.) & Imam Jawad (a.s.)'],
        ['city' => 'Najaf',     'nights' => 6, 'note' => 'Quality hotel within walking distance from Haram Imam Ali (a.s.)'],
    ],

    'passenger_types' => [
        'adult' => ['label' => 'Adult',                'min_age' => 12, 'max_age' => null],
        'child_with_bed' => ['label' => 'Child (with bed)',     'min_age' => 2,  'max_age' => 11],
        'child_without_bed' => ['label' => 'Child (without bed)',  'min_age' => 2,  'max_age' => 11],
        'infant' => ['label' => 'Infant',               'min_age' => 0,  'max_age' => 1],
    ],

    'booking' => [
        'max_family_members' => 15, // lead + 14
        'registration_deposit' => 150,
    ],

    'whatsapp_messages' => [
        'home' => "Assalamu Alaikum, I'm interested in Arbaeen 2026 packages.",
        'ar01' => 'Assalamu Alaikum, I have a question about AR01 (Arbaeen in Karbala).',
        'ar02' => 'Assalamu Alaikum, I have a question about AR02 (Arbaeen + 28 Safar).',
        'register' => 'Assalamu Alaikum, I need help with my registration.',
        'status' => 'Assalamu Alaikum, I need help checking my booking status.',
        'contact' => 'Assalamu Alaikum, I have a general inquiry about Arbaeen 2026.',
    ],

];
