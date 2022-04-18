<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<div class="h-screen flex justify-center flex-col">
    @if (session('status') == 'verification-link-sent')
    <div class="text-center text-accent-blue flex flex-col gap-y-4">
        A new verification link has been sent to the email address you provided
        during registration. Please check your inbox.
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="app-btn app-btn-secondary">
                Log Out
            </button>
        </form>
    </div>
    @endif

    <!-- prettier-ignore -->
    @if (!session('status'))
    <h1 class="text-center mb-4 text-xl">Please verify your email address</h1>
    <div class="mb-4 text-sm">
        You will need to verify your email address prior to navigating the site.
        Please check your inbox or click the button below to resend a
        verification link. A link will be sent to the email address you used
        when registering for the site.
    </div>

    <div class="mt-4 flex gap-x-4 justify-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="app-btn app-btn-secondary">
                Log Out
            </button>
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <button class="app-btn app-btn-primary">Send Link</button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
