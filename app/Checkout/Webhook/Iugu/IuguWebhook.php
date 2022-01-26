<?php

namespace App\Checkout\Webhook\Iugu;

use App\Checkout\Webhook\WebhookInterface;
use App\Exceptions\InvalidHookTypeException;

class IuguWebhook implements WebhookInterface
{
    const INVOICE_EVENT = "invoice";
    const SUBSCRIPTION_EVENT = "subscription";
    const REFERRALS_EVENT = "referrals";
    const WITHDRAW_REQUEST_EVENT = "withdraw_request";
    const DEPOSIT_EVENT = "deposit";

    /**
     * @var IuguInvoiceProcessor
     */
    private $invoiceProcessor;

    /**
     * @var IuguSubscriptionProcessor
     */
    private $subscriptionProcessor;

    public function __construct(
        IuguInvoiceProcessor $invoiceProcessor,
        IuguSubscriptionProcessor $subscriptionProcessor
    ) {
        $this->invoiceProcessor = $invoiceProcessor;
        $this->subscriptionProcessor = $subscriptionProcessor;
    }

    public function getName(): string
    {
        return 'iugu';
    }

    public function process(array $event)
    {
        if (!isset($event['data']) || !isset($event['event'])) {
            return false;
        }

        $data = $event['data'];
        $eventType = $event['event'];

        [$type, $action] = explode('.', $eventType);

        switch ($type) {
            case self::INVOICE_EVENT:
                $this->invoiceProcessor->process($data, $action);
                break;
            case self::SUBSCRIPTION_EVENT:
                $this->subscriptionProcessor->process($data, $action);
                break;
            default:
                throw new InvalidHookTypeException($type, $data);
        }
    }
}
