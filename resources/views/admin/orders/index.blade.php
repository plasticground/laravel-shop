<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.orders.index') }}">
                        <div class="sm:flex">
                            <div class="p-2 w-full">
                                <x-label for="state" value="State" />
                                <x-select class="w-full" id="state" name="state">
                                    <option value="">ANY</option>
                                    @foreach(\App\Models\Order::getVerbalStates() as $value => $name)
                                        <option @if(request('state') === $value) selected @endif value="{{ $value }}">{{ $name }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="customer" value="Customer (ID or name)" />
                                <x-input class="w-full" id="customer" type="text" name="customer" :value="request('customer')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="customer_firstname" value="Customer firstname" />
                                <x-input class="w-full" id="customer_firstname" type="text" name="customer_firstname" :value="request('customer_firstname')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="customer_lastname" value="Customer lastname" />
                                <x-input class="w-full" id="customer_lastname" type="text" name="customer_lastname" :value="request('customer_lastname')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="customer_phone" value="Customer phone" />
                                <x-input class="w-full" id="customer_phone" type="text" name="customer_phone" :value="request('customer_phone')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="manager" value="Manager (ID or name)" />
                                <x-input class="w-full" id="manager" type="text" name="manager" :value="request('manager')" />
                            </div>
                        </div>
                        <div class="flex p-2 justify-end">
                            <x-button class="justify-center">Search</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 sm:rounded-lg">
                <div style="overflow-x: auto; text-align: left;">
                    <table class="w-full" cellpadding="15">
                        <thead class="border-b">
                        <tr>
                            <th width="150">Date</th>
                            <th width="150">Customer</th>
                            <th width="150">Manager</th>
                            <th width="150">Total price</th>
                            <th width="150">Status</th>
                            <th width="80"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($orders->isEmpty())
                            <tr>
                                <td colspan="6">There is no data</td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        {{ $order->customer->fullname ?? 'Guest' }}
                                        <p class="text-sm">({{ $order->customer_firstname .  ' ' . $order->customer_lastname }})</p>
                                    </td>
                                    <td>{{ $order->manager->fullname ?? '-'}}</td>
                                    <td>$ {{ $order->totalPrice }}</td>
                                    <td>
                                        <span class="bg-order-{{ $order->state }} px-1">
                                            {{ \App\Models\Order::getVerbalState($order->state) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}">
                                            @if(in_array($order->state, [\App\Models\Order::STATE_REJECTED, \App\Models\Order::STATE_APPROVED]))
                                                Show
                                            @else
                                                Moderate
                                            @endif
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="border-t">
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Manager</th>
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
