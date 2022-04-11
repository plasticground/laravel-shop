<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.statistics.index') }}">
                        <div class="sm:flex">
                            <div class="p-2 w-full">
                                <x-label for="from" value="From" />
                                <x-input class="w-full" id="from" type="date" name="from" :value="$from->format('Y-m-d')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="to" value="To" />
                                <x-input class="w-full" id="to" type="date" name="to" :value="$to->format('Y-m-d')" />
                            </div>
                        </div>
                        <div class="flex p-2 justify-end">
                            <x-button class="justify-center">Apply</x-button>
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
                            <th>Product</th>
                            <th>Sells amount</th>
                            <th>Profit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($statistics->isEmpty())
                            <tr>
                                <td colspan="3">There is no data</td>
                            </tr>
                        @else
                            @foreach($statistics as $statistic)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ '#' . $statistic->product_id . ': ' . ($statistic->product_name ?? 'DELETED') }}</td>
                                    <td>{{ $statistic->sells_amount }}</td>
                                    <td>$ {{ $statistic->sells_profit }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                        <tfoot class="border-t">
                        <tr>
                            <th>Product</th>
                            <th>Sells amount</th>
                            <th>Profit</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
