<!-- prettier-ignore -->
<div x-data x-cloak x-show="$store.userCard.showMessageModal" class="flex m-auto items-center fixed inset-0 z-50 h-full w-full sm:app-sm-modal">
    <div class="p-4 w-full">
        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-5 rounded-t border-b bg-slate-700">
                <h3 class="text-xl font-semibold lg:text-2xl">Message Member</h3>
                <button @click="$store.userCard.closeMessageFormModal; $refs.messageMemberForm.reset()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg> 
                </button>
            </div>
            <div class="p-6">
                <div x-cloak x-show="$store.userCard.showMemberMessageFormError" class="text-red-500 text-center sm:w-3/4 mx-auto mb-2">
                    <p class="m-0" x-text="$store.userCard.errorText"></p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <p x-cloak x-show="!$store.userCard.memberMessagedSuccess" class="text-slate-700 mb-8 italic text-sm">Messages you send and receive will only be visible between yourself and the other member. However, please be careful with the information you share.</p>
                <form method="post" class="text-slate-700 pt-1" x-show="!$store.userCard.memberMessagedSuccess" x-ref="messageMemberForm" id="f_messageMemberForm">
                   @csrf
                    <input name="recipient" type="hidden" :value="$store.userCard.messageUser.id"  />
                    <template x-if="$store.userCard.showMessageModal">
                        <div class="flex items-center">
                            <img 
                            :src="$store.userCard.messageUser.profile.avatar.customPath ? $store.userCard.messageUser.profile.avatar.customPath : $store.userCard.messageUser.profile.avatar.defaultPath" 
                            class="h-[65px] w-[65px] rounded-full border-2 object-cover block max-w-full hover:scale-105" />
                            <div>
                                <ul class="list-stype-none pl-2">
                                    <li class="text-sm font-bold" x-text="$store.userCard.messageUser.firstname + ' ' + $store.userCard.messageUser.lastname"></li>
                                    <li class="text-sm italic" x-text="$store.userCard.messageUser.profile.tagline"></li>
                                </ul>
                            </div>
                        </div>
                    </template>
                    <div class="border border-slate-500 rounded mt-4 md:w-2/3">
                        <input name="subject" class="w-full rounded pl-4 outline-blue-700" placeholder="Subject..." maxlength="100" />
                    </div>
                    <div class="border mt-1 rounded">
                        <textarea name="message" class="w-full rounded" rows="7" placeholder="Write your message..."></textarea>
                    </div>
                </form>
                <div x-show="$store.userCard.memberMessagedSuccess" class="text-slate-700 text-center sm:w-2/3 mx-auto">
                    <h2>Great.</h2>
                    <h3 class="mt-4">A message has been sent.</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 animate-bounce mx-auto mt-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 bg-slate-700">
                <button @click="$store.userCard.closeMessageFormModal; $refs.messageMemberForm.reset()" type="button" class="app-btn app-btn-secondary ml-auto">
                    Close
                </button>
                <button type="button" class="app-btn app-btn-primary" @click.prevent="$store.userCard.submitMessageForm" :disabled="$store.userCard.memberMessagedSuccess">Submit</button>
            </div>
        </div>
    </div>
</div>
