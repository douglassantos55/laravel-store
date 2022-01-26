<?php

namespace App\Checkout\Webhook;

interface WebhookInterface
{
    public function getName(): string;
    public function process(array $data);
}
