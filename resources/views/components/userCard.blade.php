<!-- prettier-ignore -->
<div x-data class="mt-3 p-3">
    <div class="h-[400px] w-[300px] mx-auto mb-6 flex flex-col rounded shadow-lg 
        @if($cardUser->profile->level == 1) shadow-green-300 @endif 
        @if($cardUser->profile->level == 2) shadow-orange-300 @endif 
        @if($cardUser->profile->level == 3) shadow-indigo-300 @endif 
        @if($cardUser->profile->level == 4) shadow-red-300 @endif">
        <div class="w-[105px] h-[105px] relative mx-auto mt-5">
            <img src="{{$cardUser->getUserAvatar()}}" class="h-full rounded-full border-2 mx-auto cursor-pointer object-cover block max-w-full hover:scale-105" />
        </div>
        <svg @click="$store.userCard.messageUser = {{$cardUser}}; $store.userCard.showMessageModal = true" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 absolute top-8 left-8 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
        </svg>

        @if (Auth::user()->getUserFollowing()->contains('id', $cardUser->id))
            <svg @click="$store.userCard.followUserPressed($el, {{$cardUser}})" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 absolute top-8 right-8 cursor-pointer text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        @else
            <svg @click="$store.userCard.followUserPressed($el, {{$cardUser}})" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 absolute top-8 right-8 cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        @endif
        
        <div class="mt-7">
            <p class="text-center text-xl">{{$cardUser->firstname}}</p>
            <p class="text-center text-xl">{{$cardUser->lastname}}</p>
        </div>
        <ul class="flex flex-wrap gap-4 text-center justify-center content-center flex-grow">
            @foreach(explode(',', $cardUser->profile->tags) as $tag)
                <li class="border rounded w-[125px] min-h-[30px] flex justify-center items-center px-2 text-sm">{{$tag}}</li>
            @endforeach
        </ul>
        <div class="border-t mt-auto py-2 text-center text-sm">{{$cardUser->profile->tagline}}</div>
    </div>
</div>
