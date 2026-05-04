@extends('layouts.app')

@section('title', 'Frequently Asked Questions — Arbaeen 2026')
@section('meta_description', 'Answers to common questions about Arbaeen 2026 registration, packages, payments, visa, health, and the Arbaeen Walk. Bhojani Brothers × Ziarat Planner.')

@section('content')

{{-- Hero --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Frequently Asked Questions</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem">
            Everything you need to know before registering
        </p>
    </div>
</section>

{{-- FAQ Content --}}
<section class="section-py" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @php
                $sections = [
                    [
                        'title' => 'Registration & Booking',
                        'faqs' => [
                            ['q' => 'How do I register for Arbaeen 2026?', 'a' => 'Use the Begin Registration button on our website. Complete the multi-step form with your details and family members. After submitting, you will receive a booking reference number. Bring this reference and pay the Stage 1 deposit ($150 per person) at the Bhojani Brothers office in Karachi to confirm your seat.'],
                            ['q' => 'What is the registration deposit?', 'a' => 'The Stage 1 deposit is $150 per person, payable at the Bhojani Brothers Karachi office via bank transfer or cash. This deposit covers visa processing costs and secures your seat. It is non-refundable once visa processing has commenced.'],
                            ['q' => 'How many people can I register at once?', 'a' => 'You can register up to 15 travellers in a single registration (1 lead + up to 14 family members or companions). Larger groups must register separately and are subject to seat availability.'],
                            ['q' => 'Can I register if I am not from Karachi?', 'a' => 'Yes. We offer departure options from Karachi, Lahore, and Islamabad. Select your departure city during registration. Prices vary by departure city — Lahore and Islamabad departures are $1,580 per adult (full package). Karachi is $1,440 per adult.'],
                            ['q' => 'How do I know if seats are still available?', 'a' => 'The seat availability counter on the home page is updated in real time. Each group has a maximum of 135 zaireen. Register early as seats fill quickly. Contact our registration team directly via WhatsApp for the latest availability.'],
                        ],
                    ],
                    [
                        'title' => 'Package & Inclusions',
                        'faqs' => [
                            ['q' => 'What does the full package price include?', 'a' => 'The full package includes: international return airfare (Karachi/Lahore/Islamabad ↔ Iraq), Iraq eVisa, 14 nights hotel accommodation (6 Karbala, 2 Kadhimiya, 6 Najaf), all meals (breakfast, lunch, dinner), AC group bus transport airport-to-airport and between cities, luggage handling, and a group leader, Maulana, and Noha Khuwan throughout.'],
                            ['q' => 'What is the Ground Only package?', 'a' => 'The Ground Only package covers the Iraq portion only — hotels, all meals, AC transport within Iraq, and group services. It does not include airfare or visa. It is for travellers who arrange their own flights to Iraq. The adult price is $600 from Karachi.'],
                            ['q' => 'Are there different prices for children and infants?', 'a' => 'Yes. Children (2–11 years) with a dedicated bed are priced at $1,090 (Karachi, full package). Children without a separate bed are the same price. Infants under 2 years are $390 (Karachi). For Ground Only, infants travel free of charge.'],
                            ['q' => 'What hotels will we stay in?', 'a' => 'We stay at quality hotels within walking distance of the main Harams: in Karbala (near Haram Imam Hussain a.s. & Hazrat Abbas a.s.), in Kadhimiya (near Haram Jawadain a.s.), and in Najaf (near Haram Imam Ali a.s.). Hotel names are shared closer to the travel date once confirmed.'],
                            ['q' => 'Is there a campaign discount available?', 'a' => 'Yes. Travellers who completed the 40-Day Ziyarat-e-Ashura Campaign receive a PKR 15,000 discount per registration. Select this option during registration and bring verification to the office. The discount is applied at the office upon confirmation.'],
                        ],
                    ],
                    [
                        'title' => 'The Arbaeen Walk',
                        'faqs' => [
                            ['q' => 'Is the Arbaeen Walk (Najaf to Karbala) compulsory?', 'a' => 'No. The Arbaeen Walk is entirely optional. Non-walkers remain at the Najaf hotel with luggage and are transported by the group bus to Karbala to perform ziyarat-e-Arbaeen on 20 Safar (AR01) or 28/29 Safar (AR02) and return to Najaf. There is no penalty or additional charge for not walking.'],
                            ['q' => 'How long is the Arbaeen Walk?', 'a' => 'The Najaf to Karbala route is approximately 80 kilometres. Most pilgrims walk over 2–3 days at their own pace. Water, food, and rest stations (mawkibs) are available throughout the route at no cost — this is one of the world\'s most remarkable displays of hospitality.'],
                            ['q' => 'Are walkers separated from non-walkers during the walk?', 'a' => 'During the walk itself, yes — walkers proceed on foot while non-walkers travel by bus. The group reunites in Karbala for ziyarat and then continues together. Our group leader accompanies the main group and coordinates between both.'],
                        ],
                    ],
                    [
                        'title' => 'Passport & Visa',
                        'faqs' => [
                            ['q' => 'What passport validity is required?', 'a' => 'Iraq requires your passport to be valid for at least 6 months beyond your return date. AR01 passengers (returning 6 August 2026) need a passport valid until at least 6 February 2027. AR02 passengers (returning 14 August 2026) need a passport valid until at least 14 February 2027. Check your passport before registering.'],
                            ['q' => 'Who handles the Iraq eVisa?', 'a' => 'We handle Iraq eVisa processing on your behalf. After the Stage 1 deposit is paid, our team will collect passport copies and submit visa applications. Travellers must ensure all submitted information is accurate — visa rejections due to incorrect information are not our responsibility.'],
                            ['q' => 'My passport expires soon — can I still join?', 'a' => 'Only if you can renew it before the visa application deadline. Contact us immediately if your passport is expiring. Passport renewal timelines in Pakistan can be 4–8 weeks. We recommend checking your passport validity before registering.'],
                        ],
                    ],
                    [
                        'title' => 'Payments',
                        'faqs' => [
                            ['q' => 'What is the full payment schedule?', 'a' => 'Payments are in four stages: Stage 1 ($150/person at registration), Stage 2 ($350/person upon ticket confirmation), Stage 3 ($400/person upon ticket issuance), Stage 4 (remaining balance — payable in USD on arrival in Iraq or in PKR at the Karachi office before departure). For a Karachi adult at $1,440, the remaining Stage 4 balance is $540.'],
                            ['q' => 'Can I pay online?', 'a' => 'Online payment is not available this season. All payments are made at the Bhojani Brothers Karachi office via bank transfer or cash. The final balance (Stage 4) can be paid in USD on arrival in Iraq. Contact us for current PKR exchange rates.'],
                            ['q' => 'What happens if I cancel?', 'a' => 'Cancellation charges depend on when you cancel. Before visa processing begins: full refund. After visa processing: $150 non-refundable. After ticket confirmation: $150 + airline charges. After ticket issuance: airline charges + $100/person. After departure: no refund. Written cancellation request required. See the full Terms & Cancellation Policy page.'],
                        ],
                    ],
                    [
                        'title' => 'Health & Families',
                        'faqs' => [
                            ['q' => 'Can elderly travellers or those with mobility issues join?', 'a' => 'Yes. Wheelchair assistance is available on request — indicate this during registration. The Arbaeen Walk is optional, so elderly and mobility-impaired travellers can participate in ziyarat by bus. Let us know of any special requirements so we can accommodate you.'],
                            ['q' => 'Are there any vaccination requirements?', 'a' => 'Pakistan and Iraq currently do not mandate specific vaccinations for Arbaeen pilgrims. However, travellers are responsible for their own health preparation. We recommend consulting your doctor, especially for elderly travellers or those with chronic conditions. Heat in Iraq in July/August can be extreme (40–50°C).'],
                            ['q' => 'Can women travel without a mahram?', 'a' => 'Women under 45 years of age are generally required by Iraqi immigration rules to travel with a mahram. Women 45 and above may travel with a group of organised pilgrims. Please verify the current rule at the time of registration as requirements may change. Contact us if unsure.'],
                        ],
                    ],
                ];
                @endphp

                @foreach($sections as $sIdx => $section)
                <div class="mb-5">
                    <h2 class="fw-700 text-maroon mb-4" style="font-size:1.05rem;letter-spacing:-0.01em">
                        {{ $section['title'] }}
                    </h2>
                    <div class="accordion faq-accordion" id="faqSection{{ $sIdx }}">
                        @foreach($section['faqs'] as $fIdx => $faq)
                        @php $collapseId = 'faq-' . $sIdx . '-' . $fIdx; @endphp
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="false"
                                        aria-controls="{{ $collapseId }}">
                                    {{ $faq['q'] }}
                                </button>
                            </h3>
                            <div id="{{ $collapseId }}"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#faqSection{{ $sIdx }}">
                                <div class="accordion-body" style="font-size:0.875rem;line-height:1.85;color:var(--zp-ink-soft)">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                {{-- Still have questions --}}
                <div class="p-4 p-md-5 rounded-4 text-center"
                     style="background: var(--zp-cream-warm); border: 1px solid rgba(201,169,97,0.3)">
                    <p class="fw-600 mb-2" style="font-size:0.95rem;color:var(--zp-ink)">Still have a question?</p>
                    <p class="text-muted mb-4" style="font-size:0.875rem">Our registration team is available via call or WhatsApp during office hours.</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary px-4">Contact Us</a>
                        <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode($whatsappMessage) }}"
                           class="btn text-white px-4" target="_blank" rel="noopener"
                           style="background:#25D366;border-color:#25D366">WhatsApp Us</a>
                        <a href="{{ route('register') }}" class="btn btn-orange px-4">Begin Registration &rarr;</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
