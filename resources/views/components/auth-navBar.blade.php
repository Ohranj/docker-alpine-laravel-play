<!-- prettier-ignore -->
<nav class="py-1 sm:py-2 flex px-2 border-b-2 flex justify-between items-center text-md md:text-xl lg:px-20">
    <p class="hidden hover:text-red-500 md:block md:text-3xl">
        {{ env("APP_NAME") }}
    </p>
    <ul class="flex gap-x-4 sm:gap-x-6">
        <li class="{{Request::path() == 'home' ? 'active-navItem' : 'inactive-navItem'}}">
            Home
        </li>
        <li class="{{Request::path() == 'diary' ? 'active-navItem' : 'inactive-navItem'}}">
            Diary
        </li>
        <li class="{{Request::path() == 'nutrition' ? 'active-navItem' : 'inactive-navItem'}}">
            Nutrition
        </li>
        <li class="{{Request::path() == 'leaderboard' ? 'active-navItem' : 'inactive-navItem'}}">
            Leaderboard
        </li>
    </ul>
   
    <img src="{{Auth::user()->getUserAvatar()}}" class="rounded-full w-[50px] h-[50px] sm:w-[65px] sm:h-[65px] cursor-pointer"/>
</nav>
<!-- Show profile on image click - allow settings / change account stuff / view friends follow / current weight / calories and sign
out 
Nutrition show meals plans
Diary allow see progress over time and write about it. Allow other people to respond and like posts? -->
