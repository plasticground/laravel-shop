<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ config('app.name') }}
        </h2>
    </x-slot>

    <div class="pt-6 text-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-xl">BEST PRODUCTS</h1>
            <a href="{{ route('web.products.index') }}" class="text-gray-500">More</a>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:flex justify-between">
            @foreach($products as $product)
                <div class="w-full sm:px-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <a href="{{ route('web.products.show', $product) }}">
                                <div class="pb-3 border-b">
                                    <h2 class="text-xl">{{ $product->name }}</h2>
                                </div>
                            </a>
                            <div class="py-4">
                                {{ $product->description }}
                            </div>
                            <div class="pt-4" style="text-align: right;">
                                <h2 style="font-size: 2rem; line-height: 2.5rem;">$ {{ $product->price }}</h2>
                                <s class="text-gray-400 font-semibold">$ {{ ceil($product->price * 1.2 / 100) * 100 }}</s>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
