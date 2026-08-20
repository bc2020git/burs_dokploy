<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class AttachmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageContent;
    public $attachmentFiles;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $messageContent, $attachmentFiles = [])
    {
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->attachmentFiles = $attachmentFiles;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'layouts.mail',
            with: [
                'icerik' => $this->messageContent,
                'data' => ['subject' => $this->subject]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        foreach ($this->attachmentFiles as $file) {
            if (file_exists($file['path'])) {
                $attachments[] = Attachment::fromPath($file['path'])
                    ->as($file['name'])
                    ->withMime($file['mime']);
            }
        }

        return $attachments;
    }
}
