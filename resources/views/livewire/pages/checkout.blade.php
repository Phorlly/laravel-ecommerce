<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        {{ __(' Checkout') }}
    </h1>

    <form wire:submit.prevent='placeOrder'>
        <div class="grid grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <!-- Card -->
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Shipping Address
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                    First Name
                                </label>
                                <input
                                    class="w-full rounded-lg border @error('first_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    wire:model="first_name" type="text">
                                </input>
                                @error('first_name')
                                    <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Last Name
                                </label>
                                <input
                                    class="w-full rounded-lg border py-2 px-3 @error('last_name') border-red-500 @enderror dark:bg-gray-700 dark:text-white dark:border-none"
                                    wire:model="last_name" type="text">
                                </input>
                                @error('last_name')
                                    <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                Phone
                            </label>
                            <input
                                class="w-full rounded-lg @error('phone_number') border-red-500 @enderror border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                wire:model="phone_number" type="text">
                            </input>
                            @error('phone_number')
                                <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="address">
                                Street Address
                            </label>
                            <input
                                class="w-full rounded-lg @error('street') border-red-500 @enderror border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                wire:model="street" type="text">
                            </input>
                            @error('street')
                                <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                City
                            </label>
                            <input
                                class="w-full rounded-lg border @error('city') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                wire:model="city" type="text">
                            </input>
                            @error('city')
                                <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                    State
                                </label>
                                <input
                                    class="w-full rounded-lg border py-2 px-3 @error('state') border-red-500 @enderror dark:bg-gray-700 dark:text-white dark:border-none"
                                    wire:model="state" type="text">
                                </input>
                                @error('state')
                                    <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    ZIP Code
                                </label>
                                <input
                                    class="w-full rounded-lg border py-2 px-3 @error('zip_code') border-red-500 @enderror dark:bg-gray-700 dark:text-white dark:border-none"
                                    wire:model="zip_code" type="text">
                                </input>
                                @error('zip_code')
                                    <span class="text-red-500 text-sm py-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-lg font-semibold mb-4">
                        Choose Payment Method
                    </div>
                    <div class="flex gap-x-6">
                        <div class="flex">
                            <input type="radio" wire:model='payment_method' value="cod"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="cod" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
                                Cash On Delivery
                            </label>
                        </div>


                        <div class="flex">
                            <input type="radio" wire:model='payment_method'
                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                            value="stripe">
                            <label for="stripe"
                            class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Stripe</label>
                        </div>
                        {{-- <div class="flex">
                            <input type="radio" wire:model='payment_method'
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                value="ba">
                            <label for="ba" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">
                                Bank Account
                            </label>
                        </div> --}}
                    </div>
                    @error('payment_method')
                        <span class="text-red-500 text-sm pt-4">{{ $message }}</span>
                    @enderror
                </div>
                <!-- End Card -->
            </div>

            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Subtotal
                        </span>
                        <span>
                            {{ Number::currency($grandTotal) }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Taxes
                        </span>
                        <span>
                            {{ Number::currency(0) }}
                        </span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Shipping Cost
                        </span>
                        <span>
                            {{ Number::currency(0) }}
                        </span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>
                            Grand Total
                        </span>
                        <span>
                            {{ Number::currency($grandTotal) }}
                        </span>
                    </div>
                    </hr>
                </div>
                <button type="submit"
                    class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    <span wire:loading.remove>{{ __('Place Order') }}</span>
                    <span wire:loading>{{ __('Processing...') }}</span>
                </button>
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach ($items as $item)
                            <li class="py-3 sm:py-4" wire:key='{{ $item['product_id'] }}'>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full p-1"
                                            src="{{ asset('storage/' . $item['image']) }}">
                                        </img>
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ __('Quantity: ') }} <b>{{ $item['quantity'] }}</b>
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ Number::currency($item['total_price']) }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
