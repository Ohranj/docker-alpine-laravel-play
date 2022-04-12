<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="register" class="m-auto h-2/3 w-full px-1">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8">Fitness Tracker</h1>
    <h2 class="text-center text-3xl sm:text-3xl mb-5 sm:mb-8">Register</h2>
    <div class="h-[20px] w-11/12 mx-auto rounded-full ring-2 ring-white">
        <div :class="stepsCompleted == 0 ? 'w-1/3' : stepsCompleted == 1 ? 'w-2/3' : 'w-full'" class="bg-blue-600 h-full rounded-full flex content-center justify-center text-sm">
            <span x-cloak x-text="progressBarText[stepsCompleted]"></span>
        </div>
    </div>
    <div x-show="stepsCompleted == 0" class="mt-10 p-3 shadow-xl shadow-red-300 rounded">
        <p class="mb-2">The information provided throughout the registration will go towards creating your profile card. This a publicly viewable snapshot of yourself.</p>
        <small>You will have chance to see your card prior to confirming your registration.</small>
        <form class="my-6 border-t-2">
            <div class="my-4">
                <label for="email">Email<sup>*</sup></label>
                <input name="email" type="email" class="block mt-1 w-full" placeholder="Enter your email..." />
            </div>
            <div class="my-4">
                <label for="password">Password<sup>*</sup></label>
                <input name="password" type="password" class="block mt-1 w-full" placeholder="Enter your password..." />
            </div>
            <div class="my-4">
                <label for="confirm-password">Confirm Password<sup>*</sup></label>
                <input name="confirm-password" type="password" class="block mt-1 w-full" placeholder="Confirm your password..." />
            </div>
            <div class="my-4 flex gap-x-2">
                <div class="flex-grow">
                    <label for="firstname">Firstname<sup>*</sup></label>
                    <input name="firstname" type="text" class="block mt-1 w-full" placeholder="Enter your firstname..." />
                </div>
                <div class="flex-grow">
                    <label for="firstname">Surname<sup>*</sup></label>
                    <input name="firstname" type="text" class="block mt-1 w-full" placeholder="Enter your surname..." />
                </div>
            </div>
            <button class="app-btn app-btn-primary block mx-auto" @click.prevent="confirmPressed">Confirm</button>
        </form>
    </div>
    <div x-show="stepsCompleted == 1" class="mt-10 p-3 shadow-xl shadow-red-300 rounded">
        <div class="flex justify-center gap-x-4">
            <button class="app-btn app-btn-secondary" @click.prevent="backPressed">Back</button>
            <button class="app-btn app-btn-primary" @click.prevent="confirmPressed">Confirm</button>
        </div>
    </div>
</div>
@endsection

<script>
    const register = () => ({
        stepsCompleted: 0,
        progressBarText: ["Step 1", "Step 2", "Step 3"],
        init() {
            console.log("here");
        },
        confirmPressed() {
            if (this.stepsCompleted == 2) return;
            this.stepsCompleted++;
        },
        backPressed() {
            if (this.stepsCompleted == 0) return;
            this.stepsCompleted--;
        },
    });
</script>
