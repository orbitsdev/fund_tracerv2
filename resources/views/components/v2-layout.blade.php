<div class="min-h-screen ">

    @include('components.nav-v2-small-screen')

    <!-- Static sidebar for desktop -->
    <div class=" flex " style="min-height: 100vh">

        @include('components.nav-v2')

        <div class=" w-full ">
            <div class="sticky  top-0 z-20">
                @livewire('navigation-menu')
            </div>




            <main class="mx-auto py-6 px-8 ">
                <div class="">
                    <!-- Your content -->

                    {{-- <div class="box border-b bg-orange-400" style="height:  100vh"></div>
                    <div class="box border-b bg-orange-400" style="height:  100vh"></div> --}}
                </div>
            </main>
        </div>


    </div>

</div>
