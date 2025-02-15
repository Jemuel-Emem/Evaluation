<div>

    {{-- Success Message Alert --}}
    {{-- <x-alert class="bg-green-700 text-green-100 p-4" /> --}}

    <div class="flex justify-between">
        <h1 class="font-bold uppercase">{{ $cat_name }}</h1>
        <x-button label="Add Question" teal icon="plus" wire:click="$set('add_modal', true)" />
    </div>

    {{-- Table --}}
    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left text-gray-500 bg-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Question</th>
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td class="px-6 py-4">{{ $question->question }}</td>
                        <td class="px-6 py-4 flex gap-2 justify-center">
                            <x-button class="w-16 h-6" label="Edit" icon="pencil-alt"
                                wire:click="edit({{ $question->id }})" positive />
                            <x-button class="w-16 h-6" label="Delete" icon="trash"
                                x-on:confirm="{
                                    title: 'Sure Delete?',
                                    icon: 'warning',
                                    method: 'delete',
                                    params: {{ $question->id }}
                                }"
                                negative />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No questions available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $questions->links() }}
        </div>
    </div>

    {{-- Add Modal --}}
    <x-modal wire:model.defer="add_modal">
        <x-card title="Add Question">
            <div class="space-y-3">
                <x-input label="Question Text" placeholder="Enter question" wire:model="question_text" />
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Add Question" wire:click="addquestion" teal />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    {{-- Edit Modal --}}
    <x-modal wire:model.defer="edit_modal">
        <x-card title="Edit Question">
            <div class="space-y-3">
                <x-input label="Question Text" placeholder="Enter question" wire:model="question_text" />
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button label="Update Question" wire:click="updatequestion" spinner="" emerald />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

</div>
