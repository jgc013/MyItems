<x-modal name="delete-logistics-center{{ $key }}">
    <div class="p-6">

        @if (@isset($key))
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete') }}
                {{ $center["name"] }} ? </h2>
        @endif
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your logistics center is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
        <form method="get" action="{{ route('logisticsCenters.delete', ['id' => $key])}}" class="mt-6 space-y-6">
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class='ms-3'>{{ __('Delete Logistics Center') }}</x-danger-button>

            </div>
        </form>
    </div>
</x-modal>
