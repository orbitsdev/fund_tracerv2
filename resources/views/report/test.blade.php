
<x-testlayout>

<a href="/test">Test</a>
    <div class="bg-gray-100 h-screen  p-10">

        <div class="rounded m-auto max-w-6xl p-4 bg-white drop-shadow">
            <div class="text-gray-600 flex items-start justify-center">
                <div class="flex items-center px-4 mt-6   justify-end">
                    <img src="{{ asset('images/dost.png') }}" alt="" class="h-12 w-12">
                </div>
                <div class="text-center uppercase text-gray-600">
                    <p class="uppercase text-3xl leading-relaxed font-medium ">Sultan Kudarat State University</p>
                    <p class=" text-xs leading-relaxed  ">EJC Montilla, 9800, Province of Sultan Kudarat</p>
                    <p class="mt-4  capitalize font-medium  text-gray-600 text-center textlg  mb-6 "> Year 1 Personal Service Breakdown </p>
                </div>
                <div class="flex items-center px-4 mt-6    justify-start ">
                    <img src="{{ asset('images/sksu.png') }}" alt="" class="h-12 w-12">
                </div>
            </div>
            <div class="mt-4">
                <div class="grid grid-cols-12">
                    <p class="bg-gray-50 col-span-12 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-600 sm:pl-3">Salary</p>
                    <div class="bg-gray-50 col-span-12 py-2 pl-4 pr-3 text-left text-sm font-semibold text-gray-600 sm:pl-3">Salary</div>
                    {{-- <div class="">
                    </div> --}}
                </div>


            </div>

        </div>

    </div>
</x-testlayout>
