
<div>
    {{-- <x-alert class="bg-green-700 text-green-100 p-4" /> --}}

      <div class="flex justify-end">

       <x-button label="Add Events" teal icon="plus" wire:click="$set('add_modal', true)" />
      </div>

       <div class="relative overflow-x-auto mt-4">
           <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-gray-200 ">
               <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                   <tr>
                       <th scope="col" class="px-6 py-3">
                        Event Name
                        </th>

                       <th scope="col" class="px-6 py-3 text-center">
                           Action
                       </th>
                   </tr>
               </thead>
               <tbody>
                  @forelse($events as $q)
                   <tr>

                       <td class="px-6 py-4">{{ $q->eventname }}</td>

                      <td class="px-6 py-4 flex gap-2 mt-4 justify-center">
                           <x-button class="w-16 h-6" label="edit" icon="pencil-alt" wire:click="edit({{ $q->id }})" positive />
                               <x-button class="w-16 h-6" label="delete" icon="pencil-alt"
                               x-on:confirm="{
                                   title: 'Sure Delete?',
                                   icon: 'warning',
                                   method: 'delete',
                                   params: {{ $q->id }}
                               }" negative />
                       </td>

                   </tr>
                   @empty
                   <tr>
                       <td colspan="10">No data</td>
                   </tr>
               @endforelse
               </tbody>
           </table>
         <div>
             {{ $events->links() }}
           </div>
       </div>

       <x-modal wire:model.defer="add_modal">
           <x-card title="Add Agent">
               <div class="space-y-3">

                   <x-input label="Event Name" placeholder="" wire:model="eventname" />


               </div>

               <x-slot name="footer">
                   <div class="flex justify-end gap-x-4">
                       <x-button flat label="Cancel" x-on:click="close"  />
                       <x-button  label="Add Event" wire:click="addevent"  teal />
                   </div>
               </x-slot>
           </x-card>
       </x-modal>


       <x-modal wire:model.defer="edit_modal">
           <x-card title="Add Agent">
               <div class="space-y-3">

                   <x-input label="Event Name" placeholder="" wire:model="eventname" />


               </div>

               <x-slot name="footer">
                   <div class="flex justify-end gap-x-4">
                       <x-button flat label="Cancel" x-on:click="close"  />
                       <x-button  label="Update Event" wire:click="updateevent" spinner="" emerald />
                   </div>
               </x-slot>
           </x-card>
       </x-modal>
   </div>

