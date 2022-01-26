<?php

namespace App\Checkout\Webhook\Iugu;

use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class IuguInvoiceProcessor
{
    public function process(array $data, string $action)
    {
        switch ($action) {
            case "created":
                $invoice = $this->getInvoice($data['id']);

                if (is_null($invoice)) {
                    $invoice = Invoice::create(Iugu_Invoice::fetch($data['id']));
                }

                InvoiceCreatedEvent::dispatch($invoice);
                break;
            case "status_changed":
                $invoice = $this->getInvoice($data['id']);
                InvoiceStatusChangedEvent::dispatch($invoice);
                break;
        }

        var_dump($data, $action);
    }

    private function getInvoice(string $id): Invoice
    {
        $invoice = Invoice::where('gateway_id', $id)->first();

        if (is_null($invoice)) {
            Log::debug("Invoice {$id} was not found in database");
            return null;
        }

        return $invoice;
    }
}
