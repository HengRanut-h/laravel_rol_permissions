@if (session('success'))
    <p class="text-green-500 rounded-sm shadow-sm fs-1 font-bold mb-4">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p class="text-red-500 rounded-sm shadow-sm text-sm fs-1 font-bold mb-4">{{ session('error') }}</p>
@endif
