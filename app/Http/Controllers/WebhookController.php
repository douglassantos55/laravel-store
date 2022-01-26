<?php

namespace App\Http\Controllers;

use App\Checkout\Webhook\WebhookInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class WebhookController extends Controller
{
    /**
     * @var Collection
     */
    private $webhooks;

    public function __construct(WebhookInterface ...$webhooks)
    {
        $this->webhooks = collect($webhooks);
    }

    public function process(string $processor, Request $request)
    {
        /**
         * @var WebhookInterface
         */
        $webhook = $this->webhooks->first(function (WebhookInterface $webhook) use ($processor) {
            return $webhook->getName() === $processor;
        });

        if (!is_null($webhook)) {
            $webhook->process($request->post());
        }
    }
}
