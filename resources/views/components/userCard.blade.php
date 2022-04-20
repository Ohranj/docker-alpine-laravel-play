<!-- prettier-ignore -->
<div class="mt-3 p-3">
    <div class="h-[400px] w-[300px] mx-auto mb-6 flex flex-col rounded shadow-lg 
        @if($newUser->profile->level == 1) shadow-green-300 @endif 
        @if($newUser->profile->level == 2) shadow-orange-300 @endif 
        @if($newUser->profile->level == 3) shadow-indigo-300 @endif 
        @if($newUser->profile->level == 4) shadow-red-300 @endif">
        <div class="w-[105px] h-[105px] relative mx-auto mt-5">
            <img src="{{$newUser->getUserAvatar()}}" class="h-full rounded-full border-2 mx-auto cursor-pointer object-cover block max-w-full hover:scale-105" />
        </div>
        <div class="mt-7">
            <p class="text-center text-xl">{{$newUser->firstname}}</p>
            <p class="text-center text-xl">{{$newUser->lastname}}</p>
        </div>
        <ul class="flex flex-wrap gap-4 text-center justify-center content-center flex-grow">
            @foreach(explode(',', $newUser->profile->tags) as $tag)
                <li class="border rounded w-[125px] min-h-[30px] flex justify-center items-center px-2 text-sm">{{$tag}}</li>
            @endforeach
        </ul>
        <div class="border-t mt-auto py-2 text-center text-sm">{{$newUser->profile->tagline}}</div>
    </div>
    <div class="flex justify-center gap-x-4">
        <button class="app-btn app-btn-secondary" type="button">Message</button>
        <button class="app-btn app-btn-primary" type="button">Follow</button>
    </div>
</div>
