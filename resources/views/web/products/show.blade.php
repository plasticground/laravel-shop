<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <div class="flex">
                <div>
                    <h2 class="px-4">Price</h2>
                    <h2 class="px-4">${{ $product->price }}</h2>
                </div>
                <x-button id="toCartButton">Add to cart</x-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="pb-3 border-b">
                        <h2 class="text-xl">{{ $product->name }}</h2>
                    </div>
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
    </div>
    @push('scripts')
        <script>
            let btn = document.getElementById('toCartButton');
            let span = document.getElementById('cartSizeSpan');
            btn.addEventListener("click", () => Cart.addItem(span, {{ $product->id }}));
        </script>
    @endpush
</x-app-layout>

