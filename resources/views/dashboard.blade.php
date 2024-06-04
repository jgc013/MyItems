<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <x-slot name="slot">
        <div style="overflow: auto; height: 49rem;">
            <div class=" gap-4 p-4 w-full">

                <div class=" gap-4 p-4 h-full w-full flex">
                    <div class="p-1 bg-white border border-gray-200 rounded-lg  h-full w-1/2 shadow-xl ">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400 h-full w-full">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 light:bg-gray-700 light:text-gray-400">
                                <th scope="col" class="px-6 py-3 text-center">Item</th>
                                <th scope="col" class="px-6 py-3 text-center">Logistics Center</th>
                                <th scope="col" class="px-6 py-3 text-center">Amount</th>
                            </thead>
                            <tbody class="text-xs">
                                @foreach ($itemsLogisticCenter as $name => $itemLogisticCenter)
                                    @foreach ($itemLogisticCenter as $name2 => $amount)
                                        <tr
                                            class=" bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600 uppercase">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center">
                                                {{ $name2 }}
                                            </th>
                                            <td class="px-6 py-4 text-center">

                                                {{ $name }}

                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                {{ $amount }}

                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-1 bg-white border border-gray-200 rounded-lg  h-full w-1/2 shadow-xl ">
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400 h-full w-full">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-100 light:bg-gray-700 light:text-gray-400">
                                <th scope="col" class="px-6 py-3 text-center">User</th>
                                <th scope="col" class="px-6 py-3 text-center">Logistics Center</th>
                                <th scope="col" class="px-6 py-3 text-center">Amount Input (last month)</th>
                                <th scope="col" class="px-6 py-3 text-center">Amount Output (last month)</th>
                            </thead>
                            <tbody class="text-xs">
                                @foreach ($movements as $name => $movement)
                                    <tr
                                        class=" bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600 ">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">
                                            {{ $name }}
                                        </th>
                                        <td class="px-6 py-4 text-center">

                                            {{ $movement['logisticCenter'] }}

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if (isset($movement['in']))
                                                {{ $movement['in'] }}
                                            @endif

                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if (isset($movement['out']))
                                                {{ $movement['out'] }}
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </x-slot>

</x-app-layout>
