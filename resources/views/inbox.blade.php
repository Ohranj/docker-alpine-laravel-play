@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div x-data="messages({'fetchReceivedURL': '{{route('messages_received')}}'})" class="mt-10">
    <template x-for="message in receivedMessages">
        <div :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out cursor-pointer">
            <div @click="selectedMessage = selectedMessage.id == message.id ? {} : message" :class="selectedMessage.id == message.id ? 'border-b border-dashed pb-4' : ''" class="flex items-center">
                <img :src="message.sender_user.profile.avatar.customPath ? message.sender_user.profile.avatar.customPath : message.sender_user.profile.avatar.defaultPath" class="w-[65px] h-[65px] rounded-full" />
                <div class="flex flex-grow pl-4">
                    <ul class="w-1/3">
                        <li x-text="message.sender_user.firstname + ' ' + message.sender_user.lastname"></li>
                        <li x-text="message.subject"></li>
                    </ul>
                    <span class="ml-auto" x-text="message.human_created_at"></span>
                </div>
            </div>
            <div x-cloak x-show="selectedMessage.id == message.id" x-collapse x-transition x-transition:leave.delay="0" class="mt-6 px-12 py-6 cursor-default">
                <div class="rounded min-h-[150px]">
                    <p x-text="message.message"></p>
                </div>
                <div class="flex justify-end gap-x-2">
                    <button @click="() => deleteBtnPressed()" class="app-btn app-btn-secondary">Delete</button>
                    <button @click="replyBtnPressed" class="app-btn app-btn-primary">Reply</button>
                </div>
                <div></div>
            </div>
        </div>
    </template>
</div>

@endsection

<!-- prettier-ignore -->
@section('scripts')
<!-- prettier-ignore -->
<script>
    const messages = ({ fetchReceivedURL }) => ({
        receivedMessages: [],
        selectedMessage: {},
        hasClickedDeleteBtn: false,
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
        deleteBtnPressed() {
            this.hasClickedDeleteBtn = true;
            this.$nextTick(() => {
                Alpine.store("toast").showSuccessToast = true
                Alpine.store("toast").toastMessage = 'Message deleted'
            });
            console.log(this.selectedMessage);
        },
        replyBtnPressed() {
            console.log("reply");
        },
    });
</script>
@endsection
