@props(['key','question', 'options', 'name', 'id' => null])
<div class="flex flex-col justify-center items-center w-full">
    <div class="bg-white rounded-md pb-2 shadow-lg w-full">
        <p class="bg-teal-700 px-4 py-3 text-white font-bold rounded-t-md">{{ $key . ')   ' . $question['title'] }}</p>
        <div class="flex flex-col w-full gap-3 pt-3 pb-2 px-2 relative">
            @foreach ($options as $key => $option)
                <div class="relative w-full h-8">
                    <input type="radio" name="{{ $name }}" value="{{ $option['id'] }}"
                        id="{{ 'question' . $question['id'] . $option['id'] }}"
                        class="appearance-none rounded-lg bg-gray-100 cursor-pointer h-full w-full
                    checked:bg-teal-400 transition-all duration-200  checked:hover:bg-teal-400 hover:bg-gray-200   peer">
                    <label for="{{ 'question' . $question['id'] . $option['id'] }}"
                        class="absolute top-[50%] left-3 text-gray-400   -translate-y-[50%]
                     peer-checked:text-gray-100 transition-all duration-200 select-none
                ">{{ $key + 1 . ')  ' . $option['title'] }}</label>
                </div>
            @endforeach
        </div>
        @error($name)
            <span class="text-md text-red-500 px-2">{{ $message }}</span>
        @enderror
    </div>
</div>
