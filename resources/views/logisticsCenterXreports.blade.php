@php

    $view = 'reports';
@endphp
<x-app-layout> <x-slot name="navigation">
        @include('layouts/logisticsCenterNavigation')
    </x-slot>

    <x-slot name="slot">
        <div  style="overflow: auto; height: 49rem;">

            @if (isset($result))
                <div class="flex justify-center pt-2">
                    @if ($result['method2'] == 'movement')
                        <h2
                            class="mb-4 text-4xl text-gray-900 md:text-4xl lg:text-5xl uppercase  border-black block  p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 ">
                            {{ $result['method'] }} {{ $result['method2'] }}s report </h2>
                    @else
                        <h2
                            class="mb-4 text-4xl text-gray-900 md:text-4xl lg:text-5xl uppercase  border-black block  p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 ">
                            {{ $result['method'] }} {{ $result['method2'] }}puts report</h2>
                    @endif
                </div>
                <div class="p-4">
    
                    @foreach ($result as $name => $data)
                        @if ($name == 'total' || $name == 'method' || $name == 'method2')
                        @else
                            <div class="flex justify-start pt-2">
                                <h2
                                    class="mb-4 text-lg text-gray-900 md:text-xl lg:text-1xl uppercase border-black block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                                    {{ $name }}’s table</h2>
                            </div>
                            <div class=" p-1 bg-white border border-gray-200 rounded-lg h-full w-full shadow-xl ">
                                <table
                                    class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400 h-full w-full">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 light:bg-gray-700 light:text-gray-400">
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Date</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Amount Moved</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Total Amount Moved</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Percentage Amount Moved</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Movements</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Total Movements</th>
                                        <th scope="col" class="px-6 py-3 text-center uppercase">Percentage Movements</th>
                                    </thead>
                                    <tbody class="text-xs">
                                        @foreach ($data as $key => $value)
                                        @if ($key == "total")
                                        
                                        <tr
                                            class="bg-gray-100  border-b  light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">
                                                {{ $key }}</th>
                                            <td class="px-6 py-4 text-center text-gray-900">{{ $value['amount'] }}</td>
                                            <td class="px-6 py-4 text-center text-gray-900 ">{{ $value['allAmount'] }}</td>
                                            <td class="px-6 py-4 text-center text-gray-900">{{ $value['percentage'] }}</td>
                                            <td class="px-6 py-4 text-center text-gray-900">{{ $value['movements'] }}</td>
                                            <td class="px-6 py-4 text-center text-gray-900">{{ $value['allMovements'] }}</td>
                                            <td class="px-6 py-4 text-center text-gray-900">{{ $value['movementsPercentage'] }}</td>
        
                                        </tr>
                                        @else
    
                                        <tr
                                            class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">
                                                {{ $key }}</th>
                                            <td class="px-6 py-4 text-center">{{ $value['amount'] }}</td>
                                            <td class="px-6 py-4 text-center">{{ $value['allAmount'] }}</td>
                                            <td class="px-6 py-4 text-center">{{ $value['percentage'] }}</td>
                                            <td class="px-6 py-4 text-center">{{ $value['movements'] }}</td>
                                            <td class="px-6 py-4 text-center">{{ $value['allMovements'] }}</td>
                                            <td class="px-6 py-4 text-center">{{ $value['movementsPercentage'] }}</td>
    
                                        </tr>
                                        @endif
                                        @endforeach
    
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
            @endif
            </div>
        </div>
        @include('modal.newReport')
    </x-slot>
</x-app-layout>
