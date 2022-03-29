<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ordering') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 sm:rounded-lg">
                <div style="overflow-x: auto; text-align: left;">
                    <table class="w-full" cellpadding="15">
                        <thead class="border-b">
                        <tr>
                            <th width="300">Name</th>
                            <th width="150">Price</th>
                            <th width="150">Count</th>
                            <th width="150">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ $product->name }}</td>
                                    <td>$ {{ $product->price }}</td>
                                    <td>{{ $product->count }}</td>
                                    <td>$ {{ $product->price * $product->count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Count</th>
                            <th>Total</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div>
                    <form method="POST" action="{{ route('web.orders.store') }}">
                        @csrf
                        <div>
                            <x-label for="customer_firstname" value="Firstname" />
                            <x-input id="customer_firstname"
                                     type="text"
                                     name="customer_firstname"
                                     class="w-full"
                                     placeholder="Enter your firstname"
                                     required
                                     autofocus
                                     :value="old('customer_firstname')"
                            />
                        </div>

                        <div class="mt-2">
                            <x-label for="customer_lastname" value="Lastname" />
                            <x-input id="customer_lastname"
                                     type="text"
                                     name="customer_lastname"
                                     class="w-full"
                                     placeholder="Enter your lastname"
                                     required
                                     :value="old('customer_lastname')"
                            />
                        </div>

                        <div class="mt-2">
                            <x-label for="customer_phone" value="Phone" />
                            <x-input id="customer_phone"
                                     type="text"
                                     name="customer_phone"
                                     class="w-full"
                                     placeholder="Enter your phone"
                                     required
                                     :value="old('customer_phone')"
                            />
                        </div>

                        <div class="mt-2">
                            <x-label for="comment" value="Comment" />
                            <x-textarea name="comment"
                                        id="comment"
                                        rows="4"
                                        class="w-full"
                                        placeholder="Comment..."
                            >
                                {{ old('comment') }}
                            </x-textarea>
                        </div>

                        <div class="mt-2" style="text-align: right;">
                            <p class="p-2">Total price: $ {{ $totalPrice }}</p>
                            <x-button>Accept order</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
