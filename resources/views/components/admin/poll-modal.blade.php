@php
    $results = App\Http\Controllers\AdminController::pollResults($poll->id);
@endphp

<x-modal name="poll-modal.{{ $loop->iteration }}" id="{{ 'modal' . $loop->iteration }}" focusable>
    <div class="p-6">
        @foreach ($results as $key => $result)
        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 my-6">
            {{ $loop->iteration . ') ' . $result['question_title'] }}
        </h2>
        <div class="flex flex-col gap-y-1">
            @php $total = 0; @endphp
                @foreach ($result['answers'] as $answer)
                @php $total+= $answer['votes']; @endphp
                    <x-core.progress-bar
                        :title="$answer['answer_title']"
                        :percent="$answer['percentage']"
                        :answer_votes="$answer['votes']"
                        :total="$total">
                    </x-core.progress-bar>
                @endforeach
        </div>
        @endforeach
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </div>
    </div>
</x-modal>
