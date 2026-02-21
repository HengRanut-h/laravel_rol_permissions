<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permission List') }}
        </h2>
        @can('create-permissions')
            <button type="button" onclick="window.location='{{ route('permissions.create') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline align-right mt-2">
                Create New Permission</button>
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
                                <th class="px-4 py-2 ">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Create At</th>
                                @can('delete-permissions|edit-permissions')
                                    <th class="px-4 py-2">Action</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @if ($permissions->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4">No permissions found.</td>
                                </tr>
                            @endif
                            @foreach ($permissions as $permission)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $permission->id }}</td>
                                    <td class="border px-4 py-2">{{ $permission->name }}</td>
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($permission->created_at)->format('d-m-y') }}</td>
                                    @can('edit-permissions')
                                        <td><a href="{{ route('permissions.edit', $permission->id) }}"
                                                class="bg-blue-500 text-white hover:bg-blue-700 px-4 py-1 rounded">Edit</a>
                                        </td>
                                    @endcan
                                    @can('delete-permissions')
                                        <td>
                                            <button class="delete bg-red-500 text-white hover:bg-red-700 px-4 py-1 rounded"
                                                data-id="{{ $permission->id }}">
                                                Delete
                                            </button>
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
                        {{ $permissions->links() }}
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

                <script>
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
                </script>


            </x-slot>
        </div>



</x-app-layout>
