<nav class="py-2 flex px-20 border-b-2 flex justify-between items-center text-xl">
    <p class="text-3xl hover:text-red-500">{{ env("APP_NAME") }}</p>
    <ul class="flex gap-x-4">
        <li class="text-accent-blue underline underline-offset-4 cursor-pointer">Home</li>
        <li class="cursor-pointer hover:text-accent-blue hover:underline hover:underline-offset-4">Diary</li>
        <li class="cursor-pointer hover:text-accent-blue hover:underline hover:underline-offset-4">Nutrition</li>
        <li class="cursor-pointer hover:text-accent-blue hover:underline hover:underline-offset-4">Leaderboard</li>
    </ul>
    <img
        src="/img/gravatars/iv219dqg2ef71.jpg"
        class="rounded-full w-[65px] h-[65px] cursor-pointer"
    />
</nav>
<!-- Show profile on image click - allow settings / change account stuff / view friends follow / current weight / calories and sign
out 
Nutrition show meals plans
Diary allow see progress over time and write about it. Allow other people to respond and like posts?--!>
