<div class="bg-white p-8">
    <h1 class="text-center text-2xl uppercase">{{ $eventname }}</h1>

<div class="mt-10">
    <div class="space-y-5">
        @foreach ($categories as $item)
            <div class="border-b mb-10">
                <h1 class="text-lg font-bold">{{ $item->category->name }}</h1>
                <ul class="mt-5">
                    @php $i = 1; @endphp
                    @foreach ($item->category->categoryQuestions as $question)
                        <li class="mb-4">
                            <p>{{ $i++ }}. {{ $question->question }}</p>


                            <div class="flex items-center space-x-6 mt-2">
                                <span class="text-sm font-semibold text-gray-600">Not Satisfied</span>
                                <div class="flex space-x-2">
                                    @foreach (range(1, 5) as $rating)
                                        <label class="inline-flex items-center">
                                            <input type="radio"
                                                   name="ratings[{{ $question->id }}]"
                                                   class="form-radio text-blue-600"
                                                   wire:model="ratings.{{ $question->id }}"
                                                   value="{{ $rating }}"
                                                   wire:click="selectOnlyOne('{{ $question->id }}', '{{ $rating }}')">
                                            <span class="ml-2">{{ $rating }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <span class="text-sm font-semibold text-gray-600">Very Satisfied</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        <!-- Comments Input -->
        <div class="mt-6">
            <label for="comments" class="block text-sm font-medium text-gray-700">Additional Comments</label>
            <textarea id="comments" wire:model="comments" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      placeholder="Write your comments here..."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end">
            <x-button label="Submit Evaluation" type="submit" teal wire:click="submitEvaluation" />
        </div>
    </div>
</div>

</div>
