<div>

    {{$record}}
    <x-create-management-layout>
        <div>
            <p class="text-primary-600 text-3xl font-medium"> 1. Personal Service</p>
            <div class="mt-4">
                {{$this->addPersonalServiceAction}}
            </div>
        </div>
        <x-filament-actions::modals />
    </x-create-management-layout>
</div>
