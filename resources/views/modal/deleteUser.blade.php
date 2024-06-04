<x-modal name="delete-user{{ $key }}">
    <div class="p-6">

        @if (@isset($user["user"]))
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete') }}
                {{ $user["user"] }} ? </h2>
        @endif
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your user is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
        <form method="get" action="{{ route('user.delete') }}"
            class="mt-6 space-y-6">
            <div class="hidden">
                <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id', $key)" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">{{ __('Delete User') }}</x-danger-button>

            </div>
        </form>
    </div>
</x-modal>
