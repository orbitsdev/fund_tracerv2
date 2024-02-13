<div>
    <div>
        <div class="sm:hidden">
          <label for="tabs" class="sr-only">Select a tab</label>
          <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
          <select id="tabs" name="tabs" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
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

              <a href="{{route('program.index')}}" class="{{(request()->routeIs('program.index')||request()->routeIs('program.create') ) ? 'border-indigo-500 text-indigo-600 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium' : 'border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium'}}" >
                Programs
                <span class="{{(request()->routeIs('program.index')||request()->routeIs('program.create')) ? 'bg-indigo-100 text-indigo-600 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block' : 'bg-gray-100 text-gray-900 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block'}} ">
                @if (\App\Models\Program::count() >1)

                {{ \App\Models\Program::count() }}

                @endif
                </span>
              </a>
              <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700" -->
              <a href="#" class="border-transparent text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                Projects
                <!-- Current: "bg-indigo-100 text-indigo-600", Default: "bg-gray-100 text-gray-900" -->
                <span class="bg-gray-100 text-gray-900 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block">52</span>
              </a>


            </nav>
          </div>
        </div>
      </div>


    <div class="mt-4">
        {{ $slot }}
    </div>


</div>