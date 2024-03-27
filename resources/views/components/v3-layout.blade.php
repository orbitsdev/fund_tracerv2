<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<div class="min-h-full ">



    <nav class="bg-trust-800 sticky top-0  z-20">
        <div class="mx-auto max-w-7xl ">
            <div class="flex h-16 items-center justify-between">
              <div class="flex items-center">
                <div class="flex">
                  <img class="h-8 w-8 mr-4" src="{{asset('images/sksu.png')}}" alt="Your Company">
                  <img class="h-8 w-8" src="{{asset('images/dost.png')}}" alt="Your Company">
                </div>
                <div class="hidden md:block">
                  <div class="ml-10 flex items-baseline space-x-4">
                    <!-- Current: "bg-trust-700 text-white", Default: "text-white hover:bg-trust-500 hover:bg-opacity-75" -->
                    <a href="{{route('manage.users')}}" class="
                    {{ request()->routeIs('manage.users') ? 'link-active' : 'link-inactive' }}" aria-current="page">Accounts</a>
                    <a href="{{ route('project.index') }}" class=" {{ (request()->routeIs('project.index') || request()->routeIs('project.create') || request()->routeIs('project.edit') || request()->routeIs('project.line-item-budget') || request()->routeIs('project.line-items-view') || request()->routeIs('project.line-items') || request()->routeIs('line-items-view-v3')  ) ? 'link-active' : 'link-inactive' }}">Projects</a>
                    <a href="{{route('manage.content-management')}}" class="
                    {{ (request()->routeIs('personal-service.index') || request()->routeIs('personal-service.edit') || request()->routeIs('mooe.index')|| request()->routeIs('mooe.edit')|| request()->routeIs('mooe.expense.list')|| request()->routeIs('mooe.edit.expense.mooe') ||  request()->routeIs('manage.content-management') ||  request()->routeIs('manage.implementing-agencies') ||  request()->routeIs('manage.monitoring-agencies') ||  request()->routeIs('manage.years') ) ? 'link-active' : 'link-inactive' }}">Content Management</a>
                    <a href="#" class="link-inactive">Reports</a>
                    {{-- <a href="#" class="text-white hover:bg-trust-500 hover:bg-opacity-75 rounded-md px-3 py-2 text-sm font-medium">Reports</a> --}}
                  </div>
                </div>
              </div>
              <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                  {{-- <button type="button" class="relative rounded-full bg-trust-600 p-1 text-trust-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-trust-600">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">View notifications</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                  </button> --}}

                  <!-- Profile dropdown -->
                  <div x-data="{ isOpen: false }" class="relative ml-3">
                    <div>
                        <button @click="isOpen = !isOpen" type="button" class="relative flex max-w-xs items-center rounded-full bg-trust-600 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-trust-600" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="{{Auth::user()->getUserImage()}}" alt="">
                        </button>
                    </div>

                    <div x-show="isOpen" @click.away="isOpen = false" @keydown.escape.window="isOpen = false" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a> --}}
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}"
                                     @click.prevent="$root.submit();">
                                {{ __('Sign Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>

                </div>
              </div>
              <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-trust-600 p-2 text-trust-200 hover:bg-trust-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-trust-600" aria-controls="mobile-menu" aria-expanded="false">
                  <span class="absolute -inset-0.5"></span>
                  <span class="sr-only">Open main menu</span>
                  <!-- Menu open: "hidden", Menu closed: "block" -->
                  <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                  </svg>
                  <!-- Menu open: "block", Menu closed: "hidden" -->
                  <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>
          </div>


      <!-- Mobile menu, show/hide based on menu state. -->
     @include('components.v3-nav-small-screen')
    </nav>

    <header class="bg-gray-100 shadow">
      {{-- <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold leading-tight tracking-tight text-gray-900">Dashboard</h1>
      </div> --}}
    </header>
    <main class="mt-8 mx-auto max-w-7xl mb-10 ">
        {{$slot}}

    </main>
  </div>
