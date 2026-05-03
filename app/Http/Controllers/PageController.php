<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'whatsappMessage' => config('arbaeen.whatsapp_messages.home'),
        ]);
    }

    public function ar01(): View
    {
        return view('packages.ar01', [
            'group' => config('arbaeen.groups.AR01'),
            'pricing' => config('arbaeen.pricing'),
            'paymentSchedule' => config('arbaeen.payment_schedule'),
            'hotels' => config('arbaeen.hotels'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.ar01'),
        ]);
    }

    public function ar02(): View
    {
        return view('packages.ar02', [
            'group' => config('arbaeen.groups.AR02'),
            'pricing' => config('arbaeen.pricing'),
            'paymentSchedule' => config('arbaeen.payment_schedule'),
            'hotels' => config('arbaeen.hotels'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.ar02'),
        ]);
    }

    public function paymentInfo(): View
    {
        return view('payment-info', [
            'paymentSchedule' => config('arbaeen.payment_schedule'),
            'contacts' => config('arbaeen.contacts'),
            'office' => config('arbaeen.office'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.contact'),
        ]);
    }

    public function terms(): View
    {
        return view('terms', [
            'whatsappMessage' => config('arbaeen.whatsapp_messages.contact'),
        ]);
    }

    public function contact(): View
    {
        return view('contact', [
            'contacts' => config('arbaeen.contacts'),
            'office' => config('arbaeen.office'),
            'whatsappMessage' => config('arbaeen.whatsapp_messages.contact'),
        ]);
    }

    public function questions(): View
    {
        return view('questions', [
            'whatsappMessage' => config('arbaeen.whatsapp_messages.home'),
        ]);
    }
}
