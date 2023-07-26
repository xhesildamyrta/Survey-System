<div class="w-full">
    <div class="font-bold py-10">{{ __('Please chose the poll you want to participate.') }}</div>
    <form action="{{ route('submit-poll') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 md:gap-7 lg:gap-10">
            @foreach ($polls as $key => $poll)
                <x-core.button class="flex items-start" primary as="a" href="{{ route('single-poll', $poll->id) }}"
                    class="w-full h-32">
                    {{ $loop->index + 1 . ') ' . $poll->title }}
                </x-core.button>
            @endforeach
        </div>
    </form>
</div>
