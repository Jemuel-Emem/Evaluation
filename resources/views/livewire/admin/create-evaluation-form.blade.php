<div>
    <div class="space-y-4">
        <x-native-select label="Event" wire:model="event_id">
            <option value="">-- Select Event --</option>
            @foreach ($events as $event)
                <option value="{{ $event->id }}">{{ $event->eventname }}</option>
            @endforeach
        </x-native-select>

        <div class="mt-5">
            @foreach ($categories as $item)
                <x-checkbox id="category-{{ $item->id }}" label="{{ $item->name }}"
                    wire:model.live="selected_category" value="{{ $item->id }}" />
            @endforeach
        </div>

        <x-button label="Save Evaluation" wire:click="store" teal />

    </div>
    <div class="mt-10">
        <div class="relative overflow-x-auto bg-gray-200 p-4 rounded-lg shadow-md">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">Questionaires</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                        <tr class="border-b">
                            <td class="px-6 py-4">
                                {{ $evaluation->event->eventname }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $forms = \App\Models\EvaluationForm::where(
                                        'event_id',
                                        $evaluation->event->id,
                                    )->get();
                                    $categoryNames = $forms->map(
                                        fn($form) => \App\Models\Category::where('id', $form->category_id)->value(
                                            'name',
                                        ),
                                    );
                                @endphp

                                <span>{{ implode(', ', $categoryNames->toArray()) }}</span>
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <x-button label="Edit" icon="pencil" wire:click="edit({{ $evaluation->event_id }})"
                                    positive />
                                <x-button label="Delete" icon="trash" wire:click="delete({{ $evaluation->event_id }})"
                                    negative />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No evaluations found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>{{ $evaluations->links() }}</div>
        </div>
    </div>
</div>
