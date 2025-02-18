<div class="">
    @foreach ($eventRatings as $event)
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Event Name: {{ $event->eventname }}</h3>

        <p class="text-gray-700"><strong>Total Users Evaluated:</strong> {{ $event->total_respondents }}</p>

        <!-- Event Ratings -->
<div class="flex gap-4">

    <div class="mt-4">
        <h4 class="text-lg font-semibold">General Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->stronglydisagree }}</strong></p>
    </div>

    <!-- Program Activity Ratings -->
    <div class="mt-4">
        <h4 class="text-lg font-semibold">Program Activity Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->program_stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->program_agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->program_moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->program_disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->program_stronglydisagree }}</strong></p>
    </div>

    <!-- Venue Ratings -->
    <div class="mt-4">
        <h4 class="text-lg font-semibold">Venue Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->venue_stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->venue_agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->venue_moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->venue_disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->venue_stronglydisagree }}</strong></p>
    </div>

    <!-- Accommodation Ratings -->
    <div class="mt-4">
        <h4 class="text-lg font-semibold">Accommodation Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->accommodation_stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->accommodation_agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->accommodation_moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->accommodation_disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->accommodation_stronglydisagree }}</strong></p>
    </div>

    <!-- Speaker Ratings -->
    <div class="mt-4">
        <h4 class="text-lg font-semibold">Speaker Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->speaker_stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->speaker_agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->speaker_moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->speaker_disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->speaker_stronglydisagree }}</strong></p>
    </div>
</div>

        <!-- Pie Chart for Event Ratings -->
        <canvas id="chart{{ $loop->index }}" class="w-full h-56"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Calculate total responses for the event
            var totalEventResponses = {{ $event->stronglyagree }} + {{ $event->agree }} + {{ $event->moderatelyagree }} + {{ $event->disagree }} + {{ $event->stronglydisagree }};

            // Calculate percentage for each rating
            var stronglyAgreePercent = totalEventResponses > 0 ? ({{ $event->stronglyagree }} / totalEventResponses) * 100 : 0;
            var agreePercent = totalEventResponses > 0 ? ({{ $event->agree }} / totalEventResponses) * 100 : 0;
            var moderatelyAgreePercent = totalEventResponses > 0 ? ({{ $event->moderatelyagree }} / totalEventResponses) * 100 : 0;
            var disagreePercent = totalEventResponses > 0 ? ({{ $event->disagree }} / totalEventResponses) * 100 : 0;
            var stronglyDisagreePercent = totalEventResponses > 0 ? ({{ $event->stronglydisagree }} / totalEventResponses) * 100 : 0;

            // Get the context for the pie chart
            var ctx{{ $loop->index }} = document.getElementById('chart{{ $loop->index }}').getContext('2d');

            // Prepare the data for the chart
            var data{{ $loop->index }} = {
                labels: ['Strongly Agree', 'Agree', 'Moderately Agree', 'Disagree', 'Strongly Disagree'],
                datasets: [{
                    label: '{{ $event->eventname }} Ratings',
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Strongly Agree
                        'rgba(54, 162, 235, 0.6)', // Agree
                        'rgba(255, 206, 86, 0.6)', // Moderately Agree
                        'rgba(255, 99, 132, 0.6)', // Disagree
                        'rgba(153, 102, 255, 0.6)' // Strongly Disagree
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)', // Strongly Agree
                        'rgba(54, 162, 235, 1)', // Agree
                        'rgba(255, 206, 86, 1)', // Moderately Agree
                        'rgba(255, 99, 132, 1)', // Disagree
                        'rgba(153, 102, 255, 1)' // Strongly Disagree
                    ],
                    borderWidth: 1,
                    data: [
                        stronglyAgreePercent,
                        agreePercent,
                        moderatelyAgreePercent,
                        disagreePercent,
                        stronglyDisagreePercent
                    ],
                }]
            };

            // Configure the chart options
            var options{{ $loop->index }} = {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%'; // Display percentage with two decimals
                            }
                        }
                    }
                }
            };

            // Create the pie chart
            var myPieChart{{ $loop->index }} = new Chart(ctx{{ $loop->index }}, {
                type: 'pie',
                data: data{{ $loop->index }},
                options: options{{ $loop->index }}
            });
        });
    </script>

@endforeach

<div class="mt-6">
    {{ $eventRatings->links() }}
</div>
</div>
