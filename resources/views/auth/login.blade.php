<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div class="m-auto h-1/2 w-full px-1">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8 hover:text-red-500">Fitness Tracker</h1>
    {{-- <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --> --}}
    <form method="POST" action="{{ route('login') }}" x-data="loginForm({ csrfToken: '{{csrf_token()}}', loginURL: '{{ route('login.submit') }}' })" class="p-3 shadow-xl shadow-red-300 rounded" id="f_login">
        @csrf
        <div>
            <label x-ref="emailLabel" for="email">Email</label>
            <input x-on:focus="$refs.emailLabel.classList.toggle('text-red-500')" x-on:focusout="$refs.emailLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="email" name="email" required placeholder="Enter your email..." />
        </div>
        <div class="mt-4">
            <label x-ref="passwordLabel" for="password">Password</label>
            <input x-on:focus="$refs.passwordLabel.classList.add('text-red-500')" x-on:focusout="$refs.passwordLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password..." />
        </div>
        <div class="block mt-4">
            <div class="inline-block">
                <label for="remember_me" hidden>Remember me</label>
                <input @click="rememberMeClicked = !rememberMeClicked" type="checkbox" class="app-checkbox" name="remember" />
                <span :class="rememberMeClicked ? 'text-red-500' : ''" class="ml-2 text-sm">Remember me</span>
            </div>
            <a class="text-sm float-right" href="{{ route('password.request') }}">Forgot your password</a>
        </div>
        <div class="flex items-center justify-end my-4"> 
            <button @click.prevent="submitForm" class="app-btn app-btn-primary">Log in</button>
        </div>
        <a class="text-sm inline-block mt-2" href="{{ route('password.request') }}">Register an Account</a>
    </form>
</div>
@endsection

<!-- prettier-ignore -->
@section('script')
<script src="/js/contactUsForm.js"></script>
<script defer>
    const loginForm = ({ csrfToken, loginURL }) => ({
        csrfToken,
        rememberMeClicked: false,
        init() {
            console.log(csrfToken);
        },
        async submitForm() {
            const form = document.getElementById("f_login");
            const formData = new FormData(form);

            const response = await fetch(loginURL, {
                method: "post",
                body: formData,
                headers: {
                    _token: csrfToken,
                },
            });
            const json = await response.json();

            if (!json.success) {
                this.onSubmitFail();
                return;
            }

            this.onSubmitSuccess();
        },
        onSubmitSuccess() {
            console.log("Success");
        },
        onSubmitFail() {
            console.log("Failed");
        },
    });
</script>
@endsection
