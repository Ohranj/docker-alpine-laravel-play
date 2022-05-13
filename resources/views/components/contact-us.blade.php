<!-- prettier-ignore -->
<div x-cloak x-show="showModal" :class="showModal ? 'flex' : ''" class="m-auto items-center fixed inset-0 z-50 h-full w-full sm:app-sm-modal">
    <div class="p-4 w-full">
        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-5 rounded-t border-b bg-slate-700">
                <h3 class="text-xl font-semibold lg:text-2xl">Contact Us</h3>
                <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg> 
                </button>
            </div>
            <div class="p-6">
                <div x-cloak x-show="showError" class="text-red-500 text-center sm:w-3/4 mx-auto">
                    <p class="m-0" x-text="errorText"></p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <form method="post" class="text-slate-700 pt-1" id="f_contactUsForm" x-show="!submitSuccess">
                   @csrf
                    <div class="flex gap-x-5">
                        <div class="flex-1">
                            <label for="name" class="block">Name <sup>*</sup></label>
                            <input name="name" class="w-full border-2 rounded border-slate-700" />
                        </div>
                        <div class="flex-1">
                            <label for="surname" class="block">Surname <sup>*</sup></label>
                            <input name="surname" class="w-full border-2 rounded border-slate-700" />
                        </div>
                    </div>
                    <div class="flex mb-5 mt-2 gap-x-5">
                        <div class="basis-7/12">
                            <label for="email" class="block">Email <sup>*</sup></label>
                            <input name="email" type="email" class="w-full border-2 rounded border-slate-700 p-0" />
                        </div>
                        <div class="flex-1 sm:flex-none">
                            <label for="phone" class="block">Phone No.</label>
                            <input name="phone" class="w-full border-2 rounded border-slate-700" />
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block">Message <sup>*</sup></label>
                        <textarea name="message" class="border-2 rounded border-slate-700 w-full"></textarea>
                    </div>
                </form>
                <div x-show="submitSuccess" class="text-slate-700 text-center sm:w-2/3 mx-auto">
                    <h2>Thank You.</h2>
                    <h3 class="mt-4">We have received your message and aim to get back to you shortly</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 animate-bounce mx-auto mt-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 bg-slate-700">
                <button @click="showModal = false" type="button" class="app-btn app-btn-secondary ml-auto">
                    Close
                </button>
                <button type="button" class="app-btn app-btn-primary" @click.prevent="submitForm" :disabled="submitSuccess">Submit</button>
            </div>
        </div>
    </div>
</div>
