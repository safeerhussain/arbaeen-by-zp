<footer class="site-footer mt-auto pt-5 pb-0">
    <div class="container text-center pb-4">

        {{-- Brand --}}
        <div class="footer-brand mb-1" style="font-size: 1.1rem;">Arbaeen 2026</div>
        <p class="mb-4" style="font-size: 0.775rem; opacity: 0.45; letter-spacing: 0.04em;">
            Pakistan to Iraq &middot; 15 Days &middot; 14 Nights
        </p>

        {{-- Nav --}}
        <nav class="mb-4">
            <a href="{{ route('ar01') }}" class="footer-nav-link">AR01</a>
            <a href="{{ route('ar02') }}" class="footer-nav-link">AR02</a>
            <a href="{{ route('register') }}" class="footer-nav-link">Register</a>
            <a href="{{ route('status') }}" class="footer-nav-link">Status</a>
            <a href="{{ route('questions') }}" class="footer-nav-link">FAQs</a>
            <a href="{{ route('contact') }}" class="footer-nav-link">Contact</a>
        </nav>

        {{-- Social Icons --}}
        <div class="mb-4 d-flex justify-content-center gap-3">
            <a href="https://www.facebook.com/ZiaratPlanner/" target="_blank" rel="noopener" class="footer-social-icon" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/ziaratplanner/" target="_blank" rel="noopener" class="footer-social-icon" aria-label="Instagram">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
                </svg>
            </a>
            <a href="https://www.tiktok.com/@ziaratplanner" target="_blank" rel="noopener" class="footer-social-icon" aria-label="TikTok">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.19 8.19 0 0 0 4.79 1.53V6.77a4.85 4.85 0 0 1-1.02-.08z"/>
                </svg>
            </a>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="container text-center">
            <div class="mb-1" style="opacity: 0.4;">
                <a href="tel:+922132293244">+92 21 32293 244</a>
                <span class="mx-2">&middot;</span>
                <a href="tel:+922132293644">+92 21 32293 644</a>
            </div>
            <div>
                &copy; 2026 Ziarat Planner &nbsp;&middot;&nbsp;
                <a href="{{ route('terms') }}">Terms</a>
                &nbsp;&middot;&nbsp;
                Developed by <a href="https://digitaleggheads.com" target="_blank">Digital Eggheads</a>
            </div>
        </div>
    </div>
</footer>
