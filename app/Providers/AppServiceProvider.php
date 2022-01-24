<?php

namespace App\Providers;

use App\Cart\Cart;
use App\Checkout\BankslipMethod;
use App\Checkout\CreditCardMethod;
use App\Checkout\PaymentMethod;
use App\Checkout\PaymentMethodFactory;
use App\Http\Controllers\CheckoutController;
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
            return new Cart($app->get('session.store'));
        });

        $this->app->singleton(PaymentMethodFactory::class, function (Application $app) {
            return new PaymentMethodFactory(...$app->tagged('payment_methods'));
        });

        $this->app->when(CheckoutController::class)
            ->needs(PaymentMethod::class)
            ->giveTagged('payment_methods');

        $this->app->bind(CreditCardMethod::class, function () {
            return new CreditCardMethod('credit_card');
        });

        $this->app->bind(BankslipMethod::class, function () {
            return new BankslipMethod('bank_slip');
        });

        $this->app->tag(CreditCardMethod::class, 'payment_methods');
        $this->app->tag(BankslipMethod::class, 'payment_methods');
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
