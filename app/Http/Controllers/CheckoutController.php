<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Checkout\PaymentMethod;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
        if ($this->cart->isEmpty()) {
            return redirect(route('cart.details'));
        }

        return view('checkout', ['methods' => $this->paymentMethods->all()]);
    }

    public function success(Order $order)
    {
        return view('checkout/success', ['order' => $order]);
    }

    public function process(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect(route('cart.details'));
        }

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

        $order = new Order();

        DB::transaction(function () use ($order, $validated) {
            // save customer
            $customer = User::firstOrCreate(array_merge(
                $validated['customer'],
                ['password' => bcrypt('123')],
            ));

            $customer->addresses()->firstOrCreate($validated['address']);

            Auth::login($customer);

            // create order
            $order->customer()->associate($customer);
            $order->payment_method = $validated['payment_method'];
            $order->delivery_method = 'sedex';
            $order->discount = $this->cart->getDiscount();
            $order->total = $this->cart->getTotal();
            $order->subtotal = $this->cart->getSubtotal();

            if (!is_null($this->cart->voucher)) {
                $order->voucher()->associate($this->cart->voucher);
            }

            $order->push();

            foreach ($this->cart->getItems() as $cartItem) {
                $order->items()->create([
                    'qty' => $cartItem->qty,
                    'book_id' => $cartItem->getId(),
                    'price' => $cartItem->getPrice(),
                    'subtotal' => $cartItem->getSubtotal(),
                ]);
            }

            // process payment
            $index = $this->paymentMethods->search(function ($method) use ($order) {
                return $method->getName() === $order->payment_method;
            });

            $paymentMethod = $this->paymentMethods->get($index);
            $paymentMethod->process($order);

            $order->push();
            $this->cart->clear();

            OrderPlaced::dispatch($order);
        });

        return redirect(route('checkout.success', ['order' => $order]));
    }
}
