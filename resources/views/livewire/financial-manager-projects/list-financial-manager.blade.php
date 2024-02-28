<div class="container mx-auto px-4 mt-4 p-1 bg-white h-screen">
  @foreach ($projects as $project)
  <div class="container mx-auto px-4 mt-10">
      <div class="flex flex-col md:flex-row">
          <div class="md:w-full mx-auto">
              {{-- <img class="w-full h-48 object-cover object-center mb-4" src="{{ asset('images/dost.png') }}" alt="{{ $project->title }}"> --}}
              <div class="p-6">
                  <h2 class="text-2xl font-semibold text-gray-800">{{ $project->title }}</h2>
                  <p class="text-sm text-gray-600 mb-4">{{ $project->project_type }}</p>
                  <div class="flex items-center mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                      </svg>
                      <span class="text-sm text-gray-600">{{ $project->implementing_agency }}</span>
                  </div>
                  <div class="flex items-center mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 5a1 1 0 00-1 1v8a1 1 0 001 1h14a1 1 0 001-1V6a1 1 0 00-1-1H3zm14 2H3v6h14V7zm-9 3a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-sm text-gray-600">{{ $project->monitoring_agency }}</span>
                  </div>
                  <div class="flex items-center mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 18a1 1 0 100-2 7 7 0 110-14 1 1 0 100 2 5 5 0 100 10z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-sm text-gray-600">{{ $project->project_leader }}</span>
                  </div>
                  <div class="flex items-center mb-4">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 18a1 1 0 100-2 7 7 0 110-14 1 1 0 100 2 5 5 0 100 10z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($project->start_date)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($project->end_date)->format('F j, Y') }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                      <div class="text-sm text-gray-600">Total Budget: ${{ number_format(100000, 2) }}</div>
                      <div class="text-sm text-gray-600">Total Usage: 50%</div>
                  </div>
                  <div class="mt-2 text-sm text-gray-600">Remaining Budget: ${{ number_format(50000, 2) }}</div>
              </div>
              <div class="flex justify-center">
                 {{$this->assignedProjects}}
              </div>
          </div>
      </div>
  </div>
  @endforeach

<x-filament-actions::modals />
</div>

