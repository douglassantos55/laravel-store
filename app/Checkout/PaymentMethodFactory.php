<?php

namespace App\Checkout;

use Exception;

abstract class PaymentMethodFactory
{
    public static function create($methodString): PaymentMethod
    {
        switch ($methodString) {
            case "credit_card":
                return new CreditCardMethod();
            case "bankslip":
                return new BankslipMethod();
            default:
                throw new Exception("Payment method {$methodString} not found");
        }
    }
}
