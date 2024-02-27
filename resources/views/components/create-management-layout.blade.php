<div>
    <div>
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
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
    <div class="mt-12">
        {{ $slot }}
    </div>


</div>
