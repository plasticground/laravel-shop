<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
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
                            <th width="80"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($products->isEmpty())
                            <tr>
                                <td colspan="5">Cart is empty :(</td>
                            </tr>
                        @else
                            @foreach($products as $product)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>
                                        <a href="{{ route('web.products.show', $product) }}">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td>$ {{ $product->price }}</td>
                                    <td>{{ $product->count }}</td>
                                    <td>$ {{ $product->price * $product->count }}</td>
                                    <td>
                                        <div class="flex justify-end">
                                            <form method="POST" action="{{ route('web.cart.add', $product) }}" class="p-2">
                                                @csrf
                                                @method('PUT')
                                                <x-button>&plus;</x-button>
                                            </form>
                                            <form method="POST" action="{{ route('web.cart.remove', $product) }}" class="p-2">
                                                @csrf
                                                @method('DELETE')
                                                <x-button>&minus;</x-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="border-t">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Count</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                @if($products->isNotEmpty())
                    <div class="flex justify-end pt-2">
                        <p class="p-2">Total price: $ {{ $totalPrice }}</p>
                        <x-button-link href="{{ route('web.orders.create') }}">Order</x-button-link>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
