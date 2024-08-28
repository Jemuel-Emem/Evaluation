<div>
    <h1 class="text-2xl font-bold mb-4">{{ $questionid }} Evaluation</h1>
    <form wire:submit.prevent="submitEvaluation">
        <div class="space-y-4">
            @foreach($questions as $quest)
                <div class="p-4 bg-white shadow-md rounded-md">
                    <h3 class="text-lg font-medium mb-2" wire:model="eventname">{{ $quest->questtion }}</h3>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm">Not satisfy</span>
                        @foreach(range(1, 5) as $rating)
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio text-blue-600" name="rating_{{ $quest->id }}" wire:model="ratings.{{ $quest->id }}" value="{{ $rating }}" required>
                                <span class="ml-2">{{ $rating }}</span>
                            </label>
                        @endforeach
                        <span class="text-sm">Very Satisfy</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $questions->links() }}
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Submit Evaluation</button>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="mt-4">
            <p class="text-green-500">{{ session('message') }}</p>
        </div>
    @endif
</div>
