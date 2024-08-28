<div>
    <div class="flex justify-end">
        <x-button label="Add Survey Questionnaire" teal icon="plus" wire:click="$set('add_modal', true)" />
    </div>

    <div class="relative overflow-x-auto mt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Question</th>
                    <th scope="col" class="px-6 py-3">Event Name</th>
                    {{-- <th scope="col" class="px-6 py-3">Date</th> --}}
                    <th scope="col" class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveys as $survey)
                    <tr>
                        <td class="px-6 py-4">{{ $survey->questtion }}</td>
                        <td class="px-6 py-4">{{ $survey->eventname }}</td>
                        {{-- <td class="px-6 py-4">{{ $survey->created_at->format('Y-m-d') }}</td> --}}
                        <td class="px-6 py-4 flex gap-2 mt-4 justify-center">
                            <x-button class="w-16 h-6" label="edit" icon="pencil-alt" wire:click="edit({{ $survey->id }})" positive />
                            <x-button class="w-16 h-6" label="delete" icon="trash" x-on:confirm="{
                                title: 'Sure Delete?',
                                icon: 'warning',
                                method: 'delete',
                                params: {{ $survey->id }}
                            }" negative />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center">No data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $surveys->links() }}
        </div>
    </div>

    <x-modal wire:model.defer="add_modal">
        <x-card title="Add Survey Questionnaire">
            <div class="space-y-3">
                <x-native-select
                label="Select Events"
                wire:model.defer="eventname"
                :options="['' => 'None'] + $events->pluck('eventname', 'id')->toArray()"
            />
                <x-input label="Question" placeholder="Enter your question" wire:model="question" />
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close"  />
                    <x-button label="Add Survey" wire:click="addSurvey" teal />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <x-modal wire:model.defer="edit_modal">
        <x-card title="Edit Survey Questionnaire">
            <div class="space-y-3">
                <x-native-select
                label="Select Events"
                wire:model.defer="eventname"
                :options="['' => 'None'] + $events->pluck('eventname', 'id')->toArray()"
            />
                <x-input label="Question" placeholder="Enter your question" wire:model="question" />
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close"  />
                    <x-button label="Update Event" wire:click="updateSurvey" spinner="" emerald />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
