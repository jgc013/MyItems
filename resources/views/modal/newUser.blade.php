<x-modal name="new-user" :show="$errors->isNotEmpty()" focusable>
    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('New Employee') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Create a new employee. The user must be unique, there cannot be 2 employee with the same user.') }}
            </p>
        </header>
        <form method="POST" action="{{ route('user.new') }}"
            class="mt-6 space-y-6">
            @csrf

            <!-- Name -->
            <div class="hidden">
                <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id', $logisticsCenter->id)"/>
            </div>
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="user" :value="__('User')" />
                <x-text-input id="user" class="block mt-1 w-full" type="text" name="user" :value="old('user')"
                    required autofocus autocomplete="user" />
                <x-input-error :messages="$errors->get('user')" class="mt-2" />

            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
