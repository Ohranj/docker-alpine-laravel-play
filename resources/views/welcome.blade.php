@extends('layouts.guest')
<!-- prettier-ignore -->

@section('main-content')

<div x-data="{}" class="text-center mt-5">
    <button
        class="text-white rounded border border-2 hover:bg-purple-500 p-2"
        @click="console.log('here')"
    >
        Initialised Tailwind and Alpine
    </button>
</div>

@stop
