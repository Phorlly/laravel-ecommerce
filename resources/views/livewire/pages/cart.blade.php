<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Product</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Total</th>
                                <th class="text-left font-semibold">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr wire:key='{{ $item['product_id'] }}'>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 mr-4 rounded-md"
                                                src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}">
                                            <span class="font-semibold">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ Number::currency($item['unit_price']) }}</td>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <button wire:click="decrement({{ $item['product_id'] }})"
                                                class="border rounded-md py-2 px-4 mr-2 hover:bg-red-400 hover:text-white">
                                                <x-fas-minus class="m-auto w-3 h-3" />
                                            </button>
                                            <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                            <button wire:click='increment({{ $item['product_id'] }})'
                                                class="border rounded-md py-2 px-4 ml-2 hover:bg-blue-500 hover:text-white">
                                                <x-fas-plus class="m-auto w-3 h-3" />
                                            </button>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ Number::currency($item['total_price']) }}</td>
                                    <td>
                                        <button class="flex items-center m-auto"
                                            wire:click='removeItem({{ $item['product_id'] }})'>
                                            <x-fas-trash wire:loading.remove
                                                wire:target="removeItem({{ $item['product_id'] }})"
                                                class="w-4
                                                h-4 text-red-900 ease-in-out transition" />
                                            <span wire:loading class="text-red-500 ml-4"
                                                wire:target="removeItem({{ $item['product_id'] }})">Removing...</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-4xl font-semibold text-slate-500"
                                        colspan="5">
                                        {{ __('No items availabe in the cart.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ Number::currency($grandTotal) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>{{ Number::currency(0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>{{ Number::currency(0) }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Grand Total</span>
                        <span class="font-semibold">{{ Number::currency($grandTotal) }}</span>
                    </div>
                    @if ($items)
                        <button class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">
                            <x-fas-check-to-slot class="w-5 h-5 mx-4" />
                            {{ __('Checkout') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
