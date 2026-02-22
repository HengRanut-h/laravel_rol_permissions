<x-app-layout>
     @section('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post List') }}
        </h2>
        @can('create-posts')
            <button type="button" onclick="window.location='{{ route('article.create') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline align-right mt-2 bg-black">
                Create New Article</button>
            <x-message />
        @endcan
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2 text-center ">#</th>
                                <th class="border px-4 py-2 text-center ">by User</th>
                                <th class="border px-4 py-2 text-center">Title</th>
                                <th class="border px-4 py-2 text-center">Content</th>
                                <th class="border px-4 py-2 text-center">Author</th>
                                <th class="border px-4 py-2 text-center">Create At</th>
                                @canany(['edit-posts','delete-posts'])
                                    <th class="border px-4 py-2 text-center ">Action</th>
                                @endcanany
                            </tr>
                        </thead>

                        <tbody>
                            @if ($articles->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4">No Article found.</td>
                                </tr>
                            @endif
                            @foreach ($articles as $article)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $article->id }}</td>
                                    <td class="border px-4 py-2">{{ optional($article->user)->name }}</td>
                                    <td class="border px-4 py-2">{{ $article->title }}</td>
                                    <td class="border px-4 py-2">{{ $article->content }}</td>
                                    <td class="border px-4 py-2">{{ $article->author }}</td>
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</td>
                                    @can('edit-posts')
                                        <td class="px-4 py-2 text-center d-flex justify-content-center align-content-center space-x-2">
                                            <button
                                                class="btn btn-primary bg-blue-500 text-white hover:bg-blue-700 px-4 py-1 rounded flex-md-row ">
                                                <a href="{{ route('article.edit', $article->id) }}">Edit</a>
                                            </button>

                                    @endcan
                                    @can('delete-posts')

                                            <form action="{{ route('article.destroy', $article->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button
                                                    class="delete bg-red-500 text-white hover:bg-red-700 px-4 py-1 rounded"
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this article?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    @endcan

                                    {{-- <td>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @method('DELETE')
                                            @csrf

                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{-- {{ $permissions->links() }} --}}
                    </div>
                </div>
            </div>
            <x-slot name="script">
                {{-- <script>
$(document).ready(function() {

    $('.delete').click(function () {
        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this permission?')) {
            return;
        }

        $.ajax({
            url: "{{ url('/permissions/delete') }}/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function () {
                alert('Error deleting permission.');
            }
        });

    });

});
</script> --}}

                {{-- <script>
                    $(document).ready(function() {
                        $('.delete').click(function() {
                            let id = $(this).data('id');

                            if (!confirm('Are you sure you want to delete this permission?')) {
                                return;
                            }

                            $.ajax({
                                url: "{{ url('/permissions') }}/" + id,
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    alert(response.message); // show message
                                    console.log(response.message); // log to console
                                    $('#permission-row-' + id).remove(); // remove the row from table
                                    window.location.reload();
                                    // window.reload(); // reload the page

                                },
                                // error: function() {
                                //     alert('Error deleting permission.');
                                // }
                            });
                        });
                    });
                </script> --}}


            </x-slot>
        </div>



</x-app-layout>
