@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')

<!-- prettier-ignore -->
<div class="flex flex-wrap justify-evenly">
    @foreach ($newestUsers as $newUser)
    <div class="mt-3 p-3">
        <div class="h-[400px] w-[300px] mx-auto mb-6 flex flex-col shadow-lg rounded">
            <div class="w-[105px] h-[105px] relative mx-auto mt-5">
                <img src="{{$newUser->getUserAvatar()}}" class="w-full h-full rounded-full border-2 mx-auto cursor-pointer object-cover block max-w-full hover:scale-105" />
            </div>
            <div class="mt-7">
                <p class="text-center text-xl" x-text="inputData.firstname"></p>
                <p class="text-center text-xl" x-text="inputData.surname"></p>
            </div>
            <ul class="flex flex-wrap gap-4 text-center justify-center content-center flex-grow"></ul>
            <div class="border-t mt-auto py-2 text-center text-sm"></div>
        </div>
        <div class="flex justify-center gap-x-4">
            <button class="app-btn app-btn-secondary" type="button">Message</button>
            <button class="app-btn app-btn-primary" type="button">Follow</button>
        </div>
    </div>
    @endforeach @endsection
</div>
