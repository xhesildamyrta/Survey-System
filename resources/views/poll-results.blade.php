<x-layouts.app>
    <div class="mb-3"><i>{{'Latest voted: '.$latest_vote}}</i></div>
    <div class="flex flex-col gap-y-1">
    @foreach ($questions as $key => $question)
        <div class="font-bold">{{$key+1 .') '.$question['title'] }}</div>
        @foreach ($question->answers as $option)
            <div class="pl-4">
                <x-core.progress-bar
                    :title="$question['answer']"
                    :percent="$optionVotes[$question->id][$option['id']] ?? 0"
                    :answer_votes="$votesPerQuestion[$question->id][$option['id']] ?? 0"
                    :total="$totalVotes">
                </x-core.progress-bar>
            </div>
        @endforeach
    @endforeach
    </div>
    <div class="flex justify-center gap-x-10 my-2 md:my-10">
        <x-core.button primary as="a" href="{{route('show-poll')}}">BACK TO POLL</x-core.button>
        {{-- <x-core.button primary as="a" href="{{route('poll-results')}}">LIVE RESULTS</x-core.button> --}}
    </div>
</x-layouts.app>
