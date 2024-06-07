<x-app-layout>
    @php

        $error = '';
        if ($errors->isNotEmpty()) {
            if (count($errors->all()) === 1) {
                $error = 'new';
            } else {
                $error = 'edit' . $errors->all()[1];
            }
        }
    @endphp
    <x-slot name="header">
        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Logistics Centers') }}
            </h2>
            <div class="flex space-x-4">

                <x-primary-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'new-logistics-center')" class="ms-3">
                    {{ __('+ New ') }}
                </x-primary-button>
            </div>
        </div>
    </x-slot>

    <x-slot name="slot">

        <div style="overflow: auto; height: 48rem;">

            <div class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 p-4">

                @foreach ($logisticsCentersUser as $key => $center)
                    <a href="{{ route('logisticsCenterX.init', ['logisticsCenter' => $key]) }}" type="button">
                        <div
                            class="p-6 bg-white border border-gray-200 rounded-lg text-center h-40 shadow-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            <h2 class="text-xl font-semibold">{{ $center['name'] }}</h2>
                            @if (isset($center['amount']))
                                <p class="text-xs">Stock: {{ $center['amount'] }}</p>
                            @else
                                <p class="text-xs">Stock: 0</p>
                            @endif
                            @if (isset($center['in']))
                                <p class="text-xs text-green-600">Input Amount (Last Month): {{ $center['in'] }}</p>
                            @else
                                <p class="text-xs text-green-600">Input Amount (Last Month): 0</p>
                            @endif
                            @if (isset($center['out']))
                                <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): {{ $center['out'] }}</p>
                            @else
                                <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): 0</p>
                            @endif
                            <div>

                                <x-secondary-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-logistics-center{{ $key }}')"
                                    class="ms-3">
                                    {{ __('Edit') }}
                                </x-secondary-button>

                                <x-danger-button x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'delete-logistics-center{{ $key }}')"
                                    class="ms-3">
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </a>
                    @include('modal.deleteLogisticsCenter')
                    @include('modal.editLogisticsCenter')
                @endforeach
            </div>
        </div>
        @include('modal.newLogisticsCenter')

    </x-slot>
</x-app-layout>
