<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="resetPassword({resetPasswordURL: '{{route('password.update')}}'})" class="flex flex-col my-auto">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8" :class="submitSuccess ? 'text-red-500' : 'hover:text-red-500'">Fitness Tracker</h1>
    <h2 class="text-center text-3xl sm:text-3xl mb-5 sm:mb-8">Password Reset</h2>
    <form method="POST" id="f_resetPassword">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}" />
        <div>
            <label x-ref="resetEmailLabel" for="email">Email</label>
            <input x-on:focus="$refs.resetEmailLabel.classList.add('text-red-500')" x-on:focusout="resetEmailInput ? '' : $refs.resetEmailLabel.classList.remove('text-red-500')" id="email" class="block mt-1 w-full" type="email" name="email" required placeholder="Enter your email..." x-model="resetEmailInput" />
        </div>
        <div class="mt-4">
            <label x-ref="newPasswordLabel" for="password">Password</label>
            <input id="password" x-on:focus="$refs.newPasswordLabel.classList.add('text-red-500')" x-on:focusout="newPasswordInput ? '' : $refs.newPasswordLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="password" name="password" required placeholder="Enter your new password..." x-model="newPasswordInput" />
        </div>
        <div class="mt-4">
            <label x-ref="confirmPasswordLabel" for="password_confirmation">Confirm your password</label>
            <input id="password_confirmation" x-on:focus="$refs.confirmPasswordLabel.classList.add('text-red-500')" x-on:focusout="confirmPasswordInput ? '' : $refs.confirmPasswordLabel.classList.remove('text-red-500')" class="block mt-1 w-full" type="password" name="password_confirmation" required placeholder="Confirm your new password..." x-model="confirmPasswordInput" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <button @click.prevent="submitFormPressed" class="app-btn app-btn-primary">Reset</button>
        </div>
    </form>
</div>
@endsection

<!-- prettier-ignore -->
@section('script')
<script defer>
    const resetPassword = ({ resetPasswordURL }) => ({
        resetEmailInput: "",
        newPasswordInput: "",
        confirmPasswordInput: "",
        submitSuccess: false,
        formEl: null,
        init() {
            this.formEl = document.getElementById("f_resetPassword");
        },
        async submitFormPressed() {
            const formData = new FormData(this.formEl);
            const response = await fetch(resetPasswordURL, {
                method: "post",
                body: formData,
                header: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            this.submitSuccess = true;
        },
    });
</script>
@endsection
