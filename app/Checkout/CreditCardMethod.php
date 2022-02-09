<?php

namespace App\Checkout;

use App\Models\Invoice;
use App\Models\Order;

class CreditCardMethod implements PaymentMethod
{
    public function process(Order $order, array $data)
    {
        // do stuff in payment gateway...

        // $gateway->createPaymentMethod($order->customer->id, $data['credit_card']);

        $order->invoices()->create([
            'status' => Invoice::STATUS_PAID,
            'total' => $order->total,
            'payment_method' => $this->getName(),
            'due_date' => now(),
            'invoice_url' => 'http://gateway.com/invoices/id',
            'credit_card_number' => $data['credit_card']['number'],
        ]);

        $order->status = Order::STATUS_PAID;
    }

    public function getName(): string
    {
        return 'credit_card';
    }

    public function getTemplate(): string
    {
        return 'payment/credit_card';
    }

    public function cancel(Order $order)
    {
        foreach ($order->invoices as $invoice) {
            // do stuff in payment gateway...

            $invoice->status = Invoice::STATUS_CANCELED;
            $invoice->save();
        }
    }
}
