@extends('layouts.app')
<!-- prettier-ignore -->
@section('main-content')
<!-- prettier-ignore -->
<div
    x-data="messages({'fetchReceivedURL': '{{
        route('messages_received')
    }}', 'fetchSentURL': '{{
        route('messages_sent')
    }}', 'deleteMessageInboxURL': '{{
        route('delete_message_inbox')
    }}', 'deleteMessageOutboxURL': '{{
        route('delete_message_outbox')
    }}', 'setMessageReadURL': '{{
        route('set_message_read')
    }}', 'postMessageReplyURL': '{{
        route('message_reply')
    }}', 'setOutboxMessageReadURL': '{{ route('set_outbox_message_read') }}'})"
    class="mt-10 px-2"
>
    <div class="text-center mb-10">
        <h2 class="mb-2 text-2xl">Message chains</h2>
        <a class="no-underline cursor-pointer" @click.prevent="showInbox = true; selectedMessage = {}">
            <h2 class="inline-block text-lg border-2 p-1 rounded w-[175px] hover:border-accent-blue hover:text-white" :class="showInbox ? 'border-accent-blue' : ''">
                I Received
            </h2>
        </a>
        <a class="no-underline cursor-pointer" @click.prevent="showInbox = false; selectedMessage = {}">
            <h2 class="inline-block text-lg border-2 p-1 rounded w-[175px] hover:border-accent-blue hover:text-white" :class="!showInbox ? 'border-accent-blue' : ''">
                I Started
            </h2>
        </a>
    </div>
    <template x-if="showInbox">
        <template x-for="message in receivedMessages">
            <div :class="selectedMessage.id == message.id ? 'border-blue-500 border-2 shadow-blue-500' : 'shadow-gray-500 hover:scale-[1.005]'" class="mx-auto mb-3 border rounded w-full md:w-4/5 lg:w-2/3 xl:w-1/2 p-4 shadow-md transform ease-in-out">
                <div @click="resetMessageClickedState(message)" :class="selectedMessage.id == message.id ? 'border-b border-dashed pb-4' : ''" class="flex items-center cursor-pointer">
                    <img :src="message.sender_user.profile.avatar.customPath ? message.sender_user.profile.avatar.customPath : message.sender_user.profile.avatar.defaultPath" class="w-[65px] h-[65px] rounded-full"/>
                    <div class="flex flex-grow pl-4">
                        <ul class="w-2/3">
                            <li x-text="message.sender_user.firstname + ' ' + message.sender_user.lastname"></li>
                            <li x-text="message.subject"></li>
                        </ul>
                        <div class="ml-auto">
                            <span x-text="message.human_created_at"></span>
                            <svg x-show="message.recipient_has_read == 0" xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5 text-accent-blue" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <svg x-show="message.recipient_has_read == 1" xmlns="http://www.w3.org/2000/svg" class="ml-auto h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="selectedMessage.id == message.id" x-collapse x-transition x-transition:leave.delay="0" class="mt-6 px-2 md:px-12 py-6 cursor-default">
                    <div class="rounded min-h-[150px]">
                        <p>
                            <q class="whitespace-pre-wrap" x-text="message.message"></q>
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <template x-if="message.replies">
                            <template x-for="reply in message.replies.reply_trail">
                                <div :class="message.sender_id == reply.sender_id ? 'self-start text-left' : 'self-end text-right'" class="rounded border w-full md:w-3/4 my-2 p-2">
                                    <small class="block" x-text="reply.human_created_at"></small>
                                    <small class="block" x-text="reply.human_created_at_time"></small>
                                    <q x-text="reply.message" class="block mt-4 whitespace-pre-wrap"></q>
                                </div>
                            </template>
                        </template>
                    </div>
                    <div class="flex justify-end gap-x-2 mt-4">
                        <button x-show="!hasClickedReplyBtn" @click="hasClickedDeleteBtn = true" class="app-btn app-btn-secondary" :disabled="hasClickedDeleteBtn">
                            Delete
                        </button>
                        <button x-show="!hasClickedDeleteBtn" @click="hasClickedReplyBtn = true" class="app-btn app-btn-primary" :disabled="hasClickedReplyBtn">
                            Reply
                        </button>
                    </div>
                    <div x-cloak x-show="hasClickedDeleteBtn">
                        <p>Are you sure? You won't be able to recover it once it's deleted.</p>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedDeleteBtn = false">Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmDeletePressed">Yes, I'm sure</button>
                        </div>
                    </div>
                    <div x-cloak x-show="hasClickedReplyBtn" class="mt-4">
                        <textarea rows="5" class="w-full rounded text-slate-700" placeholder="Enter your reply..." x-model="replyText"></textarea>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedReplyBtn = false">Return</button>
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
                    <img :src="message.recipient_user.profile.avatar.customPath ? message.recipient_user.profile.avatar.customPath : message.recipient_user.profile.avatar.defaultPath" class="w-[65px] h-[65px] rounded-full"/>
                    <div class="flex flex-grow pl-4">
                        <ul class="w-2/3">
                            <li x-text="message.recipient_user.firstname + ' ' + message.recipient_user.lastname"></li>
                            <li x-text="message.subject"></li>
                        </ul>
                        <div class="ml-auto">
                            <span class="ml-auto" x-text="message.human_created_at"></span>
                            <svg x-show="message.sender_has_read == 0" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto text-accent-blue" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            <svg x-show="message.sender_has_read == 1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div x-collapse x-show="selectedMessage.id == message.id" x-transition x-transition:leave.delay="0" class="mt-6 px-12 py-6 cursor-default">
                    <div class="rounded min-h-[150px]">
                        <p>
                            <q class="whitespace-pre-wrap" x-text="message.message"></q>
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <template x-if="message.replies">
                            <template x-for="reply in message.replies.reply_trail">
                                <div :class="message.sender_id == reply.sender_id ? 'self-start text-left' : 'self-end text-right'" class="rounded border w-full md:w-3/4 my-2 p-2">
                                    <small class="block" x-text="reply.human_created_at"></small>
                                    <small class="block" x-text="reply.human_created_at_time"></small>
                                    <q x-text="reply.message" class="block mt-4 whitespace-pre-wrap"></q>
                                </div>
                            </template>
                        </template>
                    </div>
                    <div class="flex justify-end gap-x-2 mt-4">
                        <button x-show="!hasClickedOutboxReplyBtn" @click="hasClickedOutboxDeleteBtn = true" class="app-btn app-btn-secondary" :disabled="hasClickedOutboxDeleteBtn">
                            Delete
                        </button>
                        <button x-show="!hasClickedOutboxDeleteBtn" @click="hasClickedOutboxReplyBtn = true" class="app-btn app-btn-primary" :disabled="hasClickedOutboxReplyBtn">
                            Reply
                        </button>
                    </div>
                    <div x-cloak x-show="hasClickedOutboxDeleteBtn">
                        <p>Are you sure? This chain will be removed and you won't be able to retrieve it.</p>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedOutboxDeleteBtn = false">Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmOutboxDeletePressed">Yes, I'm sure</button>
                        </div>
                    </div>
                    <div x-cloak x-show="hasClickedOutboxReplyBtn" class="mt-4">
                        <textarea rows="5" class="w-full rounded text-slate-700" placeholder="Enter your reply..." x-model="replyText"></textarea>
                        <div class="flex gap-x-2 mt-2">
                            <button class="app-btn app-btn-secondary" @click="hasClickedOutboxReplyBtn = false">Return</button>
                            <button class="app-btn app-btn-primary" @click="confirmReplyPressed">Send</button>
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
    const messages = ({ fetchReceivedURL, fetchSentURL, deleteMessageInboxURL, deleteMessageOutboxURL, setMessageReadURL, postMessageReplyURL, setOutboxMessageReadURL }) => ({
        receivedMessages: [],
        sentMessages: [],
        selectedMessage: {},
        hasClickedDeleteBtn: false,
        hasClickedReplyBtn: false,
        csrfToken: null,
        replyText: null,
        showInbox: true,
        hasClickedOutboxDeleteBtn: false,
        hasClickedOutboxReplyBtn: false,
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
                console.log(this.sentMessages)
            } catch (errCode) {
                this.showErrorToast()
            }
        },
        async resetMessageClickedState(message) {
            this.replyText = null
            if (this.selectedMessage.id != message.id) {
                this.selectedMessage = message
                if (this.showInbox) this.setMessageAsRead()
                if (!this.showInbox) this.setOutboxAsRead()
            } else {
                this.selectedMessage = {}
            }
            this.hasClickedDeleteBtn = false
            this.hasClickedReplyBtn = false;
            this.hasClickedOutboxDeleteBtn = false;
            this.hasClickedOutboxReplyBtn = false;
        },
        async setMessageAsRead() {
            try {
                const response = await fetch(setMessageReadURL, {
                    method: 'post',
                    body: JSON.stringify(this.selectedMessage),
                    headers: {
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                })
                const json = await response.json();
                if (!json.success) throw Error(0)
            } catch (errCode) {
                this.showErrorToast();
                return;
            }
            const thisMessage = this.receivedMessages.find((x) => x.id == this.selectedMessage.id);
            thisMessage.recipient_has_read = 1;
        },
        async setOutboxAsRead() {
            try {
                const response = await fetch(setOutboxMessageReadURL, {
                    method: 'post',
                    body: JSON.stringify(this.selectedMessage),
                    headers: {
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                })
                const json = await response.json();
                if (!json.success) throw Error(0)
            } catch (errCode) {
                this.showErrorToast();
                return;
            }
            const thisMessage = this.sentMessages.find((x) => x.id == this.selectedMessage.id);
            thisMessage.sender_has_read = 1;
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
            try {
                const response = await fetch(postMessageReplyURL, {
                    method: 'post',
                    body: JSON.stringify({
                        messageContent: this.replyText,
                        messageParent: this.selectedMessage,
                        setSenderUnread: this.showInbox
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        "X-Requested-With": "XMLHttpRequest",
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });
                if (response.status == 422) throw Error(0);
                const json = await response.json()
                if (this.selectedMessage.replies) {
                    this.selectedMessage.replies.reply_trail.push(json.reply)
                } else {
                    this.selectedMessage.replies = {
                        'message_id': this.selectedMessage.id,
                        'reply_trail': [json.reply]
                    }
                }
            } catch (errCode) {
                this.showErrorToast()
                switch (errCode.message) {
                    case '0':
                        console.log(errCode);
                        return;
                    default:
                        console.log(errCode);
                        return;
                }
            }
            this.showToast('Reply sent')
            this.replyText = null;
            this.hasClickedReplyBtn = false;
            this.hasClickedOutboxReplyBtn = false;
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
        showToast(msg = 'Message deleted') {
            this.$nextTick(() => {
                Alpine.store("toast").showSuccessToast = true
                Alpine.store("toast").toastMessage = msg
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
