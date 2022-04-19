<!-- prettier-ignore -->
<nav class="py-1 sm:py-2 flex px-2 border-b-2 flex justify-between items-center text-md md:text-xl lg:px-20">
    <p class="hidden hover:text-red-500 md:block md:text-3xl">
        {{ env("APP_NAME") }}
    </p>
    <ul class="flex gap-x-4 sm:gap-x-6">
        <li class="{{Request::path() == 'home' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue" href="{{route('dashboard')}}">Home</a>
        </li>
        <li class="{{Request::path() == 'diary' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue" href="{{route('diary')}}">Diary</a>
        </li>
        <li class="{{Request::path() == 'nutrition' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue" href="{{route('nutrition')}}">Nutrition</a>
        </li>
        <li class="{{Request::path() == 'members' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue" href="{{route('members')}}">Members</a>
        </li>
        <li class="{{Request::path() == 'leaderboard' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue" href="{{route('leaderboard')}}">Leaderboard</a>
        </li>
        <li class="{{Request::path() == 'inbox' ? 'active-navItem' : 'inactive-navItem'}} relative">
            <a class="no-underline hover:text-accent-blue" href="{{route('inbox')}}">Inbox</a>
            <span class="absolute top-0 -right-1 inline-flex items-center justify-center px-1 py-1 text-xs font-bold leading-none transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">99</span>
        </li>
    </ul>
    <a href="{{route('settings')}}">
        <img src="{{Auth::user()->getUserAvatar()}}" class="rounded-full w-[50px] h-[50px] sm:w-[65px] sm:h-[65px] cursor-pointer"/>
    </a>
</nav>
<!-- Show profile on image click - allow settings / change account stuff / view friends follow / current weight / calories and sign
out 
Nutrition show meals plans
Diary allow see progress over time and write about it. Allow other people to respond and like posts? -->
