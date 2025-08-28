<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $oldStatus,
        public string $newStatus,
        public ?string $statusNote
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->getStatusMessage($this->newStatus);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-status-changed',
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

    /**
     * Get status-specific message.
     */
    private function getStatusMessage(string $status): string
    {
        return match ($status) {
            'active' => 'Votre compte a été activé avec succès',
            'suspended' => 'Votre compte a été mis en pause temporairement',
            'terminated' => 'Votre compte a été désactivé',
            'rejected' => 'Votre demande d\'accès a été refusée',
            'requested' => 'Votre demande d\'accès est en cours de traitement',
            default => 'Changement de statut de votre compte',
        };
    }
}