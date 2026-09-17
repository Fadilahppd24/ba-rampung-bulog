@props(['title' => 'Dashboard', 'breadcrumbs' => []])

<header class="sticky top-0 z-20 h-20 flex items-center justify-between 
bg-white border-b border-gray-100 px-6 lg:px-8">


    {{-- KIRI --}}
    <div class="flex items-center gap-4">

        <button 
            @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden p-2 rounded-lg hover:bg-gray-100"
        >
            ☰
        </button>


        <div>

            <h1 class="text-2xl font-bold text-gray-900">
                {{ $title }}
            </h1>


            @if(count($breadcrumbs))

                <div class="text-xs text-gray-500 mt-1">

                    @foreach($breadcrumbs as $crumb)

                        {{ $crumb }}

                        @if(!$loop->last)
                            <span class="mx-1">›</span>
                        @endif

                    @endforeach

                </div>

            @endif

        </div>

    </div>




    {{-- KANAN --}}
    <div class="flex items-center gap-5">


        {{-- NOTIF --}}
        <button
            class="relative h-10 w-10 rounded-full hover:bg-gray-100 flex items-center justify-center"
        >
            🔔
        </button>



        {{-- USER --}}
        <div class="flex items-center gap-3">


            <div 
                class="h-10 w-10 rounded-full bg-[#123B7A] 
                text-white flex items-center justify-center font-semibold"
            >

                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

            </div>



            <div class="hidden sm:block leading-tight">

                <p class="text-sm font-semibold text-gray-900">
                    {{ auth()->user()->name }}
                </p>


                <p class="text-xs text-gray-500">
                    {{ auth()->user()->roleLabel() }}
                </p>

            </div>



            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button
                    class="text-sm text-red-500 hover:text-red-700"
                >
                    Keluar
                </button>

            </form>


        </div>


    </div>


</header>