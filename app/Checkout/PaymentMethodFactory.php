<?php

namespace App\Checkout;

use Illuminate\Support\Collection;

class PaymentMethodFactory
{
    /**
     * @var Collection
     */
    private $paymentMethods;

    public function __construct(PaymentMethod ...$methods)
    {
        $this->paymentMethods = collect($methods);
    }

    public function create($methodString): PaymentMethod
    {
        return $this->paymentMethods->first(function ($method) use ($methodString) {
            return $method->getName() === $methodString;
        });
    }
}
