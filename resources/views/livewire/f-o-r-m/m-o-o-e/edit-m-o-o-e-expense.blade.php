<div>

    <div class="flex justify-end">
        {{-- @dump($record) --}}
        <x-back-button :url="route('mooe.expense.list',['record'=> $record->m_o_o_e_group_id ])">BACK</x-back-button>

    </div>
    <form wire:submit="save">
        {{ $this->form }}
        <x-custom-button type="submit"  class="text-center justify-center">Save</x-custom-button>
    </form>

    <x-filament-actions::modals />
</div>
