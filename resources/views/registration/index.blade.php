@extends('layouts.app')

@section('title', 'Register — Arbaeen 2026')
@section('meta_description', 'Register for Arbaeen 2026. Secure your seat for AR01 (23 July) or AR02 (31 July) with a $150 deposit. Bhojani Brothers × Ziarat Planner.')

@section('content')

{{-- Hero --}}
<section class="hero-section section-py-sm" style="min-height: 28vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="hero-eyebrow">Arbaeen 2026 in Iraq</div>
        <h1 class="display-4 fw-300 text-white mb-2 ls-tight">Register for Arbaeen</h1>
        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem">
            $150 deposit per person secures your seat &mdash; pay at Bhojani Brothers office, Karachi
        </p>
    </div>
</section>

{{-- Main form --}}
<section class="section-py" style="background: var(--zp-cream-warm);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Validation errors --}}
                @if($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <p class="fw-600 mb-2" style="font-size:0.875rem">Please correct the following errors:</p>
                    <ul class="mb-0" style="font-size:0.825rem">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Step indicators --}}
                <div class="d-flex align-items-center mb-4 gap-2" id="step-indicators">
                    @foreach(['Trip Details', 'Lead Traveller', 'Family Members', 'Review & Submit'] as $i => $label)
                    <div class="step-indicator {{ $i === 0 ? 'active' : '' }}" data-step="{{ $i + 1 }}"
                         style="flex:1;text-align:center;padding:0.6rem 0.4rem;border-radius:0.5rem;font-size:0.7rem;font-weight:600;letter-spacing:0.04em;cursor:default;transition:all 0.2s;
                                {{ $i === 0 ? 'background:var(--zp-maroon);color:#fff;' : 'background:rgba(0,0,0,0.06);color:var(--zp-ink-soft);' }}">
                        <span class="d-none d-sm-inline">{{ $i + 1 }}. {{ $label }}</span>
                        <span class="d-inline d-sm-none">{{ $i + 1 }}</span>
                    </div>
                    @if($i < 3)
                    <div style="width:16px;height:2px;background:rgba(0,0,0,0.1);flex-shrink:0"></div>
                    @endif
                    @endforeach
                </div>

                <form method="POST" action="{{ route('register.store') }}" id="reg-form" enctype="multipart/form-data" novalidate>
                    @csrf

                    {{-- ==================== STEP 1: Trip Details ==================== --}}
                    <div class="form-step" id="step-1">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4 p-md-5">

                                <h2 class="fw-700 text-maroon mb-4" style="font-size:1.1rem">Step 1 — Trip Details</h2>

                                {{-- Group selection --}}
                                <div class="mb-4" data-validate-radio="group">
                                    <label class="form-label fw-600" style="font-size:0.875rem">Select Group <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        @foreach($groups as $code => $group)
                                        <div class="col-md-6">
                                            <label class="group-option-card d-block p-3 rounded-3 border cursor-pointer"
                                                   style="border-color:rgba(0,0,0,0.12)!important;transition:all 0.2s">
                                                <input type="radio" name="group" value="{{ $code }}" class="d-none group-radio"
                                                       {{ old('group', $selectedGroup) === $code ? 'checked' : '' }} required>
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <span class="fw-700" style="font-size:0.9rem;color:var(--zp-maroon)">{{ $code }}</span>
                                                    <span class="badge" style="background:rgba(92,15,30,0.1);color:var(--zp-maroon);font-size:0.65rem">
                                                        {{ $group['travel_dates'] }}
                                                    </span>
                                                </div>
                                                <p class="mb-0 fw-500" style="font-size:0.8rem;color:var(--zp-ink)">{{ $group['name'] }}</p>
                                                <p class="mb-0 text-muted" style="font-size:0.75rem">{{ $group['islamic_dates'] }}</p>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                    @error('group')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                </div>

                                {{-- Departure city --}}
                                <div class="mb-4" data-validate-radio="departure_city">
                                    <label class="form-label fw-600" style="font-size:0.875rem">Departure City <span class="text-danger">*</span></label>
                                    <div class="row g-2">
                                        @foreach(['karachi' => 'Karachi', 'lahore' => 'Lahore', 'islamabad' => 'Islamabad'] as $val => $label)
                                        <div class="col-4">
                                            <label class="city-radio-label d-block text-center p-2 rounded-2 border cursor-pointer"
                                                   style="border-color:rgba(0,0,0,0.12)!important;font-size:0.8rem;font-weight:500;transition:all 0.2s">
                                                <input type="radio" name="departure_city" value="{{ $val }}" class="d-none city-radio"
                                                       {{ old('departure_city', 'karachi') === $val ? 'checked' : '' }} required>
                                                {{ $label }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                    @error('departure_city')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                </div>

                                {{-- Package type --}}
                                <div class="mb-4" data-validate-radio="package_type">
                                    <label class="form-label fw-600" style="font-size:0.875rem">Package Type <span class="text-danger">*</span></label>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="pkg-radio-label d-block p-3 rounded-2 border cursor-pointer"
                                                   style="border-color:rgba(0,0,0,0.12)!important;transition:all 0.2s">
                                                <input type="radio" name="package_type" value="full" class="d-none pkg-radio"
                                                       {{ old('package_type', 'full') === 'full' ? 'checked' : '' }} required>
                                                <span class="fw-600 d-block" style="font-size:0.85rem;color:var(--zp-ink)">Full Package</span>
                                                <span class="text-muted" style="font-size:0.75rem">Airfare + visa + Iraq ground + hotels + meals</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="pkg-radio-label d-block p-3 rounded-2 border cursor-pointer"
                                                   style="border-color:rgba(0,0,0,0.12)!important;transition:all 0.2s">
                                                <input type="radio" name="package_type" value="ground_only" class="d-none pkg-radio"
                                                       {{ old('package_type') === 'ground_only' ? 'checked' : '' }} required>
                                                <span class="fw-600 d-block" style="font-size:0.85rem;color:var(--zp-ink)">Ground Only</span>
                                                <span class="text-muted" style="font-size:0.75rem">Iraq ground + hotels + meals only (no airfare & visa)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                    @error('package_type')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                </div>

                                {{-- Campaign discount --}}
                                <div class="mb-4">
                                    <div class="p-3 rounded-3" style="background:rgba(201,169,97,0.1);border:1px solid rgba(201,169,97,0.3)">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="campaign_discount" value="1"
                                                   id="campaign_discount" {{ old('campaign_discount') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-600" for="campaign_discount" style="font-size:0.875rem;color:var(--zp-ink)">
                                                I completed the {{ $campaignDiscount['label'] }}
                                            </label>
                                            <p class="mb-0 text-muted mt-1" style="font-size:0.78rem">
                                                PKR {{ number_format($campaignDiscount['amount']) }} discount applies. Verification required at the office.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Heard about us --}}
                                <div class="mb-4">
                                    <label class="form-label fw-600" for="heard_about_us" style="font-size:0.875rem">How did you hear about us?</label>
                                    <select class="form-select" name="heard_about_us" id="heard_about_us" style="font-size:0.875rem">
                                        <option value="">— Select (optional) —</option>
                                        @foreach(['whatsapp' => 'WhatsApp', 'instagram' => 'Instagram', 'friend' => 'Friend / Family', 'masjid' => 'Masjid / Community', 'other' => 'Other'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('heard_about_us') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-orange px-5" onclick="nextStep(1)">
                                        Continue: Lead Traveller &rarr;
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ==================== STEP 2: Lead Traveller ==================== --}}
                    <div class="form-step d-none" id="step-2">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4 p-md-5">

                                <h2 class="fw-700 text-maroon mb-1" style="font-size:1.1rem">Step 2 — Lead Traveller</h2>
                                <p class="text-muted mb-4" style="font-size:0.8rem">The lead traveller is the main contact. Their details are used for all communications.</p>

                                {{-- Personal Info --}}
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="persons[0][full_name]" class="form-control" placeholder="As on passport"
                                               value="{{ old('persons.0.full_name') }}" required
                                               data-validate="required" data-label="Full Name">
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.full_name')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Father's Name</label>
                                        <input type="text" name="persons[0][fathers_name]" class="form-control" placeholder="Optional"
                                               value="{{ old('persons.0.fathers_name') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Gender <span class="text-danger">*</span></label>
                                        <select name="persons[0][gender]" class="form-select" required
                                                data-validate="required" data-label="Gender">
                                            <option value="">Select</option>
                                            <option value="male" {{ old('persons.0.gender') === 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('persons.0.gender') === 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.gender')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" name="persons[0][date_of_birth]" class="form-control"
                                               value="{{ old('persons.0.date_of_birth') }}" required
                                               max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                               data-validate="required" data-label="Date of Birth">
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.date_of_birth')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Passenger Type <span class="text-danger">*</span></label>
                                        <select name="persons[0][passenger_type]" class="form-select" required
                                                data-validate="required" data-label="Passenger Type">
                                            @foreach($passengerTypes as $key => $type)
                                            <option value="{{ $key }}" {{ old('persons.0.passenger_type', 'adult') === $key ? 'selected' : '' }}>{{ $type['label'] }}</option>
                                            @endforeach
                                        </select>
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <p class="fw-600 mb-3" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Passport Details</p>

                                {{-- Passport expiry --}}
                                <div class="passport-expiry-wrapper mb-3">
                                    <label class="form-label fw-500" style="font-size:0.85rem">Passport Expiry Date <span class="text-muted fw-400">(optional)</span></label>
                                    <input type="date" name="persons[0][passport_expiry]" class="form-control"
                                           value="{{ old('persons.0.passport_expiry') }}"
                                           data-validate="passport-expiry">
                                    <div class="passport-expiry-status mt-1"></div>
                                    <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                    @error('persons.0.passport_expiry')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror

                                    {{-- Renewal warning + confirmation --}}
                                    <div class="passport-renewal-block d-none mt-3 p-3 rounded-3"
                                         style="background:rgba(220,53,69,0.06);border:1px solid rgba(220,53,69,0.25)">
                                        <p class="renewal-warning-text mb-2" style="font-size:0.82rem;color:var(--bs-danger)"></p>
                                        <div class="form-check">
                                            <input class="form-check-input passport-renewal-confirm" type="checkbox"
                                                   name="persons[0][passport_renewal_confirmed]" value="1"
                                                   id="renewal_confirm_0">
                                            <label class="form-check-label" for="renewal_confirm_0" style="font-size:0.82rem">
                                                I confirm I will apply for a new passport and submit it before visa processing.
                                            </label>
                                        </div>
                                        <div class="renewal-confirm-error text-danger mt-1" style="font-size:0.78rem;display:none">
                                            You must confirm passport renewal to proceed.
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <p class="fw-600 mb-3" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Contact Information</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="tel" name="persons[0][mobile]" class="form-control" placeholder="03XX XXXXXXX"
                                               value="{{ old('persons.0.mobile') }}" required
                                               data-validate="required" data-label="Mobile Number">
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.mobile')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Alternate Mobile</label>
                                        <input type="tel" name="persons[0][alternate_mobile]" class="form-control" placeholder="Optional"
                                               value="{{ old('persons.0.alternate_mobile') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="persons[0][email]" class="form-control" placeholder="For booking confirmation"
                                               value="{{ old('persons.0.email') }}" required
                                               data-validate="email" data-label="Email Address">
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.email')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">City <span class="text-danger">*</span></label>
                                        <input type="text" name="persons[0][city]" class="form-control" placeholder="e.g. Karachi"
                                               value="{{ old('persons.0.city') }}" required
                                               data-validate="required" data-label="City">
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.city')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4">
                                <p class="fw-600 mb-1" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Documents</p>
                                <p class="text-muted mb-3" style="font-size:0.78rem">Upload clear scans. Files are stored securely and used only for visa processing.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">
                                            Passport Scan <span class="text-danger">*</span>
                                            <span class="text-muted fw-400"> (first page with photo)</span>
                                        </label>
                                        <input type="file" name="persons[0][passport_scan]" class="form-control"
                                               accept=".jpg,.jpeg,.png,.pdf"
                                               data-validate="file" data-label="Passport Scan"
                                               data-accept="jpg,jpeg,png,pdf" data-maxsize="5242880">
                                        <div class="form-text">JPG, PNG or PDF · Max 5 MB</div>
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.passport_scan')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-500" style="font-size:0.85rem">
                                            Passport-Size Photo <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="persons[0][passport_photo]" class="form-control"
                                               accept=".jpg,.jpeg,.png"
                                               data-validate="file" data-label="Passport Photo"
                                               data-accept="jpg,jpeg,png" data-maxsize="3145728">
                                        <div class="form-text">JPG or PNG · Max 3 MB</div>
                                        <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                                        @error('persons.0.passport_photo')<div class="text-danger mt-1" style="font-size:0.8rem">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <hr class="my-4">
                                <p class="fw-600 mb-3" style="font-size:0.8rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Additional Information</p>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="persons[0][wheelchair_required]" value="1"
                                                   id="wheelchair" {{ old('persons.0.wheelchair_required') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="wheelchair" style="font-size:0.85rem">
                                                Wheelchair assistance required
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-500" style="font-size:0.85rem">Medical Notes</label>
                                        <textarea name="persons[0][medical_notes]" class="form-control" rows="2"
                                                  placeholder="Any relevant health information we should know (optional)" style="font-size:0.85rem">{{ old('persons.0.medical_notes') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="previous_arbaeen" value="1"
                                                   id="previous_arbaeen" {{ old('previous_arbaeen') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="previous_arbaeen" style="font-size:0.85rem">
                                                I have previously attended Arbaeen Ziyarat
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary px-4" onclick="goStep(1)">&larr; Back</button>
                                    <button type="button" class="btn btn-orange px-5" onclick="nextStep(2)">
                                        Continue: Family Members &rarr;
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ==================== STEP 3: Family Members ==================== --}}
                    <div class="form-step d-none" id="step-3">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4 p-md-5">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h2 class="fw-700 text-maroon mb-0" style="font-size:1.1rem">Step 3 — Family Members</h2>
                                    <span id="member-count-badge" class="badge"
                                          style="background:rgba(92,15,30,0.1);color:var(--zp-maroon);font-size:0.7rem">
                                        0 added
                                    </span>
                                </div>
                                <p class="text-muted mb-4" style="font-size:0.8rem">
                                    Add up to {{ $maxFamily - 1 }} additional travellers. Skip this step if travelling alone.
                                </p>

                                <div id="members-container"></div>

                                <button type="button" class="btn btn-outline-primary w-100 py-3" id="add-member-btn"
                                        style="border-style:dashed">
                                    + Add Family Member / Travelling Companion
                                </button>

                                <div class="d-flex gap-2 justify-content-between mt-4">
                                    <button type="button" class="btn btn-outline-secondary px-4" onclick="goStep(2)">&larr; Back</button>
                                    <button type="button" class="btn btn-orange px-5" onclick="nextStep(3)">
                                        Continue: Review &amp; Submit &rarr;
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ==================== STEP 4: Review & Submit ==================== --}}
                    <div class="form-step d-none" id="step-4">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4 p-md-5">

                                <h2 class="fw-700 text-maroon mb-4" style="font-size:1.1rem">Step 4 — Review &amp; Submit</h2>

                                {{-- Dynamic summary --}}
                                <div id="review-summary" class="mb-4"></div>

                                {{-- Terms + consent --}}
                                <div class="mb-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="agree_terms" value="1"
                                               id="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required>
                                        <label class="form-check-label fw-600" for="agree_terms" style="font-size:0.875rem">
                                            I have read and agree to the
                                            <a href="{{ route('terms') }}" target="_blank" class="text-maroon">Terms &amp; Cancellation Policy</a>
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="public_feed_consent" value="1"
                                               id="public_feed_consent" {{ old('public_feed_consent') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="public_feed_consent" style="font-size:0.875rem">
                                            Allow my first name and city to appear in the public registrations feed on the home page
                                        </label>
                                    </div>
                                </div>

                                <div class="p-3 rounded-3 mb-4"
                                     style="background:rgba(232,101,31,0.07);border:1px solid rgba(232,101,31,0.2)">
                                    <p class="fw-600 mb-1" style="font-size:0.875rem;color:var(--zp-ink)">Next Step After Submitting</p>
                                    <p class="mb-0 text-muted" style="font-size:0.825rem;line-height:1.7">
                                        You will receive a booking reference number. Visit the Bhojani Brothers office
                                        and pay the Stage 1 deposit ($150 per person) to confirm your seat.
                                        <a href="{{ route('contact') }}" class="text-maroon fw-500">Office details &rarr;</a>
                                    </p>
                                </div>

                                @error('agree_terms')
                                <div class="alert alert-danger" style="font-size:0.85rem">{{ $message }}</div>
                                @enderror

                                <div class="d-flex gap-2 justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary px-4" onclick="goStep(3)">&larr; Back</button>
                                    <button type="submit" class="btn btn-orange px-5 py-3 fw-700" style="font-size:1rem">
                                        Submit Registration &rarr;
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>

                {{-- Member row template (hidden, not submitted) --}}
                <template id="member-template">
                    <div class="member-row border rounded-3 p-3 mb-3 bg-white position-relative">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-member-btn position-absolute"
                                style="top:0.75rem;right:0.75rem;padding:0.2rem 0.5rem;font-size:0.7rem"
                                onclick="removeMember(this)">Remove</button>
                        <p class="fw-600 text-maroon mb-3" style="font-size:0.85rem" id="member-title-__IDX__">Traveller __POS__</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="persons[__IDX__][full_name]" class="form-control form-control-sm"
                                       placeholder="As on passport" required
                                       data-validate="required" data-label="Full Name">
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Father's Name</label>
                                <input type="text" name="persons[__IDX__][fathers_name]" class="form-control form-control-sm" placeholder="Optional">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Gender <span class="text-danger">*</span></label>
                                <select name="persons[__IDX__][gender]" class="form-select form-select-sm" required
                                        data-validate="required" data-label="Gender">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" name="persons[__IDX__][date_of_birth]" class="form-control form-control-sm"
                                       required max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                       data-validate="required" data-label="Date of Birth">
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Passenger Type <span class="text-danger">*</span></label>
                                <select name="persons[__IDX__][passenger_type]" class="form-select form-select-sm" required
                                        data-validate="required" data-label="Passenger Type">
                                    @foreach($passengerTypes as $key => $type)
                                    <option value="{{ $key }}">{{ $type['label'] }}</option>
                                    @endforeach
                                </select>
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">Relationship to Lead <span class="text-danger">*</span></label>
                                <select name="persons[__IDX__][relationship]" class="form-select form-select-sm" required
                                        data-validate="required" data-label="Relationship">
                                    <option value="">Select</option>
                                    <option value="spouse">Spouse</option>
                                    <option value="son">Son</option>
                                    <option value="daughter">Daughter</option>
                                    <option value="parent">Parent</option>
                                    <option value="sibling">Sibling</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <p class="fw-600 mb-2" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Passport Details</p>

                        <div class="passport-expiry-wrapper">
                            <label class="form-label" style="font-size:0.82rem;font-weight:500">Passport Expiry Date <span class="text-muted fw-400">(optional)</span></label>
                            <input type="date" name="persons[__IDX__][passport_expiry]" class="form-control form-control-sm"
                                   data-validate="passport-expiry">
                            <div class="passport-expiry-status mt-1"></div>
                            <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>

                            <div class="passport-renewal-block d-none mt-3 p-3 rounded-3"
                                 style="background:rgba(220,53,69,0.06);border:1px solid rgba(220,53,69,0.25)">
                                <p class="renewal-warning-text mb-2" style="font-size:0.82rem;color:var(--bs-danger)"></p>
                                <div class="form-check">
                                    <input class="form-check-input passport-renewal-confirm" type="checkbox"
                                           name="persons[__IDX__][passport_renewal_confirmed]" value="1"
                                           id="renewal_confirm___IDX__">
                                    <label class="form-check-label" for="renewal_confirm___IDX__" style="font-size:0.82rem">
                                        I confirm I will apply for a new passport and submit it before visa processing.
                                    </label>
                                </div>
                                <div class="renewal-confirm-error text-danger mt-1" style="font-size:0.78rem;display:none">
                                    You must confirm passport renewal to proceed.
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <p class="fw-600 mb-2" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:0.06em;color:var(--zp-maroon)">Documents</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">
                                    Passport Scan <span class="text-danger">*</span>
                                    <span class="text-muted fw-400"> (first page with photo)</span>
                                </label>
                                <input type="file" name="persons[__IDX__][passport_scan]" class="form-control form-control-sm"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       data-validate="file" data-label="Passport Scan"
                                       data-accept="jpg,jpeg,png,pdf" data-maxsize="5242880">
                                <div class="form-text" style="font-size:0.75rem">JPG, PNG or PDF · Max 5 MB</div>
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-size:0.82rem;font-weight:500">
                                    Passport-Size Photo <span class="text-danger">*</span>
                                </label>
                                <input type="file" name="persons[__IDX__][passport_photo]" class="form-control form-control-sm"
                                       accept=".jpg,.jpeg,.png"
                                       data-validate="file" data-label="Passport Photo"
                                       data-accept="jpg,jpeg,png" data-maxsize="3145728">
                                <div class="form-text" style="font-size:0.75rem">JPG or PNG · Max 3 MB</div>
                                <div class="field-feedback text-danger mt-1" style="font-size:0.8rem;display:none"></div>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* Radio card base */
.group-option-card,
.pkg-radio-label,
.city-radio-label { position: relative; }

.group-option-card::after,
.pkg-radio-label::after,
.city-radio-label::after {
    content: '';
    position: absolute;
    bottom: 0.55rem; right: 0.6rem;
    width: 20px; height: 20px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,0.15);
    background: #fff;
    transition: all 0.2s;
    text-align: center;
    line-height: 16px;
    font-size: 0.65rem;
    font-weight: 900;
    color: transparent;
}

.group-option-card:has(.group-radio:checked) {
    border-color: var(--zp-maroon) !important;
    background: rgba(92,15,30,0.05);
    box-shadow: 0 0 0 2px var(--zp-maroon);
}
.group-option-card:has(.group-radio:checked)::after {
    content: '✓';
    background: var(--zp-maroon);
    border-color: var(--zp-maroon);
    color: #fff;
}

.pkg-radio-label:has(.pkg-radio:checked) {
    border-color: var(--zp-maroon) !important;
    background: rgba(92,15,30,0.05);
    box-shadow: 0 0 0 2px var(--zp-maroon);
}
.pkg-radio-label:has(.pkg-radio:checked)::after {
    content: '✓';
    background: var(--zp-maroon);
    border-color: var(--zp-maroon);
    color: #fff;
}

.city-radio-label:has(.city-radio:checked) {
    border-color: var(--zp-maroon) !important;
    background: rgba(92,15,30,0.05);
    color: var(--zp-maroon);
    font-weight: 700;
    box-shadow: 0 0 0 2px var(--zp-maroon);
}
.city-radio-label:has(.city-radio:checked)::after {
    content: '✓';
    background: var(--zp-maroon);
    border-color: var(--zp-maroon);
    color: #fff;
}

.cursor-pointer { cursor: pointer; }

/* Review table */
.review-section-title {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--zp-maroon);
    padding: 0.5rem 0 0.25rem;
    border-bottom: 1px solid rgba(92,15,30,0.12);
    margin-bottom: 0.25rem;
}
</style>
@endpush

@push('scripts')
<script>
(function () {
    var currentStep = 1;
    var memberCount = 0;
    var maxMembers = {{ $maxFamily - 1 }};

    var passportMinDates = {
        'AR01': '2027-02-06',
        'AR02': '2027-02-14'
    };
    var passportMinDateLabels = {
        'AR01': '6 February 2027',
        'AR02': '14 February 2027'
    };

    var pricingConfig = @json(config('arbaeen.pricing'));
    var passengerTypeLabels = @json(array_map(fn($t) => $t['label'], config('arbaeen.passenger_types')));

    // ── Helpers ──────────────────────────────────────────────────────────────

    function getSelectedGroup() {
        var el = document.querySelector('input[name="group"]:checked');
        return el ? el.value : null;
    }

    function getFeedback(input) {
        return input.parentElement.querySelector('.field-feedback');
    }

    function showError(input, msg) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        var fb = getFeedback(input);
        if (fb) { fb.textContent = msg; fb.style.display = 'block'; }
    }

    function showValid(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        var fb = getFeedback(input);
        if (fb) fb.style.display = 'none';
    }

    function clearState(input) {
        input.classList.remove('is-invalid', 'is-valid');
        var fb = getFeedback(input);
        if (fb) fb.style.display = 'none';
    }

    // ── Field validators ─────────────────────────────────────────────────────

    function validateRequired(input) {
        var label = input.dataset.label || 'This field';
        if (!input.value.trim()) {
            showError(input, label + ' is required.');
            return false;
        }
        if (input.type === 'date' && input.max && input.value > input.max) {
            showError(input, label + ' cannot be a future date.');
            return false;
        }
        showValid(input);
        return true;
    }

    function validateEmail(input) {
        var label = input.dataset.label || 'Email';
        var val = input.value.trim();
        if (!val) {
            showError(input, label + ' is required.');
            return false;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
            showError(input, 'Please enter a valid email address.');
            return false;
        }
        showValid(input);
        return true;
    }

    function validatePassportExpiry(input) {
        var value = input.value;
        var wrapper = input.closest('.passport-expiry-wrapper');
        var statusEl = wrapper ? wrapper.querySelector('.passport-expiry-status') : null;
        var renewalBlock = wrapper ? wrapper.querySelector('.passport-renewal-block') : null;
        var group = getSelectedGroup();

        if (!value) {
            clearState(input);
            if (statusEl) statusEl.innerHTML = '';
            if (renewalBlock) renewalBlock.classList.add('d-none');
            return true;
        }

        var expiryDate = new Date(value + 'T00:00:00');
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (expiryDate <= today) {
            if (statusEl) statusEl.innerHTML = '';
            if (renewalBlock) {
                renewalBlock.classList.remove('d-none');
                renewalBlock.querySelector('.renewal-warning-text').innerHTML =
                    '&#9888;&#65039; Your passport has already expired. You must apply for a new passport before visa processing can begin.';
            }
            var confirmed = checkRenewalConfirmed(wrapper);
            if (confirmed) {
                input.classList.remove('is-invalid');
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            }
            return confirmed;
        }

        if (group && passportMinDates[group]) {
            var minDate = new Date(passportMinDates[group] + 'T00:00:00');
            if (expiryDate < minDate) {
                if (statusEl) statusEl.innerHTML = '';
                if (renewalBlock) {
                    renewalBlock.classList.remove('d-none');
                    renewalBlock.querySelector('.renewal-warning-text').innerHTML =
                        '&#9888;&#65039; Your passport must be valid until <strong>' + passportMinDateLabels[group] +
                        '</strong> for this group. Please apply for a new passport before visa processing can begin.';
                }
                var confirmed = checkRenewalConfirmed(wrapper);
                if (confirmed) {
                    input.classList.remove('is-invalid');
                } else {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                }
                return confirmed;
            }
            // Valid
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (statusEl) {
                statusEl.innerHTML = '<span style="font-size:0.77rem;color:#198754">&#10003; Valid — expires beyond the required date (' + passportMinDateLabels[group] + ')</span>';
            }
            if (renewalBlock) renewalBlock.classList.add('d-none');
            return true;
        }

        // No group selected yet
        clearState(input);
        if (statusEl) {
            statusEl.innerHTML = '<span style="font-size:0.77rem;color:#6c757d">Select a group in Step 1 to validate expiry.</span>';
        }
        if (renewalBlock) renewalBlock.classList.add('d-none');
        return true;
    }

    function checkRenewalConfirmed(wrapper) {
        if (!wrapper) return false;
        var cb = wrapper.querySelector('.passport-renewal-confirm');
        var errorEl = wrapper.querySelector('.renewal-confirm-error');
        if (cb && cb.checked) {
            if (errorEl) errorEl.style.display = 'none';
            return true;
        }
        if (errorEl) errorEl.style.display = 'block';
        return false;
    }

    function validateFileInput(input) {
        var label = input.dataset.label || 'File';
        var allowedExts = (input.dataset.accept || '').split(',').map(function (t) { return t.trim().toLowerCase(); });
        var maxSize = parseInt(input.dataset.maxsize || '5242880', 10);

        if (!input.files || !input.files.length) {
            showError(input, label + ' is required.');
            return false;
        }

        var file = input.files[0];
        var ext = file.name.split('.').pop().toLowerCase();

        if (allowedExts.length && !allowedExts.includes(ext)) {
            showError(input, 'Allowed formats: ' + allowedExts.map(function (e) { return e.toUpperCase(); }).join(', '));
            return false;
        }

        if (file.size > maxSize) {
            showError(input, 'File too large. Max ' + Math.round(maxSize / 1048576) + ' MB allowed.');
            return false;
        }

        showValid(input);
        return true;
    }

    // ── Step validation ───────────────────────────────────────────────────────

    function validateStep(stepNum) {
        var stepEl = document.getElementById('step-' + stepNum);
        if (!stepEl) return true;
        var valid = true;
        var firstInvalid = null;

        stepEl.querySelectorAll('[data-validate="required"]').forEach(function (input) {
            if (!validateRequired(input) && !firstInvalid) firstInvalid = input;
            if (input.classList.contains('is-invalid')) valid = false;
        });

        stepEl.querySelectorAll('[data-validate="email"]').forEach(function (input) {
            if (!validateEmail(input) && !firstInvalid) firstInvalid = input;
            if (input.classList.contains('is-invalid')) valid = false;
        });

        stepEl.querySelectorAll('[data-validate="passport-expiry"]').forEach(function (input) {
            if (!validatePassportExpiry(input) && !firstInvalid) firstInvalid = input;
            if (input.classList.contains('is-invalid')) valid = false;
        });

        stepEl.querySelectorAll('[data-validate="file"]').forEach(function (input) {
            if (!validateFileInput(input) && !firstInvalid) firstInvalid = input;
            if (input.classList.contains('is-invalid')) valid = false;
        });

        // Radio groups
        stepEl.querySelectorAll('[data-validate-radio]').forEach(function (wrapper) {
            var name = wrapper.dataset.validateRadio;
            var checked = document.querySelector('input[name="' + name + '"]:checked');
            var fb = wrapper.querySelector('.field-feedback');
            if (!checked) {
                if (fb) { fb.textContent = 'Please select an option.'; fb.style.display = 'block'; }
                if (!firstInvalid) firstInvalid = wrapper;
                valid = false;
            } else {
                if (fb) fb.style.display = 'none';
            }
        });

        if (!valid && firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return valid;
    }

    // ── Passenger type auto-select from DOB ──────────────────────────────────

    var AGE_CUTOFF_DATE = new Date('2026-08-14T00:00:00');

    function ageOnCutoff(dob) {
        var age = AGE_CUTOFF_DATE.getFullYear() - dob.getFullYear();
        var m = AGE_CUTOFF_DATE.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && AGE_CUTOFF_DATE.getDate() < dob.getDate())) { age--; }
        return age;
    }

    function applyPassengerTypeFromDOB(dobInput, typeSelect) {
        var options = typeSelect.querySelectorAll('option');

        if (!dobInput.value) {
            options.forEach(function (opt) { opt.disabled = false; });
            return;
        }

        var age = ageOnCutoff(new Date(dobInput.value + 'T00:00:00'));

        if (age < 2) {
            options.forEach(function (opt) { opt.disabled = opt.value !== 'infant'; });
            typeSelect.value = 'infant';
        } else if (age < 12) {
            options.forEach(function (opt) {
                opt.disabled = opt.value !== 'child_with_bed' && opt.value !== 'child_without_bed';
            });
            if (typeSelect.value !== 'child_with_bed' && typeSelect.value !== 'child_without_bed') {
                typeSelect.value = 'child_with_bed';
            }
        } else {
            options.forEach(function (opt) { opt.disabled = opt.value !== 'adult'; });
            typeSelect.value = 'adult';
        }
    }

    // ── Real-time listeners (added per element) ───────────────────────────────

    function attachRealTime(container) {
        // DOB → passenger type auto-select
        var dobInput = container.querySelector('[name$="[date_of_birth]"]');
        var typeSelect = container.querySelector('[name$="[passenger_type]"]');
        if (dobInput && typeSelect) {
            dobInput.addEventListener('change', function () {
                applyPassengerTypeFromDOB(dobInput, typeSelect);
            });
            if (dobInput.value) {
                applyPassengerTypeFromDOB(dobInput, typeSelect);
            }
        }

        container.querySelectorAll('[data-validate="required"]').forEach(function (input) {
            input.addEventListener('blur', function () { validateRequired(input); });
            input.addEventListener('change', function () { if (input.classList.contains('is-invalid')) validateRequired(input); });
        });

        container.querySelectorAll('[data-validate="email"]').forEach(function (input) {
            input.addEventListener('blur', function () { validateEmail(input); });
            input.addEventListener('input', function () { if (input.classList.contains('is-invalid')) validateEmail(input); });
        });

        container.querySelectorAll('[data-validate="passport-expiry"]').forEach(function (input) {
            input.addEventListener('change', function () { validatePassportExpiry(input); });
            // Re-validate when group changes
            document.querySelectorAll('input[name="group"]').forEach(function (radio) {
                radio.addEventListener('change', function () {
                    if (input.value) validatePassportExpiry(input);
                });
            });
        });

        container.querySelectorAll('[data-validate="file"]').forEach(function (input) {
            input.addEventListener('change', function () { validateFileInput(input); });
        });

        // Renewal confirmation checkboxes
        container.querySelectorAll('.passport-renewal-confirm').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var wrapper = cb.closest('.passport-expiry-wrapper');
                var expiryInput = wrapper ? wrapper.querySelector('[data-validate="passport-expiry"]') : null;
                if (expiryInput && expiryInput.value) {
                    validatePassportExpiry(expiryInput);
                } else {
                    var errorEl = wrapper ? wrapper.querySelector('.renewal-confirm-error') : null;
                    if (errorEl) errorEl.style.display = cb.checked ? 'none' : 'block';
                }
            });
        });
    }

    // Attach to step 2 on page load
    attachRealTime(document.getElementById('step-2'));

    // ── Navigation ────────────────────────────────────────────────────────────

    function updateIndicators() {
        document.querySelectorAll('.step-indicator').forEach(function (el) {
            var s = parseInt(el.dataset.step, 10);
            if (s === currentStep) {
                el.style.background = 'var(--zp-maroon)';
                el.style.color = '#fff';
            } else if (s < currentStep) {
                el.style.background = 'rgba(92,15,30,0.12)';
                el.style.color = 'var(--zp-maroon)';
            } else {
                el.style.background = 'rgba(0,0,0,0.06)';
                el.style.color = 'var(--zp-ink-soft)';
            }
        });
    }

    function showStep(n) {
        document.querySelectorAll('.form-step').forEach(function (el) {
            el.classList.add('d-none');
        });
        var el = document.getElementById('step-' + n);
        if (el) el.classList.remove('d-none');
        currentStep = n;
        updateIndicators();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    window.goStep = showStep;

    window.nextStep = function (from) {
        if (!validateStep(from)) return;
        showStep(from + 1);
        if (from + 1 === 4) buildReview();
    };

    // ── Review builder ────────────────────────────────────────────────────────

    function val(name) {
        var el = document.querySelector('[name="' + name + '"]');
        return el ? (el.value || '—') : '—';
    }

    function checkedVal(name) {
        var el = document.querySelector('input[name="' + name + '"]:checked');
        return el ? el.value : '—';
    }

    function fileVal(name) {
        var el = document.querySelector('[name="' + name + '"]');
        if (!el || !el.files || !el.files.length) return '<span class="text-danger" style="font-size:0.8rem">Not uploaded</span>';
        return '<span class="text-success" style="font-size:0.8rem">&#10003; ' + el.files[0].name + '</span>';
    }

    function row(label, value) {
        return '<tr><td class="text-muted pe-3" style="width:42%;font-size:0.82rem;vertical-align:top;padding:0.3rem 0">' + label + '</td>'
             + '<td class="fw-500" style="font-size:0.82rem;padding:0.3rem 0">' + value + '</td></tr>';
    }

    function sectionTitle(title) {
        return '<tr><td colspan="2" class="review-section-title pt-3">' + title + '</td></tr>';
    }

    function buildCostSummary(pkg, city, memberRows) {
        var pricingKey = (pkg === 'ground_only') ? 'ground_only' : city;
        var prices = pricingConfig[pricingKey] || pricingConfig['karachi'];

        var travelers = [];

        // Lead traveller
        var leadName = document.querySelector('[name="persons[0][full_name]"]');
        var leadType = document.querySelector('[name="persons[0][passenger_type]"]');
        travelers.push({
            name: (leadName && leadName.value) ? leadName.value : 'Lead Traveller',
            type: (leadType && leadType.value) ? leadType.value : 'adult',
        });

        // Family members
        memberRows.forEach(function (rowEl, i) {
            var idx = i + 1;
            var nameEl = rowEl.querySelector('[name="persons[' + idx + '][full_name]"]');
            var typeEl = rowEl.querySelector('[name="persons[' + idx + '][passenger_type]"]');
            travelers.push({
                name: (nameEl && nameEl.value) ? nameEl.value : ('Traveller ' + (idx + 1)),
                type: (typeEl && typeEl.value) ? typeEl.value : 'adult',
            });
        });

        var grandTotal = 0;
        var rows = '';
        travelers.forEach(function (t, i) {
            var price = prices[t.type] || 0;
            grandTotal += price;
            var typeLabel = passengerTypeLabels[t.type] || t.type;
            var pos = i === 0 ? 'Lead' : 'Traveller ' + (i + 1);
            rows += '<tr>';
            rows += '<td style="font-size:0.82rem;padding:0.35rem 0.5rem">' + pos + '</td>';
            rows += '<td style="font-size:0.82rem;padding:0.35rem 0.5rem" class="text-muted">' + t.name + '</td>';
            rows += '<td style="font-size:0.82rem;padding:0.35rem 0.5rem" class="text-muted">' + typeLabel + '</td>';
            rows += '<td style="font-size:0.82rem;padding:0.35rem 0.5rem;text-align:right" class="fw-500">$' + price.toLocaleString() + '</td>';
            rows += '</tr>';
        });

        var pkgLabel = (pkg === 'ground_only') ? 'Ground Only' : 'Full Package (' + (city.charAt(0).toUpperCase() + city.slice(1)) + ')';

        var html = '<div class="mb-4 rounded-3 overflow-hidden" style="border:1.5px solid rgba(92,15,30,0.18)">';
        html += '<div class="px-3 py-2 fw-700" style="background:rgba(92,15,30,0.07);font-size:0.78rem;text-transform:uppercase;letter-spacing:0.07em;color:var(--zp-maroon)">Cost Breakdown &mdash; ' + pkgLabel + '</div>';
        html += '<div class="px-1">';
        html += '<table class="table table-borderless mb-0"><thead>';
        html += '<tr style="border-bottom:1px solid rgba(0,0,0,0.07)">';
        html += '<th style="font-size:0.75rem;font-weight:600;padding:0.4rem 0.5rem;color:#666">#</th>';
        html += '<th style="font-size:0.75rem;font-weight:600;padding:0.4rem 0.5rem;color:#666">Name</th>';
        html += '<th style="font-size:0.75rem;font-weight:600;padding:0.4rem 0.5rem;color:#666">Type</th>';
        html += '<th style="font-size:0.75rem;font-weight:600;padding:0.4rem 0.5rem;color:#666;text-align:right">Price (USD)</th>';
        html += '</tr></thead><tbody>' + rows;
        html += '<tr style="border-top:2px solid rgba(92,15,30,0.15)">';
        html += '<td colspan="3" class="fw-700 text-maroon" style="font-size:0.875rem;padding:0.5rem 0.5rem">Total</td>';
        html += '<td class="fw-700 text-maroon" style="font-size:0.875rem;padding:0.5rem 0.5rem;text-align:right">$' + grandTotal.toLocaleString() + '</td>';
        html += '</tr>';
        html += '</tbody></table></div>';
        html += '<div class="px-3 py-2" style="background:rgba(232,101,31,0.06);border-top:1px solid rgba(232,101,31,0.15);font-size:0.775rem;color:#666">';
        html += 'Stage 1 deposit <strong>$150 per person</strong> due at Bhojani Brothers office to confirm your seat.';
        html += '</div>';
        html += '</div>';

        return html;
    }

    function buildReview() {
        var group = checkedVal('group');
        var city = checkedVal('departure_city');
        var pkg = checkedVal('package_type');
        var memberRows = document.querySelectorAll('#members-container .member-row');
        var totalPersons = 1 + memberRows.length;

        var html = buildCostSummary(pkg, city, memberRows);

        html += '<div class="p-3 rounded-3" style="background:rgba(92,15,30,0.03);border:1px solid rgba(92,15,30,0.1)">';
        html += '<table class="table table-borderless mb-0"><tbody>';

        // Trip
        html += sectionTitle('Trip Details');
        html += row('Group', group);
        html += row('Departure City', city.charAt(0).toUpperCase() + city.slice(1));
        html += row('Package', pkg === 'ground_only' ? 'Ground Only' : 'Full Package');
        html += row('Total Travellers', totalPersons + ' person' + (totalPersons > 1 ? 's' : ''));

        // Lead
        html += sectionTitle('Lead Traveller');
        html += row('Full Name', val('persons[0][full_name]'));
        html += row('Gender', val('persons[0][gender]'));
        html += row('Date of Birth', val('persons[0][date_of_birth]'));
        html += row('Passport Expiry', val('persons[0][passport_expiry]'));
        html += row('Mobile', val('persons[0][mobile]'));
        html += row('Email', val('persons[0][email]'));
        html += row('City', val('persons[0][city]'));
        html += row('Passport Scan', fileVal('persons[0][passport_scan]'));
        html += row('Passport Photo', fileVal('persons[0][passport_photo]'));

        // Family members
        memberRows.forEach(function (rowEl, i) {
            var idx = i + 1;
            var nameEl = rowEl.querySelector('[name="persons[' + idx + '][full_name]"]');
            var name = nameEl ? (nameEl.value || '—') : '—';
            html += sectionTitle('Traveller ' + (idx + 1) + (name !== '—' ? ' — ' + name : ''));

            function mval(field) {
                var el = rowEl.querySelector('[name="persons[' + idx + '][' + field + ']"]');
                return el ? (el.value || '—') : '—';
            }
            function mfile(field) {
                var el = rowEl.querySelector('[name="persons[' + idx + '][' + field + ']"]');
                if (!el || !el.files || !el.files.length) return '<span class="text-danger" style="font-size:0.8rem">Not uploaded</span>';
                return '<span class="text-success" style="font-size:0.8rem">&#10003; ' + el.files[0].name + '</span>';
            }

            html += row('Gender', mval('gender'));
            html += row('Date of Birth', mval('date_of_birth'));
            html += row('Passport Expiry', mval('passport_expiry'));
            html += row('Relationship', mval('relationship'));
            html += row('Passport Scan', mfile('passport_scan'));
            html += row('Passport Photo', mfile('passport_photo'));
        });

        html += '</tbody></table></div>';
        document.getElementById('review-summary').innerHTML = html;
    }

    // ── Family member add/remove ──────────────────────────────────────────────

    document.getElementById('add-member-btn').addEventListener('click', function () {
        if (memberCount >= maxMembers) {
            alert('Maximum ' + maxMembers + ' additional travellers allowed.');
            return;
        }
        var idx = memberCount + 1;
        var pos = idx + 1;
        var template = document.getElementById('member-template');
        var clone = template.content.cloneNode(true);
        var rowEl = clone.querySelector('.member-row');
        var html = rowEl.outerHTML
            .replace(/__IDX__/g, String(idx))
            .replace(/__POS__/g, String(pos));
        document.getElementById('members-container').insertAdjacentHTML('beforeend', html);
        memberCount++;
        updateMemberBadge();

        // Attach real-time validation to new row
        var newRow = document.querySelectorAll('#members-container .member-row')[memberCount - 1];
        if (newRow) attachRealTime(newRow);
    });

    window.removeMember = function (btn) {
        btn.closest('.member-row').remove();
        memberCount--;
        updateMemberBadge();
        renumberMembers();
    };

    function renumberMembers() {
        var rows = document.querySelectorAll('#members-container .member-row');
        rows.forEach(function (row, i) {
            var idx = i + 1;
            var pos = idx + 1;
            row.querySelectorAll('[name]').forEach(function (input) {
                input.name = input.name.replace(/persons\[\d+\]/, 'persons[' + idx + ']');
            });
            row.querySelectorAll('[id]').forEach(function (el) {
                el.id = el.id.replace(/_\d+$/, '_' + idx);
            });
            row.querySelectorAll('[for]').forEach(function (el) {
                el.htmlFor = el.htmlFor.replace(/_\d+$/, '_' + idx);
            });
            var title = row.querySelector('[id^="member-title-"]');
            if (title) {
                title.id = 'member-title-' + idx;
                title.textContent = 'Traveller ' + pos;
            }
        });
    }

    function updateMemberBadge() {
        document.getElementById('member-count-badge').textContent = memberCount + ' added';
        document.getElementById('add-member-btn').style.display = memberCount >= maxMembers ? 'none' : '';
    }

    // If redirected back with errors, show step 1
    @if($errors->any())
    showStep(1);
    @endif
}());
</script>
@endpush
