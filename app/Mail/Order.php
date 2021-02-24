<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;
    public $shipping;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('fontend.mails.order')
        ->from('nguyenhuymanh06081998@gmail.com', 'ISMART')
        ->subject('[ISMART]Đặt hàng thành công!')
        ->with($this->shipping);
    }
}
