<?php

namespace App\Providers;

use App\Cart\Cart;
use App\Cart\Shipping\MelhorEnvioShippingMethod;
use App\Cart\Shipping\ShippingCalculator;
use App\Checkout\BankslipMethod;
use App\Checkout\CreditCardMethod;
use App\Checkout\PaymentMethod;
use App\Checkout\PaymentMethodFactory;
use App\Checkout\Webhook\Iugu\IuguWebhook;
use App\Checkout\Webhook\WebhookInterface;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WebhookController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function (Application $app) {
            return new Cart($app->get('session.store'), $app->make(ShippingCalculator::class));
        });

        $this->app->bind(ShippingCalculator::class, function (Application $app) {
            return new ShippingCalculator(...$app->tagged('shipping_methods'));
        });

        $this->app->singleton(PaymentMethodFactory::class, function (Application $app) {
            return new PaymentMethodFactory(...$app->tagged('payment_methods'));
        });

        $this->app->when(CheckoutController::class)
            ->needs(PaymentMethod::class)
            ->giveTagged('payment_methods');

        $this->app->when(WebhookController::class)
            ->needs(WebhookInterface::class)
            ->giveTagged('webhooks');

        $this->app->tag(IuguWebhook::class, 'webhooks');

        $this->app->tag(CreditCardMethod::class, 'payment_methods');
        $this->app->tag(BankslipMethod::class, 'payment_methods');

        $this->app->when(MelhorEnvioShippingMethod::class)
            ->needs('$origin')
            ->giveConfig('shipping.origin');

        $this->app->tag(MelhorEnvioShippingMethod::class, 'shipping_methods');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
