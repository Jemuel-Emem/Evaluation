<div class="">
    @foreach ($eventRatings as $event)
    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Event Name: {{ $event->eventname }}</h3>

        <p class="text-gray-700"><strong>Total Users Evaluated:</strong> {{ $event->total_respondents }}</p>
        <div class="mt-4 bg-gray-100 p-4 rounded-lg">
            <h4 class="text-lg font-semibold">Overall Satisfaction</h4>
            @php
                $totalResponses = $event->stronglyagree + $event->agree + $event->moderatelyagree + $event->disagree + $event->stronglydisagree;
                $satisfied = $event->stronglyagree + $event->agree + $event->moderatelyagree ;
                $notSatisfied =  $event->disagree + $event->stronglydisagree;

                $satisfiedPercentage = $totalResponses > 0 ? ($satisfied / $totalResponses) * 100 : 0;
                $notSatisfiedPercentage = $totalResponses > 0 ? ($notSatisfied / $totalResponses) * 100 : 0;
            @endphp

            <p class="text-green-600">✅ Satisfied: <strong>{{ number_format($satisfiedPercentage, 2) }}%</strong></p>
            <p class="text-red-600">❌ Not Satisfied: <strong>{{ number_format($notSatisfiedPercentage, 2) }}%</strong></p>
        </div>

        <!-- Event Ratings -->
<div class="flex gap-4">



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

    <div class="mt-4">
        <h4 class="text-lg font-semibold">General Ratings</h4>
        <p class="text-green-600">5. Strongly Agree: <strong>{{ $event->stronglyagree }}</strong></p>
        <p class="text-blue-600">4. Agree: <strong>{{ $event->agree }}</strong></p>
        <p class="text-yellow-600">3. Moderately Agree: <strong>{{ $event->moderatelyagree }}</strong></p>
        <p class="text-red-600">2. Disagree: <strong>{{ $event->disagree }}</strong></p>
        <p class="text-purple-600">1. Strongly Disagree: <strong>{{ $event->stronglydisagree }}</strong></p>
    </div>
</div>

<div>


    @foreach ($eventRatings as $event)
    <div class="">
  <!-- Fetch and Display Questions with Ratings -->
        @php
            $eventQuestions = DB::table('category_questions')
                ->join('categories', 'category_questions.category_id', '=', 'categories.id')
                ->join('evaluation_forms', 'categories.id', '=', 'evaluation_forms.category_id')
                ->where('evaluation_forms.event_id', function ($query) use ($event) {
                    $query->select('id')->from('events')->where('eventname', $event->eventname)->limit(1);
                })
                ->select('category_questions.id as question_id', 'category_questions.question', 'categories.name as category_name')
                ->get();

                $programRatings = DB::table('program_activity_ratings')
    ->where('eventname', $event->eventname)
    ->selectRaw('SUM(stronglyagree) as stronglyagree, SUM(agree) as agree, SUM(moderatelyagree) as moderatelyagree, SUM(disagree) as disagree, SUM(stronglydisagree) as stronglydisagree')
    ->first();

$venueRatings = DB::table('venue_ratings')
    ->where('eventname', $event->eventname)
    ->selectRaw('SUM(stronglyagree) as stronglyagree, SUM(agree) as agree, SUM(moderatelyagree) as moderatelyagree, SUM(disagree) as disagree, SUM(stronglydisagree) as stronglydisagree')
    ->first();

$accommodationRatings = DB::table('accomodations_ratings')
    ->where('eventname', $event->eventname)
    ->selectRaw('SUM(stronglyagree) as stronglyagree, SUM(agree) as agree, SUM(moderatelyagree) as moderatelyagree, SUM(disagree) as disagree, SUM(stronglydisagree) as stronglydisagree')
    ->first();

$speakerRatings = DB::table('speaker_ratings')
    ->where('eventname', $event->eventname)
    ->selectRaw('SUM(stronglyagree) as stronglyagree, SUM(agree) as agree, SUM(moderatelyagree) as moderatelyagree, SUM(disagree) as disagree, SUM(stronglydisagree) as stronglydisagree')
    ->first();


        @endphp

        <div class="mt-6">

            <div class="mt-6">
                <h3 class="text-lg font-semibold">Evaluation Questions & Ratings</h3>

                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Category</th>
                            <th class="py-2 px-4 border-b text-left">Question</th>
                            <th class="py-2 px-4 border-b text-center">Strongly Agree</th>
                            <th class="py-2 px-4 border-b text-center">Agree</th>
                            <th class="py-2 px-4 border-b text-center">Moderately Agree</th>
                            <th class="py-2 px-4 border-b text-center">Disagree</th>
                            <th class="py-2 px-4 border-b text-center">Strongly Disagree</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventQuestions as $question)
                            @php
                                $ratings = match ($question->category_name) {
                                    'Program Activities' => $programRatings,
                                    'Venue' => $venueRatings,
                                    'Accommodations' => $accommodationRatings,
                                    'Speakers' => $speakerRatings,
                                    default => null,
                                };
                            @endphp

                            <tr class="border-b">
                                <td class="py-2 px-4 border-r text-left font-semibold">{{ $question->category_name }}</td>
                                <td class="py-2 px-4 border-r text-left">{{ $question->question }}</td>

                                @if ($ratings)
                                    <td class="py-2 px-4 text-center text-green-600">{{ $ratings->stronglyagree }}</td>
                                    <td class="py-2 px-4 text-center text-blue-600">{{ $ratings->agree }}</td>
                                    <td class="py-2 px-4 text-center text-yellow-600">{{ $ratings->moderatelyagree }}</td>
                                    <td class="py-2 px-4 text-center text-red-600">{{ $ratings->disagree }}</td>
                                    <td class="py-2 px-4 text-center text-purple-600">{{ $ratings->stronglydisagree }}</td>
                                @else
                                    <td class="py-2 px-4 text-center text-gray-500" colspan="5">No ratings available</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endforeach




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

            // Get the context for the bar chart
            var ctx{{ $loop->index }} = document.getElementById('chart{{ $loop->index }}').getContext('2d');

            // Prepare the data for the chart
            var data{{ $loop->index }} = {
                labels: ['Strongly Agree', 'Agree', 'Moderately Agree', 'Disagree', 'Strongly Disagree'],
                datasets: [{
                    label: '{{ $event->eventname }} Ratings (%)',
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)', // Strongly Agree
                        'rgba(54, 162, 235, 0.6)', // Agree
                        'rgba(255, 206, 86, 0.6)', // Moderately Agree
                        'rgba(255, 99, 132, 0.6)', // Disagree
                        'rgba(153, 102, 255, 0.6)' // Strongly Disagree
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
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100, // Since it's percentage-based
                        title: {
                            display: true,
                            text: 'Percentage (%)'
                        }
                    }
                },
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

            // Create the bar chart
            var myBarChart{{ $loop->index }} = new Chart(ctx{{ $loop->index }}, {
                type: 'bar', // Changed from 'pie' to 'bar'
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
