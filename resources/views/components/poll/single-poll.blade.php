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
            $key = 0;
        @endphp
        <div class="grid grid-cols-1">
            @foreach($poll->questions as $question)
            @php ++$key; @endphp
            <x-core.poll
                :key="$key"
                :question="$question"
                :options="$question->answers"
                :name="'question'.$question->id">
            </x-core.poll>
            @endforeach
        </div>
        <input type="hidden" name="poll_id" value="{{$poll->id}}"/>
        <div class="flex justify-center gap-x-10 my-2 md:my-10">
            <x-core.button class="w-full">SUBMIT</x-core.button>
            <x-core.button primary as="a" href="{{ route('poll-results', $poll->id) }}">LIVE RESULTS
            </x-core.button>
        </div>
    </form>
</div>
