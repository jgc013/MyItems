<x-modal name="new-report" :show="$errors->isNotEmpty()" focusable>

    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('New Report') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Create a new report.') }}
            </p>
        </header>
        <form method="POST" action="{{ route('logisticsCenterX.newReport') }}" class="mt-6 space-y-6">
            @csrf
            <div class="hidden">
                <x-text-input id="id" class="block mt-1 w-full" type="text" name="id" :value="old('id', $logisticsCenter->id)" />
            </div>
            <h3 class="text-base font-medium text-gray-900">
                {{ __('Select the parameters') }}
            </h3>
            <div class="flex items-center justify-between space-x-4 " style="margin-top: 0 !important">
                <div class="w-full">
                    <select id="item1" name="item1"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full"
                        required>
                        <option selected>Choose parameter 1</option>
                        <option value="in">Inputs</option>
                        <option value="out">Outputs</option>
                        <option value="movement">Movement (sum of both)</option>
                    </select>
                    <x-input-error :messages="$errors->get('item1')" class="mt-2" />

                </div>
                <span class="mt-2">for</span>
                <div class="w-full">
                    <select id="item2" name="item2"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full"
                        required>
                        <option selected>Choose parameter 2</option>
                        <option value="allItems">Items (all)</option>
                        @foreach ($items as $key => $item)
                            <option value={{ $key }}>{{ $item }}</option>
                        @endforeach
                        <option disabled>---------------------------------------</option>
                        <option value="allUsers">Users (all)</option>
                        @foreach ($users as $user)
                            <option value={{ $user->user }}>{{ $user->user }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('item2')" class="mt-2" />

                </div>

            </div>
            <h3 class="text-base font-medium text-gray-900">
                {{ __('Select range') }}
            </h3>
            <div class="flex items-center justify-between space-x-4" style="margin-top: 0 !important">
                <div class="w-full">
                    <input type="date" name="from" id="date1"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full">
                    <x-input-error :messages="$errors->get('from')" class="mt-2" />

                </div>
                <span class="mt-2">to</span>
                <div class="w-full">
                    <input type="date" name="to" id="date2"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full">
                    <x-input-error :messages="$errors->get('to')" class="mt-2" />

                </div>


            </div>


            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button class="ms-3">{{ __('Generate') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
