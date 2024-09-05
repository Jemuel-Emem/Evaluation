<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Filter Section -->
    {{-- <div class="mb-6">
        <label for="eventFilter" class="block text-lg font-semibold text-gray-700">Select Event</label>
        <div class="flex items-center space-x-4">
            <select wire:model="selectedEvent" id="eventFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">All Events</option>
                @foreach($eventsList as $event)
                    <option value="{{ $event->eventname }}">{{ $event->eventname }}</option>
                @endforeach
            </select>

            <button wire:click="view" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">View</button>
        </div>
    </div> --}}

    <!-- Event Ratings Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
        @foreach ($eventRatings as $index => $event)
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Event Name:{{ $event->eventname }}</h3>
                Total Users Evaluated: {{ $event->total_responses }}
                <canvas id="chart{{ $index }}" class="w-full h-56"></canvas>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx{{ $index }} = document.getElementById('chart{{ $index }}').getContext('2d');

                    var data{{ $index }} = {
                        labels: ['Strongly Agree', 'Agree', 'Moderately Agree', 'Disagree', 'Strongly Disagree'],
                        datasets: [{
                            label: '{{ $event->eventname }}',
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(153, 102, 255, 0.6)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1,
                            data: [
                                {{ number_format($event->stronglyagree_percentage, 2) }},
                                {{ number_format($event->agree_percentage, 2) }},
                                {{ number_format($event->moderatelyagree_percentage, 2) }},
                                {{ number_format($event->disagree_percentage, 2) }},
                                {{ number_format($event->strongdisagree_percentage, 2) }}
                            ],
                        }]
                    };

                    var options{{ $index }} = {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                                    }
                                }
                            }
                        }
                    };

                    var myPieChart{{ $index }} = new Chart(ctx{{ $index }}, {
                        type: 'pie',
                        data: data{{ $index }},
                        options: options{{ $index }}
                    });
                });
            </script>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $eventRatings->links() }}
    </div>
</div>
