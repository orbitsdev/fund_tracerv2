<div>


    @forelse ($getRecord()->files as $file)
    <a href="{{ \Storage::disk('public')->url($file->file) }}"
       target="_blank"
       {{-- download --}}
       class="text-xs block text-blue-600  underline">
        <span class="mr-2">{{ $file->file_name }}</span>

    </a>
    @empty

@endforelse

</div>
