<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div class="m-auto h-1/2 w-full px-1">
    <h1 class="text-center text-5xl mb-5 hover:text-red-500">Fitness Tracker</h1>
    {{-- <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --> --}}
    <form method="POST" action="{{ route('login') }}" x-data="loginForm({ csrfToken: '{{csrf_token()}}' })">
        {{-- @csrf --}}
        <div>
            <label x-ref="emailLabel" for="email">Email</label>
            <input x-on:focus="$refs.emailLabel.classList.add('text-red-500')" x-on:focusout="$refs.emailLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="email" name="email" required placeholder="Enter your email..." />
        </div>
        <div class="mt-4">
            <label x-ref="passwordLabel" for="password">Password</label>
            <input x-on:focus="$refs.passwordLabel.classList.add('text-red-500')" x-on:focusout="$refs.passwordLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password..." />
        </div>
        <div class="block mt-4">
            <label for="remember_me" hidden>Remember me</label>
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember" />
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">Forgot your password</a>
            <button class="app-btn app-btn-primary">Register</button>
            <button class="app-btn app-btn-secondary">Log in</button>
        </div>
    </form>
</div>

@endsection

<!-- prettier-ignore -->
@section('script')
<script src="/js/contactUsForm.js"></script>
<script defer>
    const loginForm = ({ csrfToken }) => ({
        csrfToken,
        init() {
            console.log(csrfToken);
        },
    });
</script>
@endsection
