<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role/Edit') }}
        </h2>
        <div class="btn-container flex items-start ml-600 justify-center">
            <button type="button" onclick="window.location='{{ route('role.index') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">
                    <form action="{{ route('article.update', $article->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="mb-3">

                            <label for="title" class="block text-gray-700 xt-sm font-bold mb-2 ">Title :</label>
                            <input type="text" name="title" id="title" placeholder="Enter Title"
                                value="{{ old('title',$article->title) }}"
                                class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            @error('title')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">

                            <label for="name" class="block text-gray-700 xt-sm font-bold mb-2 ">Content :</label>
                                <textarea
                                name="content"
                                id="description"
                                placeholder="Enter Description"
                                >
                                {{ old('content',$article->content) }}
                                </textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                                @enderror
                        <div class="mb-3">

                            <label for="name" class="block text-gray-700 xt-sm font-bold mb-2 ">Author :</label>
                            <input type="text" name="author" id="author" placeholder="Enter Author"ame" placeholder="Enter Name"
                                value="{{ old('author',$article->author) }}"
                                class="shadow appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            @error('author')
                                <p class="text-red-500 text-sm font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span>
                                <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create article
                            </button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
