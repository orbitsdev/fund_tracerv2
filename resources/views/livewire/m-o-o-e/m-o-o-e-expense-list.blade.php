<div>
    <x-management-layout>

        {{-- @dump($record) --}}
    <div class="flex justify-end">
        <x-back-button :url="route('mooe.index')">BACK</x-back-button>

    </div>
    {{ $this->table }}
    </x-management-layout>
</div>
