@php
    $view = 'staff';
    $error = '';
    if ($errors->isNotEmpty()) {
        // echo '<pre>';
        // print_r($errors);
        // echo '</pre>';
        // exit;
        if (count($errors->all()) === 1) {
            $error = 'new';
        } else {
            $error = 'edit' . $errors->all()[1];
        }
    }
@endphp
@php

@endphp
<x-app-layout>
    <x-slot name="navigation">
        @include('layouts/logisticsCenterNavigation')
    </x-slot>

    <x-slot name="slot">
        <div style="overflow: auto; height: 48rem;">

            <div class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 p-4">

                @foreach ($users as $key => $user)
                    <div
                        class="p-6 bg-white border border-gray-200 rounded-lg text-center h-36 shadow-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <h2 class="text-xl font-semibold">{{ $user['user'] }}</h2>
                        @if (isset($user['in']))
                            <p class="text-xs text-green-600">Input Amount (Last Month): {{ $user['in'] }}</p>
                        @else
                            <p class="text-xs text-green-600">Input Amount (Last Month): 0</p>
                        @endif
                        @if (isset($user['out']))
                            <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): {{ $user['out'] }}</p>
                        @else
                            <p class="text-xs text-red-600 pb-2">Output Amount (Last Month): 0</p>
                        @endif
                        <div>

                            <x-secondary-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'edit-user{{ $key }}')"
                                class="ms-3">
                                {{ __('Edit') }}
                            </x-secondary-button>

                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'delete-user{{ $key }}')"
                                class="ms-3">
                                {{ __('Delete') }}
                            </x-danger-button>
                        </div>
                    </div>
                    @include('modal.deleteUser')
                    @include('modal.editUser')
                @endforeach
            </div>

            @include('modal/newUser')
        </div>

    </x-slot>
</x-app-layout>
