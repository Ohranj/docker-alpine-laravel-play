@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div x-data="messages({'fetchReceivedURL': '{{route('messages_received')}}', 'deleteMessageInboxURL': '{{route('delete_message_inbox')}}'})" class="mt-10">
    <template x-for="message in receivedMessages">
        <div :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out">
            <div @click="resetMessageClickedState(message)" :class="selectedMessage.id == message.id ? 'border-b border-dashed pb-4' : ''" class="flex items-center cursor-pointer">
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
                    <button @click="hasClickedDeleteBtn = true" class="app-btn app-btn-secondary" :disabled="hasClickedDeleteBtn" >Delete</button>
                    <button x-show="!hasClickedDeleteBtn" @click="replyBtnPressed" class="app-btn app-btn-primary">Reply</button>
                </div>
                <div x-cloak x-show="hasClickedDeleteBtn">
                    <p>Are you sure? You won't be able to recover it once it's deleted.</p>
                    <div class="flex gap-x-2 mt-2">
                        <button class="app-btn app-btn-secondary" @click="hasClickedDeleteBtn = false" >Return</button>
                        <button class="app-btn app-btn-primary" @click="confirmDeletePressed">Yes, I'm sure</button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@endsection

<!-- prettier-ignore -->
@section('scripts')
<!-- prettier-ignore -->
<script>
    const messages = ({ fetchReceivedURL, deleteMessageInboxURL }) => ({
        receivedMessages: [],
        selectedMessage: {},
        hasClickedDeleteBtn: false,
        csrfToken: null,
        async init() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')['content']
            try {
                const response = await fetch(fetchReceivedURL);
                const json = await response.json();
                if (!json.success) throw new Error(0);
                this.receivedMessages = json.data;
            } catch (errCode) {
                console.log(errCode);
            }
        },
        resetMessageClickedState(message) {
            if (this.selectedMessage.id != message.id) {
                this.selectedMessage = message
                return;
            }
            this.selectedMessage = {}
            this.hasClickedDeleteBtn = false
        },
        async confirmDeletePressed() {
            try {
                const response = await fetch(deleteMessageInboxURL, {
                    method: 'delete',
                    body: JSON.stringify(this.selectedMessage),
                    headers: {
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                })
                const json = await response.json();
                if (!json.success) throw Error(0);
                this.$nextTick(() => {
                    Alpine.store("toast").showSuccessToast = true
                    Alpine.store("toast").toastMessage = 'Message deleted'
                });
            } catch (errCode) {
                console.log(errCode)
            }
        },
        replyBtnPressed() {
            console.log("reply");
        },
    });
</script>
@endsection
