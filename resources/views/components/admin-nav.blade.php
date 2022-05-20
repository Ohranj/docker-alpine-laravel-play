<!-- prettier-ignore -->
<aside x-data="{showUserDropdown: false}" x-init="$watch('showUserDropdown', () => $refs.userChevron.classList.toggle('rotate-180'))" class="w-[250px] self-stretch">
    <div class="overflow-y-auto py-4 px-3 rounded border h-full">
        <ul class="space-y-2">
            <li>
                <a href="#" class="flex items-center p-2 no-underline rounded-lg {{Request::path() == 'admin' ? 'bg-gray-100 text-gray-500' : 'hover:bg-gray-100'}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 transition duration-75" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-3">Uploaders</span>
                </a>
            </li>
            <li>
                <button @click="showUserDropdown = !showUserDropdown" class="flex items-center p-2 w-full rounded-lg transition duration-75 hover:bg-gray-100 hover:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Users</span>
                    <svg x-ref="userChevron" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul x-cloak x-show="showUserDropdown" x-collapse class="py-2 space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 no-underline w-full rounded-lg transition duration-75 hover:bg-gray-100">View all</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 pl-11 no-underline w-full rounded-lg transition duration-75 hover:bg-gray-100">Misc</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
