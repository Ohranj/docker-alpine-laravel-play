@extends('layouts.app')
<!-- prettier-ignore -->

@section('main-content')

<h2 class="mb-2 text-2xl mt-10 text-center">Diary</h2>
<div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-2 w-full md:w-3/4 xl:w-1/2 mx-auto px-2 my-4">
    @for ($x = 1; $x <= $days; $x++)
    <x-diary-item :day="$x" :month="$month" />
    @endfor
</div>

@endsection
