<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public $shipping_info;

    public $deliveryInfo;

    public $order;


    /**
     * Create a new message instance.
     */
    public function __construct($shipping_info, $data,$deliveryInfo, $order)
    {
        $this->shipping_info = $shipping_info;
        $this->data = $data;
        $this->deliveryInfo = $deliveryInfo;
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Delivered Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.delivered',
            with: [
                'data' => $this->data,
                'shippingInfo' => $this->shipping_info,
                'deliveryInfo' => $this->deliveryInfo,
                'order' => $this->order
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
        return [];
    }
}
