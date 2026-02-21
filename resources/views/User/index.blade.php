<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permission List') }}
        </h2>
        @can('create-users')
            <button type="button" onclick="window.location='{{ route('user.create') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline align-right mt-2">
                Create New user</button>
        @endcan
        <x-message />
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
                                <th class="px-4 py-2">Role</th>
                                <th class="px-4 py-2">Gmail</th>
                                <th class="px-4 py-2">Create At</th>
                                @can('delete-users|edit-users')
                                    <th class="px-4 py-2">Action</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4">No user found.</td>
                                </tr>
                            @endif
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $user->id }}</td>
                                    <td class="border px-4 py-2">{{ $user->name }}</td>
                                    <td class="border px-4 py-2">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="border px-4 py-2">{{ $user->email }}</td>
                                    {{-- <td class="border px-4 py-2">{{ $user->created_at->format('d M Y') }}</td> --}}
                                    <td class="border px-4 py-2">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                    @can('edit-users')
                                        <td>
                                            <button
                                                class="btn btn-primary bg-blue-500 text-white hover:bg-blue-700 px-4 py-1 rounded flex-md-row ">
                                                <a href="{{ route('user.edit', $user->id) }}">Edit</a>
                                            </button>
                                        </td>
                                    @endcan
                                    @can('delete-users')
                                        <td>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button
                                                    class="delete bg-red-500 text-white hover:bg-red-700 px-4 py-1 rounded"
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
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
