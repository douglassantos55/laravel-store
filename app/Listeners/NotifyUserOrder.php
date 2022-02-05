<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use App\Events\OrderPlaced;
use App\Notifications\NewOrder;
use App\Notifications\OrderStatusChanged;
use Illuminate\Events\Dispatcher;

class NotifyUserOrder
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
        $order->customer->notify(new NewOrder($order));
    }

    public function handleOrderCanceled(OrderCanceled $event)
    {
        $order = $event->getOrder();
        $order->customer->notify(new OrderStatusChanged($order));
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(OrderPlaced::class, [
            NotifyUserOrder::class,
            'handleOrderPlaced'
        ]);

        $events->listen(OrderCanceled::class, [
            NotifyUserOrder::class,
            'handleOrderCanceled'
        ]);
    }
}
