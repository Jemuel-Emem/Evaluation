<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
        @foreach ($eventRatings as $index => $event)
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Event Name: {{ $event->eventname }}</h3>

                <p class="text-gray-700"><strong>Total Users Evaluated:</strong> {{ $event->total_respondents }}</p>


                <div class="mt-4">
                    <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->stronglyagree }}</strong></p>
                    <p class="text-blue-600">4. Agree: <strong>{{ $event->agree }}</strong></p>
                    <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->moderatelyagree }}</strong></p>
                    <p class="text-red-600">2. Disagree: <strong>{{ $event->disagree }}</strong></p>
                    <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->strongdisagree }}</strong></p>
                </div>

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
                                {{ $event->stronglyagree_percentage }},
                                {{ $event->agree_percentage }},
                                {{ $event->moderatelyagree_percentage }},
                                {{ $event->disagree_percentage }},
                                {{ $event->strongdisagree_percentage }}
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
