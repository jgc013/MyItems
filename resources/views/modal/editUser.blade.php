<x-modal name="edit-user{{ $key }}" :show="$error == 'edit' . $key" focusable>

    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit User: ') }}{{ $user["user"] }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Assign a new password to ') }}{{ $user["user"] }}
            </p>
        </header>
        <form method="POST" action="{{ route('user.edit', ['id' => $key]) }}" class="mt-6 space-y-6">
            @csrf
            <div class="hidden">
                <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id', $key)"/>
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Edit') }}</x-primary-button>
            </div>
        </form>


    </div>
</x-modal>
