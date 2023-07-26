<div class="">
    <div class="px-4 mx-auto max-w-screen-xl my-auto grid place-items-center h-screen">
        @if (session()->has('success'))
        <x-core.session-info :success="true">
            <strong> {{ session()->get('success') }}</strong>
        </x-core.session-info>
    @endif

        <form method="POST" action="{{route('create-poll')}}" class="border-2 border-teal-700 rounded-xl p-10">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
            @csrf
            <div class="">
                <div class="tw-text-teal-700 font-bold">Enter the desired question for the poll you want to create</div>
                <div class="mt-6">
                    <x-input-label for="poll_title" value="{{ __('poll_title') }}" class="sr-only" />

                    <x-text-input id="poll_title'" name="poll_title" type="text" class="mt-1 block w-full"
                        placeholder="{{ __('Question') }}" />
                </div>
            </div>
            <div class="mt-10">
                <div class="tw-text-teal-700 font-bold">Enter options</div>
                @for ($i = 1; $i < 5; $i++)
                    <div class="mt-6">
                        <x-input-label for="option.{{ $i }}" value="{{ __('option') }}" class="sr-only" />

                        <x-text-input id="option.{{ $i }}" name="option.{{ $i }}" type="text"
                            class="mt-1 block w-full" placeholder="{{ __('Option ') . $i }}" />
                    </div>
                @endfor
            </div>
            <div class="mt-10 flex justify-center">
                <x-core.button>Add Poll</x-core.button>
            </div>
        </div>
    </div>
</div>
