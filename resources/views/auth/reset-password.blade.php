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
        @if (count($errors->all()))
            <ul :class="allInputsHaveValues ? 'hidden' : ''" class="list-none text-red-500 mt-2">
                @foreach ($errors->all() as $error)
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        @endif
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
