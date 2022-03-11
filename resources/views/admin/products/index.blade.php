<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="flex p-2 justify-end">
                            <a class="underline hover:text-gray-800 text-xl" href="{{ route('admin.products.create') }}">Create</a>
                        </div>
                        <div class="sm:flex">
                            <div class="p-2 w-full">
                                <x-label for="name" value="Name" />
                                <x-input class="w-full" id="name" type="text" name="name" :value="request('name')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="user" value="Author (ID or name)" />
                                <x-input class="w-full" id="user" type="text" name="user" :value="request('user')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="price" value="Price" />
                                <x-input class="w-full" id="price" type="number" name="price" :value="request('price')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="priceFrom" value="Price Min" />
                                <x-input class="w-full" id="priceFrom" type="number" name="priceFrom" :value="request('priceFrom')" />
                            </div>
                            <div class="p-2 w-full">
                                <x-label for="priceTo" value="Price Max" />
                                <x-input class="w-full" id="priceTo" type="number" name="priceTo" :value="request('priceTo')" />
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200" style="overflow-x: auto; text-align: left;">
                    <table class="w-full" cellpadding="15   ">
                        <thead class="border-b">
                            <tr>
                                <th width="50">ID</th>
                                <th width="100">Name</th>
                                <th width="400">Description</th>
                                <th width="100">Author</th>
                                <th width="100">Price, $</th>
                            </tr>
                        </thead>
                        <tbody>
                            @empty($products->all())
                                <tr>
                                    <td colspan="4">There is no data</td>
                                </tr>
                            @endempty
                            @foreach($products as $product)
                                <tr @if($loop->even) class="bg-gray-100" @endif>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.show', $product) }}">
                                            {{ $product->name }}
                                        </a>
                                    </td>
                                    <td class="p-2"><textarea readonly rows="1" class="rounded-md border-gray-300" style="resize: both;">{{ $product->description }}</textarea></td>
                                    <td>{{ '#' . $product->author->id . ': ' . $product->author->name }}</td>
                                    <td>{{ $product->price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Author</th>
                                <th>Price, $</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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
