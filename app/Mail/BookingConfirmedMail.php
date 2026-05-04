<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Booking $booking) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Received — '.$this->booking->booking_id.' | Arbaeen 2026',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.booking-confirmed',
        );
    }
}
