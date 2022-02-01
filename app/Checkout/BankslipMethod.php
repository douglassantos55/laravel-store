<?php

namespace App\Checkout;

use App\Models\Invoice;
use App\Models\Order;

class BankslipMethod implements PaymentMethod
{
    public function process(Order $order)
    {
        // do stuff in payment gateway...

        $order->invoices()->create([
            'status' => Invoice::STATUS_PENDING,
            'total' => $order->total,
            'payment_method' => $this->getName(),
            'due_date' => now()->addDays(3),
            'invoice_url' => 'http://gateway.com/bankslip/id',
        ]);
    }

    public function cancel(Order $order)
    {
        foreach ($order->invoices as $invoice) {
            // do stuff in payment gateway...

            $invoice->status = Invoice::STATUS_CANCELED;
            $invoice->save();
        }
    }

    public function getName(): string
    {
        return 'bankslip';
    }

    public function getTemplate(): string
    {
        return 'payment/bankslip';
    }
}
