@props(['success' => 'true'])
<div id="alert-border-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)" @class([
    'text-green-800  border-green-300 bg-green-50 flex p-4 mb-4 w-1/4 fixed z-50 top-2 right-0' => $success,
    'text-red-800  border-red-300 bg-red-50 flex p-4 mb-4 w-1/4 fixed z-50 top-2 right-0' => !$success,
])
    role="alert">
    <x-icons.info/>
    <div class="ml-3 text-sm font-medium">
        {{ $slot }}
    </div>
    <button type="button" x-on:click="show=false" @class([
        'ml-auto -mx-1.5 -my-1.5  rounded-lg focus:ring-2 inline-flex h-8 w-8 bg-green-50 text-green-500 focus:ring-green-400 p-2 hover:bg-green-200' => $success,
        'ml-auto -mx-1.5 -my-1.5  rounded-lg focus:ring-2 inline-flex h-8 w-8 bg-red-50 text-red-500 focus:ring-red-400 p-2 hover:bg-red-200' => !$success,
    ])>
        <x-icons.close @class([
            'w-3 h-3 text-green-600 ml-0.5' => $success,
            'w-3 h-3 text-red-600 ml-0.5' => !$success,
        ]) />
    </button>
</div>