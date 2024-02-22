<div>
    <x-create-management-layout>
            {{-- {{$record}} --}}
        <x-back-button :url="route('project.index')" >
            Back
        </x-bacl-button>
    {{-- {{$record}} --}}
    <div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
      <div class="-ml-4 -mt-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
        <div class="ml-4 mt-4">
          <h3 class="text-base font-semibold leading-6 text-gray-900">Line Item Budget</h3>
          <p class="mt-1 text-sm text-gray-500">This section provides details about the Line Item Budget. It outlines specific expenditures and allocations.</p>
        </div>
       
      </div>
    </div>
    <div class="border-b border-gray-200 mt-6"></div>
    <div class="flex justify-end mt-6">
       {{$this->addAction}}
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>


    <div>

        <div class="mt-4 pr-8 flex justify-between text-2xl mb-8   p-2 text-gray-700 rounded">
            <div>

            </div>
            <div class="flex font-medium">

                <p class=" ">
                    Total Project Budget :
                </p>
                <p class="w-[200px] text-end mr-6">
                    {{ number_format($project_total_budget) }}
                </p>
            </div>
        </div>

    </div>



</x-create-management-layout>

    {{-- <div>
        @forelse ($project_years as $project_year)
                {{$project_year->year->title}}
        @empty
        @endforelse
    </div> --}}

    {{-- <table class="w-full divide-y divide-gray-300">
        <thead>
          <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">Lindsay Walton</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Front-end Developer</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">lindsay.walton@example.com</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Member</td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
            </td>
          </tr>

          <!-- More people... -->
        </tbody>
      </table> --}}
    <x-filament-actions::modals />
</div>
