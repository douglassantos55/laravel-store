<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\OrderPlaced as MailOrderPlaced;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $order = $event->getOrder();
        Mail::queue(new MailOrderPlaced($order));
    }
}
