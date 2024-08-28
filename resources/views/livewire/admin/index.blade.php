<div class="grid grid-cols-2">
    @foreach ($eventRatings as $index => $event)
        <div class="p-2 w-9/12 ">
            <h3>{{ $event->eventname }}</h3>
            <canvas id="chart{{ $index }}" style="width: 100px;"></canvas>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx{{ $index }} = document.getElementById('chart{{ $index }}').getContext('2d');

                var data{{ $index }} = {
                    labels: ['Strongly Agree', 'Agree', 'Moderately Agree', 'Disagree', 'Strongly Disagree'],
                    datasets: [{
                        label: '{{ $event->eventname }}',
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
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
