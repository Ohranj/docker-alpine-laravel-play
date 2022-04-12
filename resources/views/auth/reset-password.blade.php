<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="resetPassword" class="flex flex-col my-auto">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8 hover:text-red-500" :class="allInputsHaveValues ? 'text-red-500' : ''">
        Fitness Tracker
    </h1>
    <h2 class="text-center text-3xl sm:text-3xl mb-5 sm:mb-8">Password Reset</h2>
    <form method="POST" id="f_resetPassword" action="{{ route('password.update') }}">
        @csrf
        <input hidden name="token" value="{{ $request->route('token') }}" />
        <div>
            <label x-ref="emailLabelReset" for="email">Email</label>
            <input x-on:focus="$refs.emailLabelReset.classList.add('text-red-500')" x-on:focusout="emailInputReset ? '' : $refs.emailLabelReset.classList.remove('text-red-500')" id="email" class="block mt-1 w-full" type="email" name="email" required placeholder="Enter your email..." x-model="emailInputReset" />
        </div>
        <div class="mt-4">
            <label x-ref="passwordLabelReset" for="password">Password</label>
            <input x-on:focus="$refs.passwordLabelReset.classList.add('text-red-500')" x-on:focusout="passwordInputReset ? '' : $refs.passwordLabelReset.classList.remove('text-red-500')" id="password" class="block mt-1 w-full" type="password" name="password" required placeholder="Enter your new password..." x-model="passwordInputReset" />
        </div>
        <div class="mt-4">
            <label x-ref="confirmLabelReset" for="password_confirmation">Confirm your password</label>
            <input x-on:focus="$refs.confirmLabelReset.classList.add('text-red-500')" x-on:focusout="confirmInputReset ? '' : $refs.confirmLabelReset.classList.remove('text-red-500')" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required placeholder="Confirm your new password..." x-model="confirmInputReset" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <button class="app-btn app-btn-primary">Reset</button>
        </div>
    </form>
</div>
@endsection

<!-- prettier-ignore -->
<script>
    const resetPassword = () => ({
        emailInputReset: "",
        passwordInputReset: "",
        confirmInputReset: "",
        allInputsHaveValues: false,
        init() {
            this.applyWatchers();
        },
        applyWatchers() {
            this.$watch("emailInputReset, passwordInputReset, confirmInputReset", (v) =>
                (this.allInputsHaveValues = [this.emailInputReset, this.passwordInputReset, this.confirmInputReset].every((x) => x))
            );
        },
    });
</script>

//Show errors
