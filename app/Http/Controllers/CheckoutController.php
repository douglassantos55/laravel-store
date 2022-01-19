<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Checkout\PaymentMethod;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * @var Collection
     */
    private $paymentMethods;

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart, PaymentMethod ...$paymentMethods)
    {
        $this->cart = $cart;
        $this->paymentMethods = collect($paymentMethods);

        $this->middleware(function ($request, $next) {
            $this->cart->load();
            return $next($request);
        });
    }

    public function index()
    {
        return view('checkout', ['methods' => $this->paymentMethods->all()]);
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer.name' => 'required',
            'customer.email' => 'required|email',
            'address.zipcode' => 'required',
            'address.street' => 'required',
            'address.number' => 'required',
            'address.complement' => 'present',
            'address.neighborhood' => 'required',
            'address.city' => 'required',
            'address.state' => 'required',
            'payment_method' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
                // save customer
                $customer = User::firstOrCreate(array_merge(
                    $validated['customer'],
                    ['password' => '123'],
                ));

                $customer->addresses()->firstOrCreate($validated['address']);

                // create order
                $order = new Order();
                $order->customer()->associate($customer);
                $order->payment_method = $request->post('payment_method', 'paypal');
                $order->delivery_method = $request->post('delivery_method', 'sedex');
                $order->total = 135;
                $order->subtotal = 135;
                $order->voucher()->associate($this->cart->voucher);
                $order->save();

                foreach ($this->cart->items->all() as $cartItem) {
                    $item = new OrderItem();
                    $item->qty = $cartItem->qty;
                    $item->price = 135;
                    $item->subtotal = 135;
                    $item->order()->associate($order);
                    $item->book()->associate($cartItem->book);
                    $item->save();
                }

                // process payment
                $index = $this->paymentMethods->search(function ($method) use ($order) {
                    return $method->getName() === $order->payment_method;
                });

                $paymentMethod = $this->paymentMethods->get($index);
                $paymentMethod->process($order);

                $order->push();
            });

            return redirect(route('checkout.sucess'));
        } catch (Exception $ex) {
            echo $ex->getMessage();die;
        }
    }
}
