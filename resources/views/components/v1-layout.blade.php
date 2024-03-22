    <div>


        <div class="hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col custom-nav">

            <div class="flex grow flex-col gap-y-5 overflow-y-auto   px-6 pb-4">
                <div class="flex items-center justify-center h-16  text-white">
                    <img class="h-10 w-auto mr-4" src="{{ asset('images/dost.png') }}" alt="DOST Logo">
                    <img class="h-10 w-auto mr-4" src="{{ asset('images/sksu.png') }}" alt="SKSU Logo">
                    <p class="text-lg font-semibold tex-white">Fund Tracer</p>
                </div>

                <nav class="flex flex-1 flex-col">

                    @can('is-financial-manager')
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <div class="text-xs  leading-6 text-[#72def1]">Auhtorize Features </div>
                                <a href="{{ route('financial-manager.projects') }}"
                                    class="
                {{ request()->routeIs('financial-manager.projects') || request()->routeIs('project.line-item-budget') || request()->routeIs('project.line-items') || request()->routeIs('project.line-items-view') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
               ">


                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                    </svg>



                                    Manage Project Budget
                                </a>
                            </li>
                        </ul>
                    @endcan

                    @can('is-admin')
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <div class="text-xs  leading-6 text-[#72def1]">Access Management</div>
                                <a href="{{ route('manage.users') }}"
                                    class="
                {{ request()->routeIs('manage.users') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
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
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" @keydown.escape="isOpen = false">
                                <div class="text-xs leading-6 text-[#72def1]">Management</div>
                                <ul role="list" class="">
                                    <li>
                                        <button @click="isOpen = !isOpen"
                                            :class="{ 'bg-[#ffff]  text-gray-900 w-full block drop-shadow-xl font-bold transition duration-300 ease-in-out': isOpen, 'w-full text-white ': !isOpen }"
                                            class="group flex gap-x-3 rounded-md p-2  text-sm leading-6 transition focus:outline-none">
                                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-bold border-[#003449] ">C</span>
                                            <span class="truncate">Create</span>
                                        </button>
                                        <ul x-show="isOpen" style="max-height: 20rem; overflow-y: auto;"
                                            class="mt-2 py-2 w-full bg-white rounded-lg shadow-md z-10 transition-opacity duration-500 ease-in-out">

                                            <li>
                                                <a href="{{ route('program.index') }}"
                                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                    Programs View</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('project.index') }}"
                                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                                                    Projects View</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="{{ route('manage.financial-transactions') }}"
                                class="{{ request()->routeIs('manage.financial-transactions') ? ' bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                FR Transactions
                            </a>
                        </li>








                            <li>
                                <div class="text-xs  leading-6 text-[#72def1]">Content Management</div>
                                <ul role="list" class="-mx-2 space-y-1">

                                    <li>
                                        <a href="{{ route('manage.content-management') }}"
                                            class="
                {{ request()->routeIs('manage.content-management') || request()->routeIs('personal-service.index') || request()->routeIs('mooe.index') ? ' bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
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
                  {{ request()->routeIs('manage.implementing-agencies') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
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
                  {{ request()->routeIs('manage.monitoring-agencies') ? '  bg-[#ffff]  drop-shadow-xl shadow-lg shadow-[#028baf]/50 text-gray-900 font-bold   transition ' : 'text-white' }}  group flex gap-x-3 rounded-md p-2 text-sm leading-6 transition
                 ">


                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
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
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>




            <div class="flex flex-1 gap-x-4 ">

                    <div class="hidden lg:block  lg:w-px lg:bg-gray-200" aria-hidden="true"></div>
                    @livewire('navigation-menu')
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
                    {{ $slot }}
                </div>
            </main>


        </div>
    </div>
