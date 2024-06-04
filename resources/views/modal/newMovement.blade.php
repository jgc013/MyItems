<x-modal name="new-movement" :show="$errors->isNotEmpty()" focusable>
    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('New Movement') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Create a new movement.') }}
            </p>
        </header>
        <form method="POST" action="{{ route('movement.create') }}" class="mt-6 space-y-6">
            @csrf

            
            <div>
                <label for="item" class="block font-medium text-sm text-gray-700">Select an option</label>
                <select id="item" name="item"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    <option selected>Choose a item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="type" class="block font-medium text-sm text-gray-700">Select an option</label>
                <select name="type" id="type"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                    <option selected>Choose a type of movement</option>
                    <option value="in">Input</option>
                    <option value="out">Output</option>
                </select>
            </div>
            <div>
                <label for="amount" class="block font-medium text-sm text-gray-700">Select an
                    amount</label>
                <input type="number" name="amount" id="amount" aria-describedby="helper-text-explanation"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                    placeholder="Choose an amount"  />
            </div>
            <div>
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                :value="old('location')" required autofocus autocomplete="location" />
                <x-input-error :messages="$errors->all()" class="mt-2" />
                <p class="text-sm text-gray-700">Format: A-B-C (Example: 23-4-2)</p>
                <p class="text-sm text-gray-700">A: street</p>
                <p class="text-sm text-gray-700">B: section</p>
                <p class="text-sm text-gray-700">C: height</p>
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
