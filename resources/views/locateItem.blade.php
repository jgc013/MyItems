<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Locate Item') }}
            </h2>
            <div class="flex space-x-4">

                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'locate')"
                    class="ms-3">
                    {{ __('Locate') }}
                </x-primary-button>
            </div>

        </div>
    </x-slot>
    <x-slot name="slot">
        @include('modal.locate')
        @if (isset($result))
            <div class=" gap-4 p-4 h-full ">
                <div class=" gap-4 h-full ">

                    <div class="flex items-center justify-center h-full bg-white border border-gray-200 rounded-lg shadow-xl"
                        style="height: 46.3rem">
                        <div class="text-center">
                            <h1 class="text-6xl mb-4">{{ $result['title'] }}</h1>
                            <h2 class="text-6xl mb-4">{{ $result['p'] }}</h2>
                            @if ($result['title'] != 'Amount of Item not recorded')
                                <p class="text-sm text-gray-500">Format: A-B-C</p>
                                <p class="text-sm text-gray-500">A: street</p>
                                <p class="text-sm text-gray-500">B: section</p>
                                <p class="text-sm text-gray-500">C: height</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-slot>


</x-app-layout>
