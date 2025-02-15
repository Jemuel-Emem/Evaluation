<div>
    <div class="max-w-7xl mx-auto p-6">
        {{-- <div class="flex justify-end mb-4">
            <x-button label="Create Evaluation" teal icon="plus" wire:click="$set('add_modal', true)" />
        </div> --}}
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

            @dump($selected_category)
        </div>
        <div class="relative overflow-x-auto bg-gray-200 p-4 rounded-lg shadow-md">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">Program Activity</th>
                        <th class="px-6 py-3">Venue</th>
                        <th class="px-6 py-3">Accommodation</th>
                        <th class="px-6 py-3">Speaker</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($evaluations as $evaluation)
                        <tr class="border-b">
                            <td class="px-6 py-4">{{ $evaluation->event->eventname }}</td>
                            <td class="px-6 py-4">
                                {{ $evaluation->programActivity ? 'Yes' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->venue ? 'Yes' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->accommodation ? 'Yes' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $evaluation->speaker ? 'Yes' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <x-button label="Edit" icon="pencil" wire:click="edit({{ $evaluation->id }})" positive />
                                <x-button label="Delete" icon="trash" wire:click="delete({{ $evaluation->id }})" negative />
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No evaluations found</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div>{{ $evaluations->links() }}</div> --}}
        </div>

        <x-modal wire:model.defer="add_modal">
            <x-card title="Create Evaluation">
                <div class="space-y-4">
                    <x-native-select label="Event" wire:model="event_id">
                        <option value="">-- Select Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->eventname }}</option>
                        @endforeach
                    </x-native-select>

                    <div class="mt-5">
                        @foreach ($categories as $item)
                            <x-checkbox id="{{ $item->id }}" label="{{ $item->name }}"
                                wire:model="selected_category" value="{{ $item->id }}" />
                        @endforeach
                    </div>
                </div>

                <x-slot name="footer">
                    <x-button label="Cancel" flat wire:click="resetForm" />
                    <x-button label="Save Evaluation" wire:click="addForm" teal />
                </x-slot>
            </x-card>
        </x-modal>

        <x-modal wire:model.defer="edit_modal">
            <x-card title="Edit Evaluation">
                <div class="space-y-4">
                    <x-native-select label="Event" wire:model="event_id">
                        <option value="">-- Select Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->eventname }}</option>
                        @endforeach
                    </x-native-select>

                    <x-checkbox label="Select Program Activity" wire:model="selectedQuestions.program_activity"
                        value="1" />
                    <x-checkbox label="Select Venue" wire:model="selectedQuestions.venue" value="2" />
                    <x-checkbox label="Select Accommodation" wire:model="selectedQuestions.accommodation"
                        value="3" />
                    <x-checkbox label="Select Speaker" wire:model="selectedQuestions.speaker" value="4" />
                </div>

                <x-slot name="footer">
                    <x-button label="Cancel" flat wire:click="resetForm" />
                    <x-button label="Update Evaluation" wire:click="update" teal />
                </x-slot>
            </x-card>
        </x-modal>

    </div>

</div>
