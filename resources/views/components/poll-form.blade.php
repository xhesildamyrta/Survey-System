<div class="w-full">
    <form action="{{ route('submit-poll') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1">
            @foreach ($questions as $key => $question)
                <x-core.poll :key="$key + 1" :question="$question" :options="$question->answers" :name="'question' . $key"></x-core.poll>
            @endforeach
        </div>
        <div class="flex justify-center gap-x-10 my-2 md:my-10">
            <x-core.button class="w-full">SUBMIT</x-core.button>
            <x-core.button primary as="a" href="{{route('poll-results')}}">LIVE RESULTS</x-core.button>
        </div>
    </form>
</div>
