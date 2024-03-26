<div class="bg-gray-100 py-2  px-3 grid grid-cols-12 {{ $attributes->get('class') }}">
    <div class="col-span-6 font-medium text-gray-600">
        <p>{{$label}}</p>
    </div>
    <div class="col-span-6 flex justify-end">
        <p>{{$value}}</p>
        <div class="w-[80px]"></div>
    </div>
</div>
