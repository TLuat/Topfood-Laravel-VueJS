<?php

namespace App\Mail;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    private $data=[];

    public function __construct($data)
    {
        $this->data = $data;

    }

    public function build()
    {
        return $this->from('luatb1910254@student.ctu.edu.vn', 'Cam on')
        ->subject($this->data['subject'])->view('emails.placed')->with('data', $this->data);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('luatb1910254@student.ctu.edu.vn', 'ádasdasdasd Way'),
            subject: 'Order Shipped',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.placed',
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
