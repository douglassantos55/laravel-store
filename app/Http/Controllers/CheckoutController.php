<?php

namespace App\Http\Controllers;

use App\Checkout\PaymentMethod;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * @var PaymentMethod[]
     */
    private $paymentMethods;

    public function __construct(PaymentMethod ...$paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
    }

    public function index()
    {
        return view('checkout', ['methods' => $this->paymentMethods]);
    }

    public function process(Request $request)
    {
        try {
            // save customer
            //$customer = User::create($request->post('customer'));
            //$customer->addresses()->create($request->post('address'));

            $paymentMethod = $this->getPaymentMethod($request->post('payment_method'));
            $deliveryMethod = $this->getDeliveryMethod($request->post('delivery_method'));

            // create order
            //$order = new Order($customer, $deliveryMethod, $paymentMethod);

            if (is_null($paymentMethod)) {
                throw new Exception("Payment method not found");
            }

            // process payment
            //$paymentMethod->process($order);

            //$order->save();

            return redirect(route('checkout.sucess'));
        } catch (Exception $ex) {
            $request->session()->flash('checkout', $ex->getMessage());
            return back();
        }
    }
}
