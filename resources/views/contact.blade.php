@extends('layouts.app')

@section('title', 'Contact Us — Arbaeen 2026')
@section('meta_description', 'Contact Bhojani Brothers Travel & Tour and Ziarat Planner for Arbaeen 2026 registration enquiries. Karachi office — call or WhatsApp.')

@section('content')

{{-- Page Header --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Contact Us</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.9rem">
            Call, WhatsApp, or visit us at the Karachi office
        </p>
    </div>
</section>

{{-- Team Contacts --}}
<section class="section-py" style="background: #fff;">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Registration Team</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Speak to Our Team</h2>
            <p class="text-muted mt-2" style="max-width: 460px; margin: 0.75rem auto 0; font-size: 0.875rem">
                For registration, payments, and booking queries — reach us directly via call or WhatsApp.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($contacts as $contact)
            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100 text-center">
                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:56px;height:56px;border-radius:50%;background:rgba(92,15,30,0.08)">
                        <span style="font-size:1.4rem">👤</span>
                    </div>
                    <h4 class="fw-700 mb-1" style="font-size:1rem;color:var(--zp-ink)">{{ $contact['name'] }}</h4>
                    <p class="mb-3" style="font-size:0.75rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--zp-orange)">
                        {{ $contact['role'] }}
                    </p>
                    <p class="mb-4">
                        <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                           class="fw-600 text-maroon" style="font-size:0.975rem;text-decoration:none">
                            {{ $contact['phone'] }}
                        </a>
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}"
                           class="btn btn-outline-primary flex-grow-1">
                            Call
                        </a>
                        <a href="https://wa.me/{{ $contact['wa'] }}?text={{ urlencode($whatsappMessage) }}"
                           class="btn flex-grow-1 text-white fw-600" target="_blank" rel="noopener"
                           style="background:#25D366;border-color:#25D366">
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- Office --}}
<section class="section-py bg-cream">
    <div class="container">

        <div class="text-center mb-5">
            <div class="section-tag mx-auto d-inline-flex">Office</div>
            <h2 class="display-6 fw-600 ls-tight mt-1">Visit Us in Karachi</h2>
        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">📍</div>
                    <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">Office Address</h4>
                    <address class="fst-normal text-muted mb-4" style="font-size:0.9rem;line-height:1.9">
                        Bhojani Brothers Travel &amp; Tour<br>
                        {{ $office['address'] }}
                    </address>
                    <p class="mb-0" style="font-size:0.78rem;color:var(--zp-ink-soft)">
                        Payments accepted in cash or via bank transfer. No online payment gateway available.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">☎️</div>
                    <h4 class="fw-700 mb-3" style="font-size: 0.95rem; color: var(--zp-ink)">Office Landlines</h4>
                    @foreach($office['landlines'] as $line)
                    <p class="mb-2">
                        <a href="tel:{{ str_replace(' ', '', $line) }}"
                           class="fw-600 text-maroon" style="font-size:0.975rem;text-decoration:none">
                            {{ $line }}
                        </a>
                    </p>
                    @endforeach
                    <p class="mt-3 mb-0 text-muted" style="font-size:0.8rem;line-height:1.65">
                        Office hours: Monday–Saturday, 10 am – 6 pm PKT.
                        For after-hours enquiries use WhatsApp.
                    </p>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="info-card h-100">
                    <div class="info-card-icon">💬</div>
                    <h4 class="fw-700 mb-2" style="font-size: 0.95rem; color: var(--zp-ink)">WhatsApp</h4>
                    <p class="text-muted mb-4" style="font-size: 0.825rem; line-height: 1.65">
                        Fastest way to reach us. Send your query anytime and we will respond during office hours.
                    </p>
                    <a href="https://wa.me/{{ ltrim(config('arbaeen.whatsapp.primary'), '+') }}?text={{ urlencode($whatsappMessage) }}"
                       class="btn text-white fw-600 w-100" target="_blank" rel="noopener"
                       style="background:#25D366;border-color:#25D366;padding:0.65rem">
                        {{ config('arbaeen.whatsapp.display') }} &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Quick Links --}}
<section class="section-py-sm" style="background: #fff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <p class="text-muted mb-4" style="font-size: 0.875rem">
                    Looking for something specific?
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    <a href="{{ route('ar01') }}" class="btn btn-outline-primary px-4">AR01 Package Details</a>
                    <a href="{{ route('ar02') }}" class="btn btn-outline-primary px-4">AR02 Package Details</a>
                    <a href="{{ route('payment-info') }}" class="btn btn-outline-primary px-4">Payment Info</a>
                    <a href="{{ route('questions') }}" class="btn btn-outline-primary px-4">FAQs</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-py-sm bg-maroon text-white text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <p class="mb-3" style="font-size: 0.875rem; opacity: 0.7">
                    Seats are limited to 135 zaireen per group. Register early to secure yours.
                </p>
                <a href="{{ route('register') }}" class="btn btn-orange px-5 py-3">
                    Begin Registration &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
