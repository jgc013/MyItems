<x-modal name="new-item" :show="$error=='new'" focusable>
    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('New Item') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Create a new item. The name must be unique, there cannot be 2 items with the same name in the same organization.') }}
            </p>
        </header>
        <form method="POST" action="{{ route('items.create') }}" class="mt-6 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Item Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->all()" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Create') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>