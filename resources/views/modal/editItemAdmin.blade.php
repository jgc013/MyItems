<x-modal name="edit-item{{ $key }}" :show="$error=='edit'.$key" focusable>
   
    <div class=" p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Item') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('The name must be unique, there cannot be 2 items with the same name in the same organization.') }}
            </p>
        </header>
        <form method="POST" action="{{ route('items.edit', ['id'=>$key])}}" class="mt-6 space-y-6">
            @csrf
            <div>
                <x-input-label for="name" :value="__('New Item Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" :value="old('name', $item['name'])"/>
               @if (isset($errors->all()['0']))
               <x-input-error :messages="$errors->all()['0']" class="mt-2" />
                   
               @endif
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
