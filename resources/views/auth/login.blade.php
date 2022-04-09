<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="loginForm({ csrfToken: '{{csrf_token()}}', loginURL: '{{ route('login.submit') }}' })" class="m-auto h-1/2 w-full px-1">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8" :class="submitSuccess ? 'text-red-500' : 'hover:text-red-500'">Fitness Tracker</h1>
    <form x-show="!submitSuccess" method="POST" action="{{ route('login') }}" class="p-3 shadow-xl shadow-red-300 rounded" id="f_login">
        @csrf
        <p x-cloak x-show="submitFailed" class="text-red-500 text-center py-4">Invalid credentials. Please check and try again
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </p>
        <div>
            <label x-ref="emailLabel" for="email">Email</label>
            <input x-on:focus="$refs.emailLabel.classList.add('text-red-500')" x-on:focusout="emailInput ? '' : $refs.emailLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="email" id="email" name="email" required placeholder="Enter your email..." x-model="emailInput" />
        </div>
        <div class="mt-4">
            <label x-ref="passwordLabel" for="password">Password</label>
            <input x-on:focus="$refs.passwordLabel.classList.add('text-red-500')" x-on:focusout="passwordInput ? '' : $refs.passwordLabel.classList.remove('text-red-500') " class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password..." x-model="passwordInput" />
        </div>
        <div class="block mt-4">
            <div class="inline-block">
                <label for="remember_me" hidden>Remember me</label>
                <input @click="rememberMeClicked = !rememberMeClicked" type="checkbox" class="app-checkbox" name="remember" />
                <span :class="rememberMeClicked ? 'text-red-500' : ''" class="ml-2 text-sm">Remember me</span>
            </div>
            <a class="text-sm sm:float-right block text-left sm:text-right mt-5 sm:mt-0" href="{{ route('password.request') }}">Forgot your password</a>
        </div>
        <div class="flex items-center justify-end my-4"> 
            <button @click.prevent="submitForm" class="app-btn app-btn-primary">Log in</button>
        </div>
        <a class="text-sm inline-block mt-2" href="{{ route('password.request') }}">Register an Account</a>
    </form>
   <div x-cloak x-show="submitSuccess" class="mt-20 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 animate-bounce mx-auto" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <p>Great. We're logging you in</p>
   </div>
</div>
@endsection

<!-- prettier-ignore -->
@section('script')
<script src="/js/contactUsForm.js"></script>
<script defer>
    const loginForm = ({ csrfToken, loginURL }) => ({
        csrfToken,
        rememberMeClicked: false,
        submitFailed: false,
        submitSuccess: false,
        emailInput: "",
        passwordInput: "",
        init() {
            console.log("Hey");
        },
        async submitForm() {
            const form = document.getElementById("f_login");
            const formData = new FormData(form);

            try {
                const response = await fetch(loginURL, {
                    method: "post",
                    body: formData,
                });
                const json = await response.json();

                if (!json.success) throw Error;

                this.onSubmitSuccess();
            } catch {
                this.submitFailed = true;
                this.submitSuccess = false;
            }
        },
        onSubmitSuccess() {
            this.submitFailed = false;
            this.submitSuccess = true;
            setTimeout(() => {
                location.href = "/home";
            }, 1500);
        },
    });
</script>
@endsection
