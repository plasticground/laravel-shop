<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 sm:rounded-lg">
                <div style="overflow-x: auto; text-align: left;">
                    <table class="w-full" cellpadding="15">
                        <thead class="border-b">
                        <tr>
                            <th width="300">Date</th>
                            <th width="150">Total price</th>
                            <th width="150">Status</th>
                            <th width="80"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($orders->isEmpty())
                            <tr>
                                <td colspan="4">You have not made any orders yet</td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>$ {{ $order->totalPrice }}</td>
                                    <td>
                                        <span class="bg-order-{{ $order->state }} px-1">
                                            {{ \App\Models\Order::getVerbalState($order->state) }}
                                        </span>
                                    </td>
                                    <td><a href="{{ route('web.orders.show', $order) }}">More</a></td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="border-t">
                        <tr>
                            <th>Date</th>
                            <th>Total price</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    @if($orders->hasMorePages())
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
