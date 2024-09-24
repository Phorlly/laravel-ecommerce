<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Http\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Checkout')]
class Checkout extends Component
{
    public $first_name, $last_name, $phone_number, $street, $city, $state, $zip_code, $payment_method = 'cod';

    public function mount()
    {
        $items = CartManagement::getItems();
        if (count($items) == 0) {
            return redirect()->route('product');
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $items = CartManagement::getItems();
        $lineItems = [];

        foreach ($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item['unit_price'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->grand_total = CartManagement::calculateGrandTotal($items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'usd';
        $order->shipping_price = 0;
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . Auth::user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone_number = $this->phone_number;
        $address->street = $this->street;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;

        $redirectUrl = '';
        if ($this->payment_method == 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $sessionCheckout = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => Auth::user()->email,
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            $redirectUrl = $sessionCheckout->url;
        } else {
            $redirectUrl = route('success');
        }

        $order->save();
        $address->order_id = $order->id;
        $address->save();
        $order->items()->createMany($items);
        CartManagement::clearItems();
        Mail::to(request()->user())->send(new OrderPlaced($order));

        return redirect($redirectUrl);
    }

    public function render()
    {
        $items = CartManagement::getItems();
        $grandTotal = CartManagement::calculateGrandTotal($items);

        return view('livewire.pages.checkout', compact('items', 'grandTotal'));
    }
}
