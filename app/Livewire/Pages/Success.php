<?php

namespace App\Livewire\Pages;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

#[Title('Success')]
class Success extends Component
{
    #[Url]
    public $session_id;

    public function render()
    {
        $model = Order::with('address')->where('user_id', Auth::id())->latest()->first();
        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $sessionInfo = Session::retrieve($this->session_id);

            if ($sessionInfo->payment_status != 'paid') {
                $model->payment_status = 'failed';
                $model->save();

                return redirect()->route('cancel');
            } elseif ($sessionInfo->payment_status == 'paid') {
                $model->payment_status = 'paid';
                // $model->status = 'shipped';
                $model->save();

                // return redirect()->route('dashboard');
            }
        }

        return view('livewire.pages.success', compact('model'));
    }
}
