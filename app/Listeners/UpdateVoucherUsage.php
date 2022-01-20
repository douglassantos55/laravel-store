<?php

namespace App\Listeners;

use App\Events\OrderPlaced;

class UpdateVoucherUsage
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
        $voucher = $order->voucher;

        if (!is_null($voucher)) {
            $voucher->increment('usages', 1);
        }
    }
}
