<div x-data="" class="px-4 mx-auto max-w-screen-2xl">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Title') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Creation date') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($polls as $poll)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $loop->iteration . ') ' . $poll->title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $poll->created_at }}
                        </td>
                        <td colspan="2" class="px-6 py-4 ">
                            <button
                                x-on:click.prevent="$dispatch('open-modal', 'poll-modal.{{ $loop->iteration }}')">See</button>
                            <button>Export</button>
                        </td>
                    </tr>
                    <x-admin.poll-modal :poll="$poll" :loop="$loop" />
                @endforeach
            </tbody>
        </table>
        <nav class="flex items-end justify-end pt-4" aria-label="Table navigation">
            {!! $polls->links() !!}
        </nav>
    </div>

</div>
