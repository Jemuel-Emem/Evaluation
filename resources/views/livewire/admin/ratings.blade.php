<div>
    {{-- <input type="text" wire:model="search" placeholder="Search events..."> --}}
    <div>
        <span class="text-xl font-bold text-gray-600">RATINGS</span>
    </div>
    <div class="grid grid-cols-3 gap-4 mt-4">
        @php
            $colors = ['bg-green-400', 'bg-blue-400', 'bg-red-400', 'bg-yellow-400', 'bg-purple-400'];
        @endphp
        @foreach ($eventRatings as $eventname => $totals)
            @php
                $colorIndex = $loop->index % count($colors);
                $bgColor = $colors[$colorIndex];
            @endphp
            <x-card class="{{ $bgColor }} text-white">
                <div>
                    <h2 class="font-bold text-center uppercase">{{ $eventname }}</h2>
                    <div>
                        @if (isset($totals['stronglyagree']))
                            <div>
                                <strong>Strongly Agree: </strong>{{ $totals['stronglyagree'] }}
                            </div>
                        @endif
                        @if (isset($totals['agree']))
                            <div>
                                <strong>Agree: </strong>{{ $totals['agree'] }}
                            </div>
                        @endif
                        @if (isset($totals['moderatelyagree']))
                            <div>
                                <strong>Moderately Agree: </strong>{{ $totals['moderatelyagree'] }}
                            </div>
                        @endif
                        @if (isset($totals['disagree']))
                            <div>
                                <strong>Disagree: </strong>{{ $totals['disagree'] }}
                            </div>
                        @endif
                        @if (isset($totals['stronglydisagree']))
                            <div>
                                <strong>Strongly Disagree: </strong>{{ $totals['stronglydisagree'] }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <div class="text-center text-sm font-bold mb-2">Graph Representation</div>
                        <div class="flex items-center justify-between bg-gray-200 rounded-lg p-2">
                            @if (isset($totals['stronglyagree']))
                                <div class="bg-blue-400 h-6 rounded-lg" style="width: {{ ($totals['stronglyagree'] / 100) * 100 }}%;"></div>
                            @endif
                            @if (isset($totals['agree']))
                                <div class="bg-green-400 h-6 rounded-lg" style="width: {{ ($totals['agree'] / 100) * 100 }}%;"></div>
                            @endif
                            @if (isset($totals['moderatelyagree']))
                                <div class="bg-yellow-400 h-6 rounded-lg" style="width: {{ ($totals['moderatelyagree'] / 100) * 100 }}%;"></div>
                            @endif
                            @if (isset($totals['disagree']))
                                <div class="bg-red-400 h-6 rounded-lg" style="width: {{ ($totals['disagree'] / 100) * 100 }}%;"></div>
                            @endif
                            @if (isset($totals['stronglydisagree']))
                                <div class="bg-purple-400 h-6 rounded-lg" style="width: {{ ($totals['stronglydisagree'] / 100) * 100 }}%;"></div>
                            @endif
                        </div>
                        <div class="flex justify-between text-xs mt-2">
                            <span>SA</span>
                            <span>A</span>
                            <span>MA</span>
                            <span>D</span>
                            <span>SD</span>
                        </div>
                    </div>
                    <x-button>View actual graph</x-button>
                </div>

            </x-card>
        @endforeach
    </div>

    {{ $ratings->links() }}
</div>
