<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use App\Events\OrderPlaced;
use App\Mail\OrderCanceled as MailOrderCanceled;
use App\Mail\OrderPlaced as MailOrderPlaced;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Mail;

class MailOrderSubscriber
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handleOrderPlaced(OrderPlaced $event)
    {
        $order = $event->getOrder();
        Mail::queue(new MailOrderPlaced($order));
    }

    public function handleOrderCanceled(OrderCanceled $event)
    {
        $order = $event->getOrder();
        Mail::queue(new MailOrderCanceled($order));
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(OrderPlaced::class, [MailOrderSubscriber::class, 'handleOrderPlaced']);
        $events->listen(OrderCanceled::class, [MailOrderSubscriber::class, 'handleOrderCanceled']);
    }
}
