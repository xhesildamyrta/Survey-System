<div class="flex flex-col gap-y-1">
    @foreach ($results as $key => $result)
        <div class="font-bold">{{ $loop->index + 1 . ') ' . $result['question_title'] }}</div>
        @foreach ($result['answers'] as $answer)
<x-core.progress-bar
            :title="$answer['answer_title']"
            :percent="$answer['percentage']"
            :answer_votes="$answer['votes']"
            :total="$totalVotes">
        </x-core.progress-bar>
        @endforeach

    @endforeach
</div>
<div class="flex justify-center gap-x-10 my-2 md:my-10">
    <x-core.button primary as="a" href="{{ route('show-poll') }}">BACK TO POLL</x-core.button>
</div>
