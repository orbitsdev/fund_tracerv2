<div>

    @forelse ($record->files as $file)
    <a href="{{ \Storage::disk('public')->url($file->file) }}"
       target="_blank"
       {{-- download --}}
       class="flex items-center p-2 hover:bg-[#073c51] hover:text-white rounded-lg border-b justify-start text-[#073c51] text-xs">
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             class="w-5 h-5 mr-1 ">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        <span class="mr-2">{{ $file->file_name }}</span>
        <span class="mr-2">{{ $file->file_size }}</span>
        <span class="mr-2">{{ $file->file_type }}</span>
    </a>
    @empty
    <div class="p-4 flex items-center justify-center rounded-lg text-white bg-[#073c51]">

        <svg class="h-12 w-12 mr-2   " fill="#ffffff" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" id="folder-delete"><path d="M18.7 15.3c-.4-.4-1-.4-1.4 0l-.3.3-.3-.3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l.3.3-.3.3c-.4.4-.4 1 0 1.4.2.2.5.3.7.3s.5-.1.7-.3l.3-.3.3.3c.2.2.5.3.7.3s.5-.1.7-.3c.4-.4.4-1 0-1.4l-.3-.3.3-.3c.4-.4.4-1 0-1.4z"></path><path d="M21 11c0-2.2-1.8-4-4-4h-3.4l-.9-1.8C12 3.8 10.7 3 9.1 3H7C4.8 3 3 4.8 3 7v9c0 2.2 1.8 4 4 4h6c.9 1.2 2.3 2 4 2 2.8 0 5-2.2 5-5 0-1.1-.4-2.1-1-3v-3zM7 5h2.1c.8 0 1.4.4 1.8 1.1l.5.9H5c0-1.1.9-2 2-2zm0 13c-1.1 0-2-.9-2-2V9h12c1.1 0 2 .9 2 2v1.4c-.6-.3-1.3-.4-2-.4-2.8 0-5 2.2-5 5 0 .3 0 .7.1 1H7zm10 2c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"></path></svg>
        <p class="text-white">
            No Attachment Found
        </p>
    </div>
@endforelse

</div>
