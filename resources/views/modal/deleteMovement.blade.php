<x-modal name="delete-movement{{ $movement['id'] }}">
    <div class="p-6">


        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete this movement?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once this movement is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
        <form method="get" action="{{ route('movement.delete', ['id' => $movement['id']]) }}" class="mt-6 space-y-6">
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">{{ __('Delete Movement') }}</x-danger-button>
            </div>

        </form>
    </div>
</x-modal>
