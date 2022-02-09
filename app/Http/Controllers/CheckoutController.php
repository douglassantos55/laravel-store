<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Checkout\PaymentMethod;
use App\Checkout\PaymentMethodFactory;
use App\Events\OrderCanceled;
use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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

        $customer = auth()->user();

        return view('checkout', [
            'cart' => $this->cart,
            'customer' => $customer,
            'methods' => $this->paymentMethods->all()
        ]);
    }

    public function success(Order $order)
    {
        return view('checkout/success', ['order' => $order]);
    }

    public function cancel(Order $order, PaymentMethodFactory $factory)
    {
        if (!Gate::allows('cancel-order', $order)) {
            abort(403);
        }

        if ($order->status === Order::STATUS_CANCELED) {
            session()->flash('dashboard', 'Order has already been canceled');
            return back();
        }

        $paymentMethod = $factory->create($order->payment_method);
        $paymentMethod->cancel($order);

        $order->status = Order::STATUS_CANCELED;
        $order->save();

        OrderCanceled::dispatch($order);

        return redirect(route('user.dashboard'));
    }

    public function process(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect(route('cart.details'));
        }

        $validated = $request->validate([
            'customer.name' => 'required',
            'customer.email' => 'required|email',
            'address_id' => [
                Rule::requiredIf(function () use ($request) {
                    return count(array_filter($request->post('address'), function ($field) {
                        return empty($field);
                    }));
                }),
                Rule::exists('addresses', 'id')->where(function ($query) {
                    return $query->where('user_id', auth()->user()->id);
                }),
            ],
            'address.zipcode' => 'required_without:address_id',
            'address.street' => 'required_without:address_id',
            'address.number' => 'required_without:address_id',
            'address.complement' => 'present',
            'address.neighborhood' => 'required_without:address_id',
            'address.city' => 'required_without:address_id',
            'address.state' => 'required_without:address_id',
            'shipping_method' => 'required',
            'payment_method' => 'required',
            'credit_card.number' => 'required_if:payment_method,credit_card',
            'credit_card.name' => 'required_if:payment_method,credit_card',
            'credit_card.cvv' => 'required_if:payment_method,credit_card',
            'credit_card.expiration_date' => 'sometimes|exclude_unless:payment_method,credit_card|required_if:payment_method,credit_card|date_format:m/Y|after:today',
        ]);

        $order = new Order();

        DB::transaction(function () use ($order, $validated) {
            // save customer
            $customer = User::firstOrCreate($validated['customer'], array_merge(
                $validated['customer'],
                ['password' => bcrypt('123')],
            ));

            if (empty($validated['address_id'])) {
                $customer->addresses()->firstOrCreate($validated['address']);
            }

            Auth::login($customer);

            // create order
            $order->customer()->associate($customer);
            $order->payment_method = $validated['payment_method'];
            $order->shipping_method = $this->cart->shippingMethod;
            $order->shipping_company = $this->cart->getShippingRate()->getCompanyName();
            $order->shipping_service = $this->cart->getShippingRate()->getName();
            $order->shipping_estimate = $this->cart->getShippingRate()->getEstimate();
            $order->shipping_company_logo = $this->cart->getShippingRate()->getCompanyLogo();
            $order->shipping_cost = $this->cart->getShippingRate()->getPrice();
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
            $paymentMethod->process($order, $validated);

            $order->push();
            $this->cart->clear();

            OrderPlaced::dispatch($order);
        });

        return redirect(route('checkout.success', ['order' => $order]));
    }
}
