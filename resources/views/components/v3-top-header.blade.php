<!-- resources/views/components/custom-component.blade.php -->
<div class="bg-white mb-2 rounded-xl border-t  shadow border-trust-200">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="hidden lg:flex lg:gap-x-12">
            <p class="text-xl font-semibold leading-6 text-gray-500 uppercase">
                {{ $slot  }}
            </p>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            {{ $slot2 }}
        </div>
    </nav>
</div>
