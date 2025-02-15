<div class="p-6">
    <span class="text-2xl font-extrabold text-white mb-6 block">Events to Evaluate</span>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
        @foreach ($evaluations as $evaluation)
            <x-card
                class="h-full bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
                <div class="p-4 bg-gradient-to-r from-emerald-500 to-teal-400 text-white">
                    <h3 class="text-xl font-bold mb-2">{{ $evaluation->event->eventname }}</h3>
                    <p class="text-sm">{{ \Carbon\Carbon::parse($evaluation->event->date)->format('F j, Y') }}</p>
                </div>
                <div class="p-4">
                    <div class="flex justify-center">
                        <x-button wire:click="evaluate({{ $evaluation->event->id }})" emerald>
                            Evaluate Now
                        </x-button>
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $evaluations->links() }}
    </div>
</div>
