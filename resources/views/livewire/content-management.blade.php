<div>
    <x-v3-top-header>
        List of Data You Can Manage
        <!-- Slot 1 content not provided, default content will be displayed -->
        <x-slot name="slot2">
        </x-slot>
    </x-v3-top-header>
    <div class="bg-white p-4 rounded-lg">
        <ul role="list" class="divide-y divide-gray-100">
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ route('personal-service.index') }}">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                <i class="fas fa-info-circle mr-2"></i>
                                Particulars
                            </a>
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ route('manage.payee-member') }}">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                <i class="fas fa-info-circle mr-2"></i>
                                Payee Member
                            </a>
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ route('manage.implementing-agencies') }}">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                <i class="fas fa-building mr-2"></i>
                                Implementing Agency
                            </a>
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ route('manage.monitoring-agencies') }}">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                <i class="fas fa-eye mr-2"></i>
                                Monitoring Agency
                            </a>
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 lg:px-8">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ route('manage.years') }}">
                                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                <i class="far fa-calendar-alt mr-2"></i>
                                Year
                            </a>
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
