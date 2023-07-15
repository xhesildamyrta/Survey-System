@props([
    'title' => '',
    'percent'=> '',
    'votes' => null,
    'answerVotes'=> '',
    'total'=>null,
])
@php

$colorClass = '';
if ($percent >= 80) {
    $colorClass = 'bg-teal-700';
    $textClass = 'text-teal-700';
} elseif ($percent >= 40) {
    $colorClass = 'bg-blue-500'; 
    $textClass = 'text-blue-500';

} else {
    $colorClass = 'bg-red-500'; 
    $textClass = 'text-red-500';

}
@endphp

<div class="flex justify-between mb-1">
    <div class="text-base font-medium {{$textClass}}">{{$title}}</div>
    <div class="text-base font-medium {{$textClass}}">{{$percent}}%
    <span class="ml-2">({{$answerVotes}}/{{$total}})</span></div>
</div>
<div class="w-full bg-gray-300 rounded-full h-3 mb-2">
  <div class="{{$colorClass}} h-3 rounded-full" style="width: {{$percent}}%"></div>
</div>
  