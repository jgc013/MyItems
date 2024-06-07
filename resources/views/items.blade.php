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
                {{ __('Items') }}
            </h2>
            <div class="flex space-x-4">

                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'new-item')"
                    class="ms-3">
                    {{ __('+ New ') }}
                </x-primary-button>
            </div>
        </div>
    </x-slot>

    <x-slot name="slot">
        <div style="overflow: auto; height: 49rem;">

        @if (Auth::user()->rol == 'admin')
            <div class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 p-4">

                @foreach ($items as $key => $item)
                    <div
                        class="p-6 bg-white border border-gray-200 rounded-lg text-center h-40 shadow-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <h2 class="text-xl font-semibold">{{ $item['name'] }}</h2>
                
                @if (isset($item['amount']))
                    <p class="text-xs">Stock: {{ $item['amount'] }}</p>
                @else
                    <p class="text-xs">Stock: 0</p>
                @endif
                @if (isset($item['in']))
                    <p class="text-xs text-green-600">Input Amount (Last Month): {{ $item['in'] }}</p>
                @else
                    <p class="text-xs text-green-600">Input Amount (Last Month): 0</p>
                @endif
                @if (isset($item['out']))
                    <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): {{ $item['out'] }}</p>
                @else
                    <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): 0</p>
                @endif
                    <div>

                        <x-secondary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'edit-item{{ $key }}')" class="ms-3">
                            {{ __('Edit') }}
                        </x-secondary-button>

                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'delete-item{{ $key }}')"
                            class="ms-3">
                            {{ __('Delete') }}
                        </x-danger-button>
                    </div>
            </div>

            @include('modal.deleteItemAdmin')
            @include('modal.editItemAdmin')
        @endforeach
        </div>
    @elseif (Auth::user()->rol == 'employee')
        @if ($items->isNotEmpty())
            <div class=" gap-4 p-4  ">
                <div class=" p-1 bg-white border border-gray-200 rounded-lg  w-full shadow-xl ">
                    <div class=" pb-1 pr-3 bg-white light:bg-gray-900 flex justify-end ">
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative mt-1">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 light:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="search"
                                class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300  w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 rounded-lg"
                                placeholder="Search by name">
                        </div>
                    </div>
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 light:text-gray-400 h-full  rounded-lg"
                        id="table">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100 light:bg-gray-700 light:text-gray-400 rounded-lg">
                            <th scope="col" class="px-6 py-3 text-center">Name</th>
                            <th scope="col" class="px-6 py-3 text-center"> <span class="sr-only">Edit</span></th>
                            <th scope="col" class="px-6 py-3 text-center"> <span class="sr-only">Delete</span>
                            </th>
                        </thead>
                        <tbody>

                            @foreach ($items as $item)
                                @include('modal.deleteItem')
                                @include('modal.editItem')
                                <tr
                                    class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">
                                        {{ $item->name }}</th>
                                    <td class="px-6 py-4 text-center">
                                        <x-secondary-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-item{{ $item->id }}')"
                                            class="ms-3" style="margin-bottom: 0.3rem">
                                            {{ __('Edit') }}
                                        </x-secondary-button>

                                    </td>
                                    <td class="px-6 py-4 text-center">


                                        <x-danger-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'delete-item{{ $item->id }}')"
                                            class="ms-3" style="margin-bottom: 0.3rem">
                                            {{ __('Delete') }}
                                        </x-danger-button>



                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>


        @endif
        @endif

        </div>
        @include('modal.newItem')
        <script>
            $('#search').on('keyup', function() {
                var searchText = $(this).val();
                $.ajax({
                    url: '{{ route('items.search') }}',
                    type: 'GET',
                    data: {
                        search: searchText
                    },
                    success: function(data) {
                        $('#table tbody').empty();
                        data.forEach(function(result) {
                            const dangerButtonString = (result) =>
                                ` <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'delete-item${result.id}')" class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" style="margin-bottom: 0.3rem; font-size: .65rem; line-height: 0.25;" > Delete </button> `;
                            const buttonString = (result) =>
                                ` <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-item${result.id}')" class="ms-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" style="margin-bottom: 0.3rem; font-size: .65rem; line-height: 0.25;" > Edit </button> `;
                            var row =
                                '<tr class="bg-white border-b light:bg-gray-800 light:border-gray-700 hover:bg-gray-200 light:hover:bg-gray-600"><th scope = "row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap light:text-white text-center uppercase">' +
                                result.name + '</th><td class="px-6 py-4 text-center">' +
                                buttonString(result) +
                                '</td><td class="px-6 py-4 text-center">' +
                                dangerButtonString(result) +
                                '</td></tr>';
                            $('#table tbody').append(row);
                        });
                    }
                });
            });
        </script>

        </div>
    </x-slot>
</x-app-layout>
