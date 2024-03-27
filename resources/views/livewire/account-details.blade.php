<div class="p-8 bg-white">



    <div>

        <div class="border-t border-gray-100">
          <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->getFullName()}}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>

              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->email ?? ''}}
              </dd>

            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Account Type</dt>

              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->role ?? ''}}
              </dd>

            </div>

           

            <div class="col-span-3 mt-4 pt-4">
                <a href="{{$record->getUserImage()}}" target="_blank" class="h-96 bg-gray-50 rounded">
                    <div class="w-full flex items-center justify-center">
                      <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-50">
                          <img src="{{$record->getUserImage()}}" alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade." class="object-cover object-center">
                        </div>
                    </div>
                  </a>
            </div>




          </dl>
        </div>
      </div>

</div>
