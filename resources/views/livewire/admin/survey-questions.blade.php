<div class="  rounded-lg p-4">
    <div class="flex flex-wrap justify-center gap-4">
        @forelse ($categories as $item)
            <a href="{{ route('act', ['id' => $item->id]) }}"
                class="px-6 py-2 text-lg font-medium text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 transition">
                {{ $item->name }}
            </a>
        @empty
        @endforelse
        {{-- <a href="{{ route('venue') }}" class="px-6 py-2 text-lg font-medium text-white bg-green-600 rounded-lg shadow hover:bg-green-700 transition">
            Venue
        </a>
        <a href="{{ route('accomodations') }}" class="px-6 py-2 text-lg font-medium text-white bg-yellow-500 rounded-lg shadow hover:bg-yellow-600 transition">
            Accommodations
        </a>
        <a href="{{ route('speaker') }}" class="px-6 py-2 text-lg font-medium text-white bg-red-600 rounded-lg shadow hover:bg-red-700 transition">
            Speakers
        </a> --}}
    </div>
</div>
