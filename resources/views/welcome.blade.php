<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evaluation Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased">
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-green-200 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

    @if (Route::has('login'))
        <livewire:welcome.navigation/>
    @endif


    <div class="max-w-7xl mx-auto p-6 sm:p-12 text-center" x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white transition-transform duration-700 transform" x-bind:class="show ? 'translate-y-0' : '-translate-y-10'">Evaluation Management System</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 opacity-0 transition-opacity duration-700 delay-300" x-bind:class="show ? 'opacity-100' : 'opacity-0'">
            The Evaluation Management System allows organizations to create, manage, and evaluate various events. Users can submit evaluations, and administrators can monitor feedback with ease, all in one platform.
        </p>


        <div class="mt-8 opacity-0 transition-opacity duration-1000 delay-500" x-bind:class="show ? 'opacity-100' : 'opacity-0'">
            <img src="{{ asset('images/sksu.jpg') }}" alt="Evaluation Management System" class="w-full max-w-sm mx-auto shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-500">
        </div>


        <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 opacity-0 transition-opacity duration-1000 delay-700" x-bind:class="show ? 'opacity-100' : 'opacity-0'">
            From generating reports to analyzing participant feedback, our system is designed to improve your event planning and evaluation process. Get insights into attendee satisfaction with comprehensive reporting features.
        </p>



    </div>
</div>

<script>

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
</body>
</html>
