@extends('layouts.app')
<!-- prettier-ignore -->

@section('main-content')

<h2 class="mb-2 text-2xl mt-10 text-center">Diary</h2>
<p class="mx-auto text-center w-full lg:w-3/4 xl:w-1/2 px-2">
    Your diary allows you to track your workouts. You can write what you like here, using it as a reference point to look back on. By default the page will show you the current month. Feel free however to use the input below to select the date to view past entries or even look ahead and set notes for yourself.
</p>

<div x-data class="text-center my-8">
    <form x-ref="setDateForm" method="get" action="{{route('diary')}}" >
        <input name="date" type="month" class="rounded" @change="$refs.setDateForm.submit()" value="{{$inputValue}}" />
    </form>
</div>
<div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-2 w-full md:w-3/4 xl:w-1/2 mx-auto px-4 my-4">
    @for ($x = 1; $x <= $days; $x++)
        <x-diary-item :day="$x" :month="$month" :currentMonthDay="$currentMonthDay" />
    @endfor
</div>

@endsection

@section('scripts')
@endsection