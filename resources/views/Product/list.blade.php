<x-app-layout>
     @section('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>

            <button type="button" onclick="window.location='{{ route('product.create') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline align-right mt-2 ">
                Create New Product</button>

        <x-message />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2 text-center ">#</th>
                                <th class="border px-4 py-2 text-center">Name</th>
                                <th class="border px-4 py-2 text-center">Category</th>
                                <th class="border px-4 py-2 text-center">Price</th>
                                <th class="border px-4 py-2 text-center">Description</th>
                                <th class="border px-4 py-2 text-center">Date</th>
                                    <th class="border px-4 py-2 text-center">Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            @if ($products->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4">No product found.</td>
                                </tr>
                            @endif
                            @foreach ($products as $product)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $product->id }}</td>
                                    <td class="border px-4 py-2">{{ $product->name }}</td>
                                    <td class="border px-4 py-2">{{ $product->category->name }}</td>
                                    <td class="border px-4 py-2">${{ $product->price }}</td>
                                    <td class="border px-4 py-2">{{ $product->description }}</td>

                                    {{-- <td class="border px-4 py-2">{{ $product->created_at->format('d M Y') }}</td> --}}
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($product->created_at)->format('d M Y') }}</td>

                                        <td class="border px-4 py-4 text-center d-flex justify-content-center align-content-center space-x-3">
                                            <button
                                                class="btn btn-primary bg-blue-500 text-white hover:bg-blue-700 px-4 py-1 rounded flex-md-row ">
                                                <a href="{{ route('product.edit', $product->id) }}">Edit</a>
                                            </button>

                                            <form action="{{ route('product.destroy', $product->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button
                                                    class="delete bg-red-500 text-white hover:bg-red-700 px-4 py-1 rounded"
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            <x-slot name="script">


            </x-slot>
        </div>



</x-app-layout>
