<?php

namespace App\Mail;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OverdueReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Loan $loan;
    public int $daysLate;
    public string $signature;

    /**
     * Create a new message instance.
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
        $this->daysLate = now()->diffInDays($loan->due_date, false);
        $this->signature = config('library.email_signatures.reminder');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $book = $this->loan->copy->book;
        
        return new Envelope(
            subject: "⚠️ Rappel : Retard de {$this->daysLate} jour(s) - {$book->title}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.overdue-reminder',
            with: [
                'member' => $this->loan->member,
                'loan' => $this->loan,
                'book' => $this->loan->copy->book,
                'daysLate' => $this->daysLate,
                'signature' => $this->signature,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}