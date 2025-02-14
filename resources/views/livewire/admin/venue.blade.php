<div>
    <div class="flex justify-end items-center">

        <x-button label="Add Question" teal icon="plus" wire:click="$set('add_venue_modal', true)" />
    </div>

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left text-gray-500 bg-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Question</th>
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($venueQuestions as $question)
                    <tr>
                        <td class="px-6 py-4">{{ $question->question_text }}</td>
                        <td class="px-6 py-4 flex gap-2 justify-center">
                            <x-button class="w-16 h-6" label="Edit" icon="pencil-alt" wire:click="editVenue({{ $question->id }})" positive />
                            <x-button class="w-16 h-6" label="Delete" icon="trash" x-on:confirm="{
                                title: 'Delete this question?',
                                icon: 'warning',
                                method: 'deleteVenue',
                                params: {{ $question->id }}
                            }" negative />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No questions added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $venueQuestions->links() }}
        </div>
    </div>

    <x-modal wire:model.defer="add_venue_modal">
        <x-card title="Add Venue Question">
            <x-input label="Question" wire:model="venue_question_text" />
            <x-slot name="footer">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button label="Add" wire:click="addVenueQuestion" teal />
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal wire:model.defer="edit_venue_modal">
        <x-card title="Edit Venue Question">
            <x-input label="Question" wire:model="venue_question_text" />
            <x-slot name="footer">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button label="Update" wire:click="updateVenueQuestion" emerald />
            </x-slot>
        </x-card>
    </x-modal>
</div>
