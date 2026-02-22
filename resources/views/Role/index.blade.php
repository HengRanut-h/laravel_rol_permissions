<x-app-layout>
     @section('css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @endsection
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role List') }}
        </h2>
        @can('create-rols')
            <button type="button" onclick="window.location='{{ route('role.create') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline align-right mt-2">
                Create New Role</button>
            <x-message />
        @endcan

    </x-slot>
    <div class="py-12">
        <div class="max-w-9x2 mx-auto sm:px-9 lg:px-11">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-1200">
                    <table class="min-w-3000">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2 w-32 text-center"">#</th>
                                <th class="border px-4 py-2 text-center">Name</th>
                                <th class="border px-4 py-2">Permissions</th>
                                <th class="border px-4 py-2 text-center">Guard Name</th>
                                <th class="border px-4 py-2 text-center">Create At</th>
                                @canany(['edit-roles','delete-roles'])
                                    <th class="border px-4 py-2 text-center">Action</th>
                                @endcanany
                            </tr>
                        </thead>

                        <tbody>
                            @if ($role->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center py-4">No permissions found.</td>
                                </tr>
                            @endif
                            @foreach ($role as $role)
                                <tr class="text-center border-b">
                                    <td class="border px-4 py-2 w-16 text-center">{{ $role->id }}</td>
                                    <td class="border px-4 py-2 w-40">{{ $role->name }}</td>
                                    <td class="border px-4 py-2 text-left">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($role->permissions as $permission)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="border px-4 py-2 w-32 text-center">{{ $role->guard_name }}</td>
                                    <td class="border px-4 py-2 w-32 text-center">
                                        {{ \Carbon\Carbon::parse($role->created_at)->format('d M Y') }}</td>
                                    @can('edit-roles')
                                        <td class="px-4 py-2 text-center d-flex justify-content-center align-content-center space-x-2">
                                            <button
                                                class="btn btn-primary bg-blue-500 text-white hover:bg-blue-700 px-4 py-1 rounded flex-md-row ">
                                                <a href="{{ route('role.edit', $role->id) }}">Edit</a>
                                            </button>

                                    @endcan
                                    @can('delete-roles')

                                            <form action="{{ route('role.destroy', $role->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="delete bg-red-500 text-white hover:bg-red-700 px-4 py-1 rounded flex-md-row"
                                                    type="submit>">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>
                                    @endcan
                                </tr>

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
                        {{-- {{ $role->links() }} --}}
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
