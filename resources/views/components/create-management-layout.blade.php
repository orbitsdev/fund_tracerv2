<div>
    {{-- @can('is-admin')
    <div>
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>

          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-dost focus:outline-none focus:ring-indigo-500 sm:text-sm">
            <option>Applied</option>
            <option>Phone Screening</option>
            <option selected>Interview</option>
            <option>Offer</option>
            <option>Disqualified</option>
          </select>
        </div>
        <div class="hidden sm:block">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">



              <a href="{{route('program.index')}}" class="{{(request()->routeIs('program.index')||request()->routeIs('program.create')|| request()->routeIs('program.edit') ) ? 'border-dost dost-text flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium' : 'border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'}}" >
                Programs
                @if (\App\Models\Program::count() >0)
                <span class="{{(request()->routeIs('program.index')||request()->routeIs('program.create') || request()->routeIs('program.edit')) ? 'dost-bg text-white ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block' : 'bg-gray-100 text-gray-900 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block'}} ">

                {{ \App\Models\Program::count() }}

            </span>
            @endif
              </a>

              <a href="{{route('project.index')}}" class="{{( request()->routeIs('project.index')|| request()->routeIs('project.create')|| request()->routeIs('project.edit') || request()->routeIs('project.line-item-budget') || request()->routeIs('project.line-items')  ) ? 'border-dost dost-text flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium' : 'border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'}}" >
                Projects
                @if (\App\Models\Project::count() >0)
                <span class="{{(request()->routeIs('project.index')||request()->routeIs('project.create') || request()->routeIs('project.edit') || request()->routeIs('project.line-item-budget') || request()->routeIs('project.line-items') ) ? 'dost-bg text-white ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block' : 'bg-gray-100 text-gray-900 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block'}} ">

                {{ \App\Models\Project::count() }}

            </span>
            @endif
              </a>

            </nav>
          </div>
        </div>
      </div>


      <div class="mt-4">
        <p class="text-2xl ">
            {{ $header ?? '' }}

        </p>
      </div>
      @endcan --}}

      {{-- <nav class="hidden sm:flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
          <li>
            <div class="flex">
              <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-700">Jobs</a>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
              </svg>
              <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Engineering</a>
            </div>
          </li>
          <li>
            <div class="flex items-center">
              <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
              </svg>
              <a href="#" aria-current="page" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Back End Developer</a>
            </div>
          </li>
        </ol>
      </nav> --}}

      <div class=" md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
          <h2 class="text-2xl font-bold leading-7 text-system-700 sm:truncate sm:text-3xl sm:tracking-tight">  {{ $title ?? '' }}</h2>
        </div>

      </div>



    <div class="my-auto mt-8">
        {{ $slot }}
    </div>


</div>
