<x-modal name="locate" :show="$errors->isNotEmpty()" focusable>
    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Locate Item') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Locate a item.') }}
            </p>
        </header>
        <form method="get" action="{{ route('locate') }}" class="mt-6 space-y-6">
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
                <label for="amount" class="block font-medium text-sm text-gray-700">Select the amount to locate</label>
                <input type="number" name="amount" id="amount" aria-describedby="helper-text-explanation"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                    placeholder="Choose an amount"/>
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
