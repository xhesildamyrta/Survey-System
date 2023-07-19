<x-layouts.app>
    @if (session()->has('success'))
        <x-core.session-info :success="true">
            <strong> {{ session()->get('success') }}</strong>
        </x-core.session-info>
    @endif
    @if (session()->has('error'))
        <x-core.session-info :success="false">
            <strong> {{ session()->get('error') }}</strong>
        </x-core.session-info>
    @endif
    <div class="w-full">
        <form action="{{ route('submit-poll') }}" method="POST">
            @csrf
            @php
                $key = (int)key($poll)+1;
            @endphp
            <div class="grid grid-cols-1">
                <x-core.poll :key="$key" :question="$poll" :options="$poll->answers" :name="'question'"></x-core.poll>
            </div>
            <div class="flex justify-center gap-x-10 my-2 md:my-10">
                <x-core.button class="w-full">SUBMIT</x-core.button>
                <x-core.button primary as="a" href="{{route('poll-results',$poll->id)}}">LIVE RESULTS</x-core.button>
            </div>
        </form>
    </div>
</x-layouts.app>
