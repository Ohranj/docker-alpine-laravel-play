@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div x-data="messages({'fetchReceivedURL': '{{route('messages_received')}}'})" class="mt-10">
    <div class="mx-auto border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 flex items-center shadow-md shadow-gray-500 transform ease-in-out cursor-pointer hover:scale-[1.005]">
        <img src="" class="w-[65px] h-[65px] rounded-full" />
        <div class="flex flex-grow pl-4">
            <ul class="w-1/3">
                <li>Name surname</li>
                <li>Subject</li>
            </ul>
            <span class="ml-auto">Sent</span>
        </div>
    </div>
</div>

@endsection

<!-- prettier-ignore -->
@section('scripts')
<script>
    const messages = ({ fetchReceivedURL }) => ({
        receivedMessages: [],
        async init() {
            try {
                const response = await fetch(fetchReceivedURL);
                const json = await response.json();
                if (!json.success) throw new Error(0);
                this.receivedMessages = json.data;
                console.log(this.receivedMessages);
            } catch (errCode) {
                console.log(errCode);
            }
        },
    });
</script>
@endsection
