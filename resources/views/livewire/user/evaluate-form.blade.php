<div class="p-6 bg-gray-100">
    <span class="underline text-2xl font-extrabold text-gray-800 mb-6 block">Events to Evaluate</span>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4">
        @foreach($question as $quest)
        <x-card class="h-full bg-white shadow-lg rounded-lg overflow-hidden transform transition duration-500 hover:scale-105">
            <div class="p-4 bg-gradient-to-r from-emerald-500 to-teal-400 text-white">
                <h3 class="text-xl font-bold mb-2">{{ $quest->eventname }}</h3>
                <p class="text-sm">{{ \Carbon\Carbon::parse($quest->date)->format('F j, Y') }}</p>
            </div>
            <div class="p-4">
                <div class="flex justify-center">
                    <x-button wire:click="evaluate({{ $quest->id }})" emerald>
                        Evaluate
                    </x-button>
                </div>
            </div>
        </x-card>
        @endforeach
    </div>
    <div class="mt-6">
        {{-- {{ $question->links() }} --}}
    </div>
</div>
