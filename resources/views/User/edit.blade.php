<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User/Edit') }}
        </h2>

        <div class="btn-container flex items-start ml-600 justify-center">
            <button type="button" onclick="window.location='{{ route('user.index') }}'"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back</button>
        </div>
        <x-message />
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">

                    <div class="mt-2">
                        <form method="POST" action="{{ route('user.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <!-- Name -->
                            <div>
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div class="mt-4">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                        :value="old('email', $user->email)" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="grid grid-rows-6 gap-2 mt-4">
                            @foreach ($roles as $role)
                                <div class="flex items-center">
                                    <input type="checkbox" id="rols-{{ $role->id }}" name="role[]"
                                        value="{{ $role->name }}" {{ $hasRoles->contains($role->id) ? 'checked' : '' }}
                                    class="mr-2"
                                    {{-- {{ $hasRoles->contains($role->name) ? 'checked' : '' }} --}}
                                    >
                                    <label for="permissions-{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </div>
                                <div class="flex items-center justify-end mt-4">

                                    <x-primary-button class="ms-4">
                                        {{ __('Update') }}
                                    </x-primary-button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>



</x-app-layout>
