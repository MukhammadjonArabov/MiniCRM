<x-filament::page>

    <div class="space-y-6">

        <h2 class="text-2xl font-bold">User Profile</h2>

        <div class="p-4 bg-white rounded shadow space-y-3">

            <p><strong>Name:</strong> {{ $profile->name }}</p>
            <p><strong>Email:</strong> {{ $profile->email }}</p>

            @if ($profile->created_at)
                <p><strong>Created At:</strong> {{ $profile->created_at->format('Y-m-d') }}</p>
            @endif

        </div>

    </div>

</x-filament::page>
