<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <div class="shrink-0 flex items-center">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Logistics Center: ') . $logisticsCenter->name }} </h2>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('logisticsCenterX.init', ['logisticsCenter' => $logisticsCenter])" :active="request()->routeIs('logisticsCenterX.init')">
                        {{ __('Staff') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('logisticsCenterX.reports', ['logisticsCenter' => $logisticsCenter])" :active="request()->routeIs('logisticsCenterX.reports')" :active="request()->routeIs('logisticsCenterX.newReport')">
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('movements.logisticsCenter', ['logisticsCenter' => $logisticsCenter])" :active="request()->routeIs('movements.logisticsCenter')">
                        {{ __('Movements') }}
                    </x-nav-link>
                </div>
            </div>

            @if ($view == 'staff')
                <div class="hidden sm:flex sm:items-center sm:ms-6 ">

                    <div class="flex space-x-4">

                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'new-user')" class="ms-3">
                            {{ __('+ New ') }}
                        </x-primary-button>
                    </div>

                </div>
            @else
                <div class="hidden sm:flex sm:items-center sm:ms-6 ">
                    @if ($view != 'movement')
                        <div class="flex space-x-4">

                            <x-primary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'new-report')" class="ms-3">
                                {{ __('+ New ') }}
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            @endif
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>



        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('logisticsCenterX.init', ['logisticsCenter' => $logisticsCenter])" :active="request()->routeIs('logisticsCenterX.init')">
                {{ __('Staff') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('logisticsCenterX.reports', ['logisticsCenter' => $logisticsCenter])" :active="request()->routeIs('logisticsCenterX.reports')">
                {{ __('Reports') }}
            </x-responsive-nav-link>
        </div>


    </div>
</nav>
