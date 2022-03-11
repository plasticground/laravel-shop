<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex p-2 justify-end">
                        <a class="underline hover:text-gray-800 text-xl" href="{{ route('admin.products.edit', $product) }}">Edit</a>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">ID</h3>
                        <p>{{ $product->id }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Name</h3>
                        <p>{{ $product->name }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Description</h3>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Price</h3>
                        <p>$ {{ $product->price }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Author</h3>
                        <p>{{ '#' . $product->author->id . ': ' . $product->author->name }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Created</h3>
                        <p>{{ $product->created_at }}</p>
                    </div>
                    <div class="pb-3">
                        <h3 class="text-xl">Updated</h3>
                        <p>{{ $product->updated_at }}</p>
                    </div>

                    <div class="flex p-2 justify-end">
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Confirm delete');">
                            @csrf
                            @method('DELETE')
                            <x-button>Delete</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
