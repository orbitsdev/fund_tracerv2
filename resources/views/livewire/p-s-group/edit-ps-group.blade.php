<div>

    <div class="flex justify-end">
            <a href="{{route('personal-service.index')}}" class="rounded bg-gray-600 p-2 text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                  </svg>

                <span class="">
                        Back
                    </span>
            </a>
    </div>
    <p class="my-2">
        {{$record->title}}
    </p>
    <form wire:submit="save">
        {{ $this->form }}

        <button type="submit">
            Submit
        </button>
    </form>

    <x-filament-actions::modals />
</div>
