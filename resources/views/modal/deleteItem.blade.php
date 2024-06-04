

<x-modal name="delete-item{{ $item->id }}">
    <div class="p-6">

        @if (@isset($item->name))
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete') }}
                {{ $item->name }} ? </h2>
        @endif
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your item is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
        <form method="get" action="{{ route('items.delete', ['id' => $item->id]) }}" class="mt-6 space-y-6">
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">{{ __('Delete Item') }}</x-danger-button>

            </div>
        </form>
    </div>
</x-modal>
