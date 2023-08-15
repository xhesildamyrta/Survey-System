<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
    <div x-data="" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 md:gap-7 lg:gap-10 p-10">
                    <x-core.button primary as="a" href="{{route('admin.list')}}"
                        class="flex items-start" primary class="w-full h-32">
                        {{ __('Adminers') }}
                    </x-core.button>
                    <x-core.button primary as="a" href="{{route('create-poll')}}"
                        class="flex items-start" primary class="w-full h-32">
                        {{ __('Create new poll') }}
                    </x-core.button>
                    <x-core.button as="a" href="{{route('polls-list')}}" class="flex items-start" primary class="w-full h-32">
                        {{ __('See all polls list') }}
                    </x-core.button>
                    <x-core.button as="a" href="{{route('personality-test')}}" class="flex items-start" primary class="w-full h-32">
                        {{ __('Create a personality test') }}
                    </x-core.button>
                </div>
                <div class=""></div>
            </div>
        </div>
    </div>
</x-app-layout>
