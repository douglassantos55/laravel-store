<?php

namespace App\Listeners;

use App\Events\OrderCanceled;
use App\Events\OrderPlaced;
use Illuminate\Events\Dispatcher;

class UpdateVoucherUsage
{
    /**
     * Handle the event.
     *
     * @param \App\Events\OrderPlaced $event
     * @return void
     */
    public function handleOrderPlaced(OrderPlaced $event)
    {
        $order = $event->getOrder();
        $voucher = $order->voucher;

        if (!is_null($voucher)) {
            $voucher->increment('usages', 1);
        }
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\OrderCanceled $event
     * @return void
     */
    public function handleOrderCanceled(OrderCanceled $event)
    {
        $order = $event->getOrder();
        $voucher = $order->voucher;

        if (!is_null($voucher)) {
            $voucher->decrement('usages', 1);
        }
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(OrderPlaced::class, [
            UpdateVoucherUsage::class,
            'handleOrderPlaced'
        ]);

        $events->listen(OrderCanceled::class, [
            UpdateVoucherUsage::class,
            'handleOrderCanceled'
        ]);
    }
}
