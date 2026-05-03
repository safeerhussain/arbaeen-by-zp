<footer class="site-footer mt-auto pt-5 pb-0">
    <div class="container pb-4">
        <div class="row g-5">

            {{-- Brand --}}
            <div class="col-lg-4">
                <div class="footer-brand mb-2">Arbaeen 2026</div>
                <p class="mb-3" style="font-size: 0.825rem; opacity: 0.55">Pakistan to Iraq &middot; 15 Days &middot; 14 Nights</p>
                <p class="mb-0" style="font-size: 0.825rem; line-height: 1.9">
                    A joint venture of<br>
                    <strong class="text-gold">Bhojani Brothers Travel & Tour</strong><br>
                    <span style="opacity:0.4">&times;</span>
                    <strong class="text-gold">Ziarat Planner</strong>
                </p>
                <p class="mt-3" style="font-size: 0.75rem; opacity: 0.35">
                    IATA Accredited Agent &middot; Ground Partner: Ziarat Planner, Iraq
                </p>
            </div>

            {{-- Packages --}}
            <div class="col-lg-2 col-6">
                <div class="footer-heading">Packages</div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('ar01') }}">AR01 &mdash; Arbaeen in Karbala</a></li>
                    <li class="mb-2"><a href="{{ route('ar02') }}">AR02 &mdash; Arbaeen + 28 Safar</a></li>
                    <li class="mb-2"><a href="{{ route('payment-info') }}">Payment Info</a></li>
                    <li><a href="{{ route('terms') }}">Terms &amp; Cancellation</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-6">
                <div class="footer-heading">Help</div>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('register') }}">Register</a></li>
                    <li class="mb-2"><a href="{{ route('status') }}">Check Booking Status</a></li>
                    <li class="mb-2"><a href="{{ route('questions') }}">FAQs</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4">
                <div class="footer-heading">Contact</div>
                <address class="mb-3 fst-normal" style="font-size: 0.825rem; opacity: 0.6; line-height: 1.8">
                    D1, Madni Heights, Soldier Bazar No.3<br>
                    Karachi, Pakistan
                </address>
                <ul class="list-unstyled mb-0">
                    @foreach(config('arbaeen.contacts') as $contact)
                    <li class="mb-2">
                        <span style="font-size:0.75rem; opacity:0.45">{{ $contact['name'] }}</span>
                        <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                           class="d-block">{{ $contact['phone'] }}</a>
                    </li>
                    @endforeach
                    <li class="mt-2">
                        <a href="tel:+922132293244">+92 21 32293 244</a>
                        <span style="opacity:0.3">&nbsp;&middot;&nbsp;</span>
                        <a href="tel:+922132293644">+92 21 32293 644</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <span>&copy; 2026 Ziarat Planner. All rights reserved. Developed by <a href="https://digitaleggheads.com" target="_blank">Digital Eggheads</a></span>
                <span class="mt-2 mt-md-0">
                    <a href="{{ route('terms') }}" class="me-3">Terms</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </span>
            </div>
        </div>
    </div>
</footer>
