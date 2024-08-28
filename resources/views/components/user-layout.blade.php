<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css"
    rel="stylesheet"/>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @wireUiScripts
    @livewireStyles

</head>

<body class="font-sans antialiased md:h-screen  bg-no-repeat bg-green-100">
    @livewireScripts
    <x-dialog />

    <div class="justify-center w-full mx-auto bg-gradient-to-r from-emerald-700 to-teal-400">
        <div x-data="{ open: false }" class="flex flex-col w-full px-8 py-2 mx-auto md:px-12 md:items-center md:justify-between md:flex-row lg:px-32 max-w-8xl">
          <div class="flex flex-row items-center justify-between text-black">
            <a class="inline-flex items-center gap-3 text-xl font-bold tracking-tight text-black" href="/">
              <span>  <img src="{{ asset('images/logo.jpg') }}" alt="" class="w-12 h-12 border-collapse rounded-xl"></span>
              <span class="text-white">EVENTCONNECT</span>
            </a>
            <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
              <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <nav :class="{'flex': open, 'hidden': !open}" class="flex-col items-center flex-grow hidden gap-3 p-4 px-5 text-sm font-medium text-gray-500 md:px-0 md:pb-0 md:flex md:justify-start md:flex-row lg:p-0 md:mt-0">

            <a class="hover:text-green-500 focus:outline-none text-white md:ml-auto" href="{{ route('evaluate-form') }}">Evaluate
            </a>
            <a class="hover:text-green-500 focus:outline-none text-white md:mr-auto" href="{{ route('about') }}">About
            </a>
            <a class="hover:text-green-500 focus:outline-none text-white md:ml-auto" href="{{ route('userdashboard') }}">Home
            </a>
            <a class="inline-flex items-center justify-center w-full h-8 gap-3 px-5 py-3 text-xs font-medium text-white duration-200  rounded-lg md:w-auto " href="#_" role="button">
                <x-dropdown>
                    <x-slot name="trigger">
                        <x-avatar sm src="https://picsum.photos/300?size=sm" />
                    </x-slot>
                    <x-dropdown.item separator label="Logout" href="{{ route('logout') }}"/>
                </x-dropdown>

            </a>
          </nav>
        </div>
      </div>



        <div class=" border-gray-200  rounded-lg dark:border-gray-700 max-h-max">
            <main class="">
                {{ $slot }}

            </main>

           </div>

           @livewireScripts
</body>

</html>
