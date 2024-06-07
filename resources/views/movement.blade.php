<x-app-layout>

    @php
        $view = "movement";
        $error = '';
        if ($errors->isNotEmpty()) {
            if (count($errors->all()) === 1) {
                $error = 'new';
            } else {
                $error = 'edit' . $errors->all()[1];
            }
        }

    @endphp
    @if (Auth::user()->rol == 'admin')
        <x-slot name="navigation">
            @include('layouts/logisticsCenterNavigation')
        </x-slot>
    @else
        <x-slot name="header"> 
            <div class="flex justify-between items-center">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Movements') }}
                </h2>


                    
                <div class="flex space-x-4">

                    <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'new-movement')"
                        class="ms-3">
                        {{ __('+ New ') }}
                    </x-primary-button>
                </div>
          

            </div>
            @include('modal.newMovement')

        </x-slot>
    @endif

    <x-slot name="slot">
        <div style="overflow: auto; height: 48rem;">



            <div class=" gap-4 p-4 h-full w-full">
                <div class="p-1 bg-white border border-gray-200 rounded-lg  w-full shadow-xl ">


                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400  w-full"
                        id="table">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 light:bg-gray-700 light:text-gray-400">
                            <th scope="col" class="px-6 py-3 text-center uppercase ">Type</th>
                            <th scope="col" class="px-6 py-3 text-center uppercase">Item Name</th>
                            <th scope="col" class="px-6 py-3 text-center uppercase">Amount</th>
                            <th scope="col" class="px-6 py-3 text-center uppercase">Registered By</th>
                            <th scope="col" class="px-6 py-3 text-center uppercase">Registered On (Last Month)</th>
                            @if (Auth::user()->rol == 'employee')
                                <th scope="col" class="px-6 py-3 text-center uppercase"> <span
                                        class="sr-only">Delete</span>
                                </th>
                            @endif

                        </thead>
                        <tbody class="text-xs">
                            @php

                            @endphp
                            @foreach ($movements as $movement)
                                @if (Auth::user()->rol == 'employee')
                                    @include('modal.deleteMovement')
                                @endif

                                @if ($movement['type'] == 'Input')
                                    <tr
                                        class=" border-b light:bg-gray-800 light:border-gray-700 hover:bg-white light:hover:bg-white bg-green-50">
                                    @else
                                    <tr
                                        class=" border-b light:bg-gray-800 light:border-gray-700 hover:bg-white light:hover:bg-white bg-red-50">
                                @endif


                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">
                                    {{ $movement['type'] }}
                                </th>
                                <td class="px-6 py-4 text-center">

                                    {{ $movement['name'] }}

                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $movement['amount'] }}

                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $movement['user'] }}

                                </td>
                                <td class="px-6 py-4 text-center">


                                    {{ $movement['updatedAt'] }}



                                </td>
                                @if (Auth::user()->rol == 'employee')
                                    <td class="px-6 py-4 text-center">

                                        @if ($movement['user'] == Auth::user()->user)
                                            <x-danger-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'delete-movement{{ $movement['id'] }}')"
                                                class="ms-3" style="margin-bottom: 0.3rem">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        @endif



                                    </td>
                                @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>




    </x-slot>
</x-app-layout>
