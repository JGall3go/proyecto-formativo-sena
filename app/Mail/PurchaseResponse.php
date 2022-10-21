<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Darryldecode\Cart\Cart;

class PurchaseResponse extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "Estado de compra";

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {    
        $cartCollection = \Cart::getContent();
        return $this->view('purchase.mail')->with(['cartCollection' => $cartCollection]);
    }
}
