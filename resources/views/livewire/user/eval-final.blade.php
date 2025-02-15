<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white">
    {{-- @if ($hasEvaluated)
        <div class="bg-green-100 p-6 rounded-md shadow-md mb-6">
            <h2 class="text-2xl font-bold text-green-700">Thank you for your feedback!</h2>
            <p class="text-lg text-gray-700">You have already submitted your evaluation for this event.</p>
        </div>
    @else
        <!-- Event Info Section -->
        <div class="bg-blue-50 p-6 rounded-md shadow-md mb-6">
            <h1 class="text-3xl font-bold text-blue-700 mb-2">{{ $eventname }} Evaluation</h1>
            <p class="text-lg text-gray-700">Please rate your experience with the following aspects of the event. Your feedback helps us improve future events.</p>
        </div>

        <!-- Survey Form Section -->
        <form wire:submit.prevent="submitEvaluation" class="bg-white">
            <div class="space-y-6">
@foreach ($questions as $quest)
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4">{{ $quest->text ?? $quest->question_text }}</h3>

        <div class="flex items-center space-x-6">
            <span class="text-sm font-semibold text-gray-600">Not Satisfied</span>
            <div class="flex space-x-2">
                @foreach (range(1, 5) as $rating)
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox text-blue-600"
                               wire:model="ratings.{{ $quest->id }}"
                               value="{{ $rating }}"
                               wire:click="selectOnlyOne('{{ $quest->id }}', '{{ $rating }}')">
                        <span class="ml-2">{{ $rating }}</span>
                    </label>
                @endforeach
            </div>
            <span class="text-sm font-semibold text-gray-600">Very Satisfied</span>
        </div>
    </div>
@endforeach



            </div>

            <div class="mt-6">
                
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                    Submit Evaluation
                </button>
            </div>
        </form>
    @endif --}}
    <h1>{{ $eventname }}</h1>
    <div class="mt-10">
        <div class="space-y-5">
            @foreach ($categories as $item)
                <div class="border-b mb-10">
                    <h1>{{ $item->category->name }}</h1>
                    <ul class="mt-5">
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($item->category->categoryQuestions as $question)
                            <li>
                                <p>{{ $i++ }}. {{ $question->question }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
