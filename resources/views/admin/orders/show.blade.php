<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order at ') . $order->created_at->format('Y-m-d') }}
            <span class="bg-order-{{ $order->state }} px-1">{{ \App\Models\Order::getVerbalState($order->state) }}</span>
        </h2>
        <i class="text-gray-500">{{ $order->uuid }}</i>
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
                            @foreach($order->products as $product)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ $product->name }}</td>
                                    <td>$ {{ $product->pivot->price }}</td>
                                    <td>{{ $product->pivot->count }}</td>
                                    <td>$ {{ $product->pivot->price * $product->pivot->count }}</td>
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

                <div class="mt-2" style="text-align: right;">
                    <p class="p-2">Total price: $ {{ $order->totalPrice }}</p>
                    <p class="p-2">Manager: {{ $order->manager->fullname ?? '-' }}</p>
                    <p class="p-2">Customer: {{ $order->customer->fullname ?? 'Guest' }}</p>
                    <p class="p-2">Firstname: {{ $order->customer_firstname }}</p>
                    <p class="p-2">Lastname: {{ $order->customer_lastname }}</p>
                    <p class="p-2">Phone: {{ $order->customer_phone }}</p>
                    <p class="p-2">{{ $order->created_at->format('Y-m-d') }}</p>
                    <p class="p-2">{{ $order->created_at->format('h:i:s') }}</p>
                </div>

                <div class="mt-2 flex justify-end">
                    @if(in_array($order->state, [\App\Models\Order::STATE_REJECTED, \App\Models\Order::STATE_APPROVED]))
                        @if($order->approved_at)
                            <p class="p-2">APPROVED AT: {{ $order->approved_at->format('Y-m-d h:i:s') }}</p>
                        @endif
                        @if($order->rejected_at)
                            <p class="p-2">APPROVED AT: {{ $order->rejected_at->format('Y-m-d h:i:s') }}</p>
                        @endif
                    @else
                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                            @csrf
                            <x-button onclick="return confirm('Approve this order?');">APPROVE</x-button>
                        </form>

                        <form class="pl-3" action="{{ route('admin.orders.reject', $order) }}" method="POST">
                            @csrf
                            <x-button onclick="return confirm('Reject this order?');">REJECT</x-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
