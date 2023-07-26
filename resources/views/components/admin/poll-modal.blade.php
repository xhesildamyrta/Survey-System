
@php
$results= App\Http\Controllers\AdminController::pollResults($poll->id);
$pollTitles = $results->pluck('answer')->toArray();
$votes = $results->pluck('votes')->toArray();
@endphp

<x-modal name="poll-modal.{{ $loop->iteration }}" id="{{ 'modal'.$loop->iteration }}" focusable>
    <div class="p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 my-6">
            {{$loop->iteration.') '. $poll->title  }}
        </h2>
        <div class="flex flex-col gap-y-1">
            @foreach ($results as $key => $result)
                <x-core.progress-bar
                    :title="$result['answer']"
                    :percent="$result['percentage']"
                    :answer_votes="$result['votes']"
                    :total="10">
                </x-core.progress-bar>
            @endforeach
        </div>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </div>
    <div class="shadow-lg rounded-lg overflow-hidden">
    <div class="py-3 px-5 bg-gray-50">Pie chart</div>
    <canvas class="p-1 ml-40 mr-40" id="chartPie"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    (function () {
        const dataPie = {
            labels: {!! json_encode($pollTitles) !!},
            datasets: [{
                label: "Total Votes per each poll",
                data: {!! json_encode($votes) !!},
                backgroundColor: [
                    "rgb(133, 105, 241)",
                    "rgb(164, 101, 241)",
                    "rgb(101, 143, 241)",
                ],
                hoverOffset: 4,
            }, ],
        };

        const configPie = {
            type: "pie",
            data: dataPie,
            options: {},
        };

        var chartPie = new Chart(document.getElementById("chartPie"), configPie);
    })();
</script>

</x-modal>

