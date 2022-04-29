<!-- prettier-ignore -->
<div class="border aspect-square flex flex-col hover:scale-[1.1] cursor-pointer shadow-md py-2 {{$day == $currentMonthDay ? 'shadow-red-500' : 'hover:shadow-red-500'}}">
    <h3 class="flex-grow self-center">
        {{ $month }}
    </h3>
    <span class="text-3xl self-center">
        {{ $day }}
    </span>
</div>
