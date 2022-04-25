@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div x-data="messages({'fetchReceivedURL': '{{route('messages_received')}}', 'fetchSentURL': '{{route('messages_sent')}}', 'deleteMessageInboxURL': '{{route('delete_message_inbox')}}', 'deleteMessageOutboxURL': '{{route('delete_message_outbox')}}'})" class="mt-10">
    <div class="text-center mb-10">
        <a class="no-underline cursor-pointer" @click.prevent="showInbox = true; selectedMessage = {}">
            <h2 class="inline-block text-lg border-2 p-1 rounded w-[125px] hover:border-accent-blue hover:text-white" :class="showInbox ? 'border-accent-blue' : ''">Inbox</h2>
        </a>
        <a class="no-underline cursor-pointer" @click.prevent="showInbox = false; selectedMessage = {}">
            <h2 class="inline-block text-lg border-2 p-1 rounded w-[125px] hover:border-accent-blue hover:text-white" :class="!showInbox ? 'border-accent-blue' : ''">Outbox</h2>
        </a>
    </div>
    <template x-if="showInbox">
        <template x-for="message in receivedMessages">
            <div :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto mb-3 border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out">
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
                        <p>
                            <q x-text="message.message"></q>
                        </p>
                    </div>
                    <div class="flex justify-end gap-x-2">
                        <button x-show="!hasClickedReplyBtn" @click="hasClickedDeleteBtn = true" class="app-btn app-btn-secondary" :disabled="hasClickedDeleteBtn" >Delete</button>
                        <button x-show="!hasClickedDeleteBtn" @click="hasClickedReplyBtn = true" class="app-btn app-btn-primary" :disabled="hasClickedReplyBtn">Reply</button>
                    </div>
                    <div x-cloak x-show="hasClickedDeleteBtn">
                        <p>Are you sure? You won't be able to recover it once it's deleted.</p>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedDeleteBtn = false" >Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmDeletePressed">Yes, I'm sure</button>
                        </div>
                    </div>
                    <div x-cloak x-show="hasClickedReplyBtn" class="mt-4">
                        <textarea rows="5" class="w-full rounded text-slate-700" placeholder="Enter your reply..." x-model="replyText"></textarea>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedReplyBtn = false" >Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmReplyPressed">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </template>
    <template x-if="!showInbox">
        <template x-for="message in sentMessages">
            <div :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto mb-3 border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out">
                <div class="flex items-center cursor-pointer" :class="selectedMessage.id == message.id ? 'border-b border-dashed pb-4' : ''" @click="resetMessageClickedState(message)">
                    <img :src="message.recipient_user.profile.avatar.customPath ? message.recipient_user.profile.avatar.customPath : message.recipient_user.profile.avatar.defaultPath" class="w-[65px] h-[65px] rounded-full" />
                    <div class="flex flex-grow pl-4">
                        <ul class="w-1/3">
                            <li x-text="message.recipient_user.firstname + ' ' + message.recipient_user.lastname"></li>
                            <li x-text="message.subject"></li>
                        </ul>
                        <span class="ml-auto" x-text="message.human_created_at"></span>
                    </div>
                </div>
                <div x-collapse x-show="selectedMessage.id == message.id" x-transition x-transition:leave.delay="0" class="mt-6 px-12 py-6 cursor-default">
                    <div class="rounded min-h-[150px]">
                        <p>
                            <q x-text="message.message"></q>
                        </p>
                    </div>
                    <div class="flex justify-end gap-x-2">
                        <button @click="hasClickedOutboxDeleteBtn = true" class="app-btn app-btn-secondary" :disabled="hasClickedOutboxDeleteBtn">Delete</button>
                    </div>
                    <div x-cloak x-show="hasClickedOutboxDeleteBtn">
                        <p>Are you sure? You won't be able to recover it once it's deleted.</p>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedOutboxDeleteBtn = false">Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmOutboxDeletePressed">Yes, I'm sure</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </template>
</div>

@endsection

<!-- prettier-ignore -->
@section('scripts')
<!-- prettier-ignore -->
<script>
    const messages = ({ fetchReceivedURL, fetchSentURL, deleteMessageInboxURL, deleteMessageOutboxURL }) => ({
        receivedMessages: [],
        sentMessages: [],
        selectedMessage: {},
        hasClickedDeleteBtn: false,
        hasClickedReplyBtn: false,
        csrfToken: null,
        replyText: null,
        showInbox: true,
        hasClickedOutboxDeleteBtn: false,
        async init() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')['content']
            try {
                const [received, sent] = await Promise.all([
                    fetch(fetchReceivedURL),
                    fetch(fetchSentURL)
                ]);
                const [receivedMessagesJSON, sentMessagesJSON] = await Promise.all([
                    await received.json(),
                    await sent.json()
                ]);
                if (!receivedMessagesJSON.success) throw new Error(0);
                this.receivedMessages = receivedMessagesJSON.data;
                if (!sentMessagesJSON.success) throw new Error(1);
                this.sentMessages = sentMessagesJSON.data;
            } catch (errCode) {
                console.log(errCode);
            }
        },
        resetMessageClickedState(message) {
            if (this.selectedMessage.id != message.id) {
                this.selectedMessage = message
            } else {
                this.selectedMessage = {}
            }
            this.hasClickedDeleteBtn = false
            this.hasClickedReplyBtn = false;
            this.hasClickedOutboxDeleteBtn = false;
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
            } catch (errCode) {
                this.showErrorToast()
                return;
            }
            const index = this.receivedMessages.findIndex((x) => x.id == this.selectedMessage.id);
            this.receivedMessages.splice(index, 1);
            this.showToast()
        },
        async confirmReplyPressed() {
            //Store in seperate table for chained messages
            this.showToast()
            this.replyText = null;
            this.hasClickedReplyBtn = false;
        },
        async confirmOutboxDeletePressed() {
            try {
                const response = await fetch(deleteMessageOutboxURL, {
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
            } catch (errCode) {
                this.showErrorToast()
                return;
            }
            const index = this.sentMessages.findIndex((x) => x.id == this.selectedMessage.id);
            this.sentMessages.splice(index, 1);
            this.showToast()
        },
        showToast() {
            this.$nextTick(() => {
                Alpine.store("toast").showSuccessToast = true
                Alpine.store("toast").toastMessage = 'Message deleted'
            });
        },
        showErrorToast() {
            this.$nextTick(() => {
                Alpine.store("toast").showErrorToast = true
                Alpine.store("toast").toastMessage = 'Error. Please try again.'
            });
        }
    });
</script>
@endsection
