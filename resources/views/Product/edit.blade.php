<x-app-layout>
    @section('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product/Edit') }}
        </h2>
        <div class="btn-container flex items-start ml-600 justify-end">
            <button type="button" onclick="window.location='{{ route('product.index') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <div class="bg-secondary overflow-hidden shadow-sm sm:rounded-lg container border border-success pb-12">
                <div class="p-2 text-gray-900">
                    <form action="{{ route('product.update', $product->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <div class="my-3">
                                <label class="form-label font-bold" for="name"> Product Name :</label>
                                <input type="text" name="name" id="name" placeholder="Enter Product Name"
                                    value="{{ old('name', $product->name) }}" class="form-control"
                                    class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-control"
                                    required>
                            </div>
                            <div>
                                <label for="price" class="block  font-bold mb-2 ">Price:</label>
                                <input type="text" name="price" id="price" placeholder="Enter price"
                                    value="{{ old('price',$product->price) }}"
                                    class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    required>
                            </div>
                             <div>
                            @error('price')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                            <div class="my-3 w-full h-140">
                                <label class="form-label font-bold" for="description">Product Description:</label>

                                <textarea name="description" id="description" placeholder="Enter description" required
                                    class="form-control shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    rows="3">{{ old('description',$product->description ) }}</textarea>
                            </div>


                        </div>
                        <div>
                            @error('description')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <select name="category_id"
                                class="border rounded p-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline form-select w-25">
                                <option selected value=" ">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         <div>
                            @error('category_id')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>


                </div>
                <div class="flex items-center justify-center mt-3 ">
                    <span>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                           Update
                        </button>
                    </span>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
