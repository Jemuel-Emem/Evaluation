<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white">

        <div class="mb-6 flex w-full">
           <div class="w-screen">
            <label for="eventFilter" class="block text-lg font-medium text-gray-700">Filter by Event:</label>
            <select id="eventFilter" wire:model="selectedEvent" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="">All Events</option>
                @foreach($events as $event)
                    <option value="{{ $event }}">{{ $event }}</option>
                @endforeach
            </select>
           </div>

            <div class="mt-8">
                <button wire:click="sa" class="bg-green-500 hover:bg-green-600 w-32 rounded-md ml-2 text-white h-10">Show</button>
            </div>
        </div>

        <!-- Results List -->
        <div class="space-y-6">
            @if($ratings->isEmpty())
                <p class="text-lg text-gray-700">No evaluations found for the selected event.</p>
            @else
                @foreach($ratings as $rating)
                    <div class="p-6 bg-gray-50 rounded-md shadow-md">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $rating->eventname }}</h2>
                            <span class="text-sm text-gray-600">Rated by: {{ $rating->user->name }}</span>
                        </div>
                        <p class="text-lg text-gray-700">{{ $rating->comments }}</p>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
