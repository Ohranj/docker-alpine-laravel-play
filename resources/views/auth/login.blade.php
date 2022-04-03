<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div class="m-auto h-1/2 w-full px-1 border" x-data="loginForm">
    {{-- <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --> --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email123</label>
            <input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus placeholder="Enter your email..." />
        </div>

        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password..." />
        </div>

        <div class="block mt-4">
            <label for="remember_me" hidden>Remember me</label>
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember" />
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">Forgot your password</a>
            <button class="ml-3 rounded p-2 bg-purple-900 text-white">Log in</button>
        </div>
    </form>

    <button @click="showModal = true" class="rounded p-2 border">Contact Us</button>
</div>

@endsection
<!-- prettier-ignore -->
@section('script')
<script>
    const loginForm = () => ({
        showModal: false,
        init() {
            console.log("loginForm init");
        },
    });
</script>
@endsection
