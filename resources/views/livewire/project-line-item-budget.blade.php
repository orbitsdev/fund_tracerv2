<div class=>

    <x-create-management-layout>



         <x-back-button :url="Auth::user()->is_admin() ? route('project.index') : (Auth::user()->is_financial() ? route('financial-manager.projects') : '#')" >
                Back
            </x-back-button>
        <div class="flex items-center justify-end mt-4 ">
            <div>

                {{ $this->addAction }}
            </div>
            <div>


                {{-- <x-filament::link color="gray">
                    Mark notifications as read

                    <x-slot name="badge">
                        3
                    </x-slot>
                </x-filament::link> --}}
            </div>
        </div>

        <div class="mt-4">
            {{ $this->table }}
        </div>








    </x-create-management-layout>
    <div class="mt-4 px-8 py-4 d-gradient text-white rounded-lg">
        <div class="flex justify-between items-center">
            <div>
                <!-- Content here if needed -->
            </div>
            <div class="flex items-center">
                <p class="text-lg font-medium mr-4">Total Project Budget:</p>
                <p class="text-lg font-medium text-right">{{ number_format($record->getTotalAllYearsBudget()) }}</p>
            </div>
        </div>
    </div>

</div>

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
