<x-modal name="create-new-admin" focusable>
    <form method="post" action="{{ route('admin.add-acount') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Create new admin') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('All fields below are required. Please fill all of them.') }}
        </p>
        <div class="mt-6">
            <x-input-label for="name" value="{{ __('name') }}" class="sr-only" />

            <x-text-input id="name" name="name" type="text" class="mt-1 block w-3/4"
                placeholder="{{ __('Name') }}" />
        </div>
        <div class="mt-6">
            <x-input-label for="email" value="{{ __('email') }}" class="sr-only" />

            <x-text-input id="email" name="email" type="email" class="mt-1 block w-3/4"
                placeholder="{{ __('Email') }}" />
        </div>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
            <x-core.button class="ml-3">{{ __('Add Account') }}</x-core.button>
        </div>
    </form>
</x-modal>
