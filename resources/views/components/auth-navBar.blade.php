<!-- prettier-ignore -->
<nav class="py-1 sm:py-2 flex px-2 border-b-2 flex justify-between items-center text-md md:text-xl lg:px-12 xl:px-20">
    <p class="hidden hover:text-red-500 lg:block md:text-3xl">
        {{ env("APP_NAME") }}
    </p>
    <ul class="flex gap-x-4 sm:gap-x-6">
        <li class="{{Request::path() == 'home' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('dashboard')}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:hidden" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                <span class="hidden sm:inline-block">Home</span>
            </a>
        </li>
        <li class="{{Request::path() == 'diary' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('diary')}}">Diary</a>
        </li>
        <li class="{{Request::path() == 'nutrition' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('nutrition')}}">Nutrition</a>
        </li>
        <li class="{{Request::path() == 'members' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('members')}}">Members</a>
        </li>
        <li class="{{Request::path() == 'leaderboard' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('leaderboard')}}">Leaderboard</a>
        </li>
        <li class="{{Request::path() == 'inbox' ? 'active-navItem' : 'inactive-navItem'}} relative">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('inbox')}}">Inbox</a>
            <span class="{{$count_unread_messages >= 1 ? 'inline-flex' : 'hidden'}} absolute top-0 -right-1 items-center justify-center px-2 py-1 text-xs font-bold leading-none transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full {{Request::path() == 'inbox' ? 'text-white' : ''}}">{{$count_unread_messages}}</span>
        </li>
       @can('show-admin-link', Auth::user())
        <li class="{{Request::path() == 'admin' ? 'active-navItem' : 'inactive-navItem'}}">
            <a class="no-underline hover:text-accent-blue text-sm sm:text-lg" href="{{route('admin')}}">Admin</a>
        </li>
        @endcan
    </ul>
    <a href="{{route('settings')}}">
        <img src="{{Auth::user()->getUserAvatar()}}" class="rounded-full sm:w-[65px] sm:h-[65px] cursor-pointer @can('show-admin-link') hidden md:inline-block @else w-[50px] h-[50px] @endcan"/>
    </a>
</nav>
<!-- Show profile on image click - allow settings / change account stuff / view friends follow / current weight / calories and sign
out 
Nutrition show meals plans
Diary allow see progress over time and write about it. Allow other people to respond and like posts? -->
