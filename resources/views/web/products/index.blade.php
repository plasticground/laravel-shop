<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($products as $product)
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
            @endforeach
        </div>
    </div>

    @if($products->hasMorePages())
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
