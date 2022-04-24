@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div x-data="messages({'fetchReceivedURL': '{{route('messages_received')}}'})" class="mt-10">
    <template x-for="message in receivedMessages">
        <div @click="selectedMessage = selectedMessage.id == message.id ? {} : message" :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out cursor-pointer">
            <div class="flex items-center">
                <img :src="message.sender_user.profile.avatar.customPath ? message.sender_user.profile.avatar.customPath : message.sender_user.profile.avatar.defaultPath" class="w-[65px] h-[65px] rounded-full" />
                <div class="flex flex-grow pl-4">
                    <ul class="w-1/3">
                        <li x-text="message.sender_user.firstname + ' ' + message.sender_user.lastname"></li>
                        <li x-text="message.subject"></li>
                    </ul>
                    <span class="ml-auto" x-text="message.human_created_at"></span>
                </div>
            </div>
            <div x-cloak x-show="selectedMessage.id == message.id" x-collapse class="mt-6 px-12 py-6">
                <p x-text="message.message"></p>
            </div>
        </div>
    </template>
</div>

@endsection

<!-- prettier-ignore -->
@section('scripts')
<script>
    const messages = ({ fetchReceivedURL }) => ({
        receivedMessages: [],
        selectedMessage: {},
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
