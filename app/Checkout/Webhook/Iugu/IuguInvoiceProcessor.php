<?php

namespace App\Checkout\Webhook\Iugu;

use App\Models\Invoice;
use App\Notifications\OrderStatusChanged;
use Illuminate\Support\Facades\Log;

class IuguInvoiceProcessor
{
    public function process(array $data, string $action)
    {
        switch ($action) {
            case "created":
                break;
            case "status_changed":
                $invoice = $this->getInvoice($data['id']);

                $invoice->status = $data['status'];
                $invoice->order->status = $data['status'];

                $invoice->push();
                $invoice->order->customer->notify(new OrderStatusChanged($invoice->order));
                break;
        }
    }

    private function getInvoice(string $id): Invoice
    {
        $invoice = Invoice::all()->first();

        if (is_null($invoice)) {
            Log::debug("Invoice {$id} was not found in database");
            return null;
        }

        return $invoice;
    }
}
