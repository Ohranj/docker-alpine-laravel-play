@extends('layouts.app')

<!-- prettier-ignore -->
<style>
    button.splide__arrow {
        top: 40%
    }
    .splide__arrow--prev.splide-prev {
        margin-left: -4em;
    }
    .splide__arrow--next.splide-next {
        margin-right: -4em;
    }
    div.splide__slide, div.splide__slide {
        opacity: 0.1;
    }
    div.splide__slide.is-active.is-visible {
        opacity: 1;
    }
</style>
@section('main-content')

<!-- prettier-ignore -->
<div x-data class="px-4 py-10">
    <h2 class="text-center text-2xl">Latest users</h2>
    <p class="text-center my-2">Say <q>Hello</q> to our newest members! <br>Send them a message or follow their progress.</p>
    <div x-data="carousel" class="splide mx-auto h-[550px]" role="group">
        <div x-show="!$store.userCard.showMessageModal" class="splide__arrows"></div>
        <div class="splide__track">
            <div class="splide__list">
                @foreach($newestUsers as $newUser)
                    <div class="splide__slide">
                        <x-user-card :cardUser="$newUser" />
                    </div>
                @endforeach
            </div>
        </div>
    </div> 
</div>
<div x-data="search({'fetchUsersURL': '{{route('users_search')}}'})" class="w-11/12 lg:w-3/4 mx-auto mb-4">
    <h2 class="text-center text-2xl">Search For Users</h2>
    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-y-2 lg:gap-y-0 gap-x-2">
        <input type="text" class="rounded order-1 lg:order-1" placeholder="Search..." @input.debounce.400ms="fetchUsers()" x-model="searchTerm" />
        <select class="rounded text-black order-2 lg:order-2" x-model="paginateBy">
            <option value="5">Show 5 per page</option>
            <option value="10" selected>Show 10 per page</option>
            <option value="15">Show 15 per page</option>
        </select>
        <button class="mx-auto lg:ml-auto lg:mr-0 app-btn app-btn-primary ml-auto order-3 lg:order-3">Show Advanced Search</button>
    </div>
    <div class="text-center mt-8 w-full sm:w-3/4 mx-auto border border-dashed p-2 rounded" x-show="!searchTerm">
        <h3 class="text-xl">Member Search</h3>
        <p>Use this area to search for members. You can perform a simple search by name and location in the input above. Alternatively, use the "Advanced Search" to perform a more precise search.</p>
        <p>Members opt in to become searchable via their settings page, so bear in mind that some members may not show up.</p>
    </div>
    <div x-show="searchTerm">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 py-4">
            <template x-for="user in users">
                <div class="border rounded cursor-pointer w-full hover:scale-[1.01] shadow p-1 relative" :class="user.profile.level == 1 ? 'shadow-green-300' : user.profile.level == 2 ? 'shadow-orange-300' : user.profile.level == 3 ? 'shadow-indigo-300 ': 'shadow-red-300'">
                    <p x-text="user.firstname + ' ' + user.lastname"></p>
                    <div class="flex gap-x-4">
                        <ul>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                    <span class="align-middle ml-1">Country</span>
                                </svg>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                </svg>
                                <span class="align-middle">Gender</span>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span class="align-middle">Age</span>
                            </li>
                        </ul>
                    </div>
                    <button class="app-btn app-btn-secondary absolute inset-y-0 right-1 my-auto h-max">View</button>
                </div>
            </template>
        </div>
        <div class="text-center w-1/2 mx-auto border border-dashed p-2 rounded" x-show="!users.length && usersLoaded">
            <h3 class="text-xl">No members found</h3>
            No members found. Please amend your search or try again later.
        </div>
        <div class="text-right" x-show="users.length">
            <template x-for="page in totalPages">
                <button class="border bg-accent-blue w-[30px] h-[30px] rounded ml-1" @click="currentPage = page.label" x-text="page.label"></button>
            </template>
        </div>
    </div>
</div>
<x-message-modal />
@endsection

<!-- prettier-ignore -->
@section('scripts')
<script>
    const carousel = () => ({
        init() {
            const slide = new Splide(".splide", {
                type: "loop",
                perPage: 3,
                width: "60%",
                autoWidth: true,
                perMove: 1,
                focus: "center",
                pagination: false,
                snap: true,
                updateOnMove: true,
                breakpoints: {
                    768: { perPage: 1 },
                    1024: { perPage: 2, width: "90%", arrows: false },
                    1280: { width: "75%" },
                },
                classes: {
                    prev: "splide__arrow--prev splide-prev",
                    next: "splide__arrow--next splide-next",
                },
            }).mount();
        },
    });

    const search = ({fetchUsersURL}) => ({
        users: [],
        currentPage: 1,
        paginateBy: 10,
        totalPages: 1,
        usersLoaded: false,
        searchTerm: null,
        init() {
            this.applyWatchers()
        },
        applyWatchers() {
            this.$watch('currentPage, paginateBy', () => this.fetchUsers());
        },
        async fetchUsers() {
            this.usersLoaded = false;
            try {
                const response = await fetch(`${fetchUsersURL}?` + new URLSearchParams({
                    "search": this.searchTerm, 
                    "page": this.currentPage, 
                    "paginateBy": this.paginateBy
                }));
                const json = await response.json()
                if (!json.success) throw Error(0);
                const {data, links, ...rest} = json.data;
                this.users = data;
                this.totalPages = links.slice(1, links.length - 1);
                this.usersLoaded = true;
                console.log(this.users);
            } catch (errCode) {
                console.log(errCode);
                return;
            }
        }
    })
    
</script>
@endsection
