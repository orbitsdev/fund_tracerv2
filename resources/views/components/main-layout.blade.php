<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->


    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @filamentScripts
    @livewireStyles
</head>

<body class="font-sans antialiased">
    @livewire('notifications')

    <div>

        {{-- @include('dashboard.mobile-nav') --}}

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col custom-nav">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto   px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <img class="h-8 w-auto mr-4" src="{{ asset('images/dost.png') }}" alt="Your Company">
                    <img class="h-8 w-auto mr-4" src="{{ asset('images/sksu.png') }}" alt="Your Company">
                    <p class="text-lg text-white">
                        Fund Tracer

                    </p>
                </div>
                <nav class="flex flex-1 flex-col">

                    @can('is-financial-manager')
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <div class="text-xs  leading-6 text-[#72def1]">Access</div>
                            <a href="{{ route('financial-manager.projects') }}"
                                class="
                {{ request()->routeIs('financial-manager.projects') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
               ">


                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>



                                Assigned Projects
                            </a>
                        </li>
                    </ul>
                    @endcan

                    @can('is-admin')


                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <div class="text-xs  leading-6 text-[#72def1]">Access</div>
                            <a href="{{ route('manage.users') }}"
                                class="
                {{ request()->routeIs('manage.users') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
               ">


                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>



                                Users & Permissions
                            </a>
                        </li>

                        <li>
                            <div class="text-xs  leading-6 text-[#72def1]">Management</div>
                            <ul role="list" class="-mx-2 mt-2 space-y-1">

                                <li>
                                    <!-- Current: " bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition", Default: "text-gray-700 hover:text-[#003449] hover:bg-gray-50" -->
                                    <a href="{{ route('manage.program-project') }}"
                                        class="
                    {{ request()->routeIs('manage.program-project') || request()->routeIs('program.index') || request()->routeIs('program.create') || request()->routeIs('program.edit') || request()->routeIs('project.index') || request()->routeIs('project.create') || request()->routeIs('project.edit') || request()->routeIs('project.line-item-budget') || request()->routeIs('project.line-items') ? ' bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
                   ">
                                        <span
                                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-bold border-[#003449] text-blue0-700 ">C</span>
                                        <span class="truncate">Create</span>
                                    </a>
                                </li>




                            </ul>
                        </li>

                        <li>
                            <div class="text-xs  leading-6 text-[#72def1]">Content Management</div>
                            <ul role="list" class="-mx-2 space-y-1">

                                <li>
                                    <a href="{{ route('manage.program-project') }}"
                                        class="
                  {{ request()->routeIs('manage.program-project') || request()->routeIs('personal-service.index') || request()->routeIs('mooe.index') ? ' bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
                 ">


                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>


                                        Particulars Options
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('manage.implementing-agencies') }}"
                                        class="
                  {{ request()->routeIs('manage.implementing-agencies') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
                 ">




                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>


                                        Implementing Agencies
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('manage.monitoring-agencies') }}"
                                        class="
                  {{ request()->routeIs('manage.monitoring-agencies') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-[#003449] font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
                 ">




                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                        </svg>



                                        Monitoring Agencies
                                    </a>
                                </li>


                            </ul>
                        </li>


                    </ul>
                    @endcan
                </nav>
            </div>
        </div>

        <div class="lg:pl-[287px] ">
            <div class="sticky top-nav top-0 z-20 flex h-16 shrink-0 items-center  shadow-sm ">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Separator -->


                <div class="flex flex-1 gap-x-4 ">

                    <div class="hidden lg:block  lg:w-px lg:bg-gray-200" aria-hidden="true"></div>
                    @livewire('navigation-menu')
                </div>
            </div>

            <main class="py-10">
                <div class="max-w-8xl  m-auto px-8 ">
                    {{ $slot }}
                    <!-- Your content -->
                </div>
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>

</html>
