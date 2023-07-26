<div class="flex flex-col gap-y-1">
    @foreach ($results as $key => $answer)
        <div class="font-bold">{{ $loop->index + 1 . ') ' . $answer[0]['title'] }}</div>
        @php $percent = App\Http\Controllers\PollController::convertToPercent(count($answer),$totalVotes); @endphp
        <x-core.progress-bar
            :title="$answer[0]['answer']"
            :percent="$percent"
            :answer_votes="count($answer) ?? 0"
            :total="$totalVotes">
        </x-core.progress-bar>
    @endforeach
</div>
<div class="flex justify-center gap-x-10 my-2 md:my-10">
    <x-core.button primary as="a" href="{{ route('show-poll') }}">BACK TO POLL</x-core.button>
</div>
