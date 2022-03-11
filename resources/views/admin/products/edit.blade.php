<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit {{ $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}">
                        @method('PUT')
                        @csrf
                        <div>
                            <x-label for="name" value="Name" />
                            <x-input required class="w-full" id="name" type="text" name="name" :value="old('name', $product->name)" />
                        </div>
                        <div class="pt-4">
                            <x-label for="price" value="Price" />
                            <x-input required class="w-full" id="price" type="number" name="price" :value="old('price', $product->price)" />
                        </div>
                        <div class="pt-4">
                            <x-label for="description" value="Description" />
                            <textarea required name="description" id="description" rows="4" class="w-full rounded-md border-gray-300">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="pt-4" style="text-align: right;">
                            <x-button>Save</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
