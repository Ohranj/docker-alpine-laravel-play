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
<div x-data="search({'fetchUsersURL': '{{route('users_search')}}'})" class="w-3/4 mx-auto mb-4">
    <h2 class="text-center text-2xl">Search For Users</h2>
    <div class="flex items-center gap-x-2">
        <input type="text" class="rounded" placeholder="Search..." @input.debounce.400ms="fetchUsers()" x-model="searchTerm" />
        <select class="rounded text-black" x-model="paginateBy">
            <option value="5">Show 5 per page</option>
            <option value="10" selected>Show 10 per page</option>
            <option value="15">Show 15 per page</option>
            <option value="25">Show 25 per page</option>
        </select>
        <button class="app-btn app-btn-primary ml-auto">Advanced Search</button>
    </div>
    <div class="text-center mt-12 w-1/2 mx-auto border border-dashed p-2 rounded" x-show="!searchTerm">
        <h3 class="text-xl">Member Search</h3>
        <p>Use this area to search for members. You can perform a simple search by name and location in the input above. Alternatively, use the "Advanced Search" to perform a more precise search.</p>
    </div>
    <div x-show="searchTerm.length">
        <div class="flex flex-wrap gap-2 justify-center py-4">
            <template x-for="user in users">
                <div class="border rounded w-5/12 cursor-pointer">
                    <ul>
                        <li x-text="user.firstname"></li>
                        <li x-text="user.lastname"></li>
                        <li><a class="no-underline" href="#">View their wall</a></li>
                    </ul>
                </div>
            </template>
        </div>
     
        <div class="text-center mt-12 w-1/2 mx-auto border border-dashed p-2 rounded" x-show="!users.length && usersLoaded">
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
