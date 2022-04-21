@extends('layouts.app')

<!-- prettier-ignore -->
<style>
    button.splide__arrow {
        top: 20%
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
<div class="px-4 py-10">
    <h2 class="text-center text-2xl">Latest users</h2>
    <p class="text-center my-2">Say <q>Hello</q> to our newest members! <br>Send them a message or follow their progress.</p>
    <div x-data="carousel" class="splide mx-auto" role="group">
        <div class="splide__arrows"></div>
        <div class="splide__track">
            <div class="splide__list">
                @foreach($newestUsers as $newUser)
                    <div class="splide__slide">
                        <x-user-card :newUser="$newUser" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
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
</script>
@endsection
