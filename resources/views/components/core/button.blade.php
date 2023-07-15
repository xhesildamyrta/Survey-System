@props(['class', 'as' => 'button'])

<{{$as}}
    {{$attributes->class([
        "inline-flex items-center justify-center px-10 py-2 border-2 border-transparent rounded-lg text-sm uppercase font-bold leading-5 text-white bg-teal-700 hover:bg-transparent hover:text-teal-700 hover:border-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-700 disabled:bg-gray-300 disabled:pointer-events-none",
        $class ?? '',
    ])}}
>
    {{$slot}}
</{{$as}}>
