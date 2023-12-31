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
    @if (!$poll->isEmpty())
        <x-poll.chose-poll-form :polls="$poll" />
        </div>
    @endif
</x-layouts.app>
