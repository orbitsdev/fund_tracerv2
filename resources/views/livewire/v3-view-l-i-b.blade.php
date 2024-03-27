<div>
        <x-v3-top-header>
                {{ $record->project->title }} ({{ $record->year->title }} LIB)
                <!-- Slot 1 content not provided, default content will be displayed -->
                <x-slot name="slot2">
                    <x-back-button style="justify-start" :url="route('project.line-item-budget', ['record' => $record->project->id])">
                        Back
                        </x-bacl-button>
                </x-slot>
            </x-v3-top-header>

            <div class="relative  bg-white p-4 rounded">

            </div>
    
        {{-- @dump($record) --}}
</div>
