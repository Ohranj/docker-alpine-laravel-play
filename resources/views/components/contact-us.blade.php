<!-- prettier-ignore -->
<div x-cloak x-show="showModal" :class="showModal ? 'flex' : ''" class="m-auto items-center fixed inset-0 z-50 h-full w-full sm:app-sm-modal">
    <div class="p-4 w-full">
        <div class="bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-between items-center p-5 rounded-t border-b bg-slate-700">
                <h3 class="text-xl font-semibold lg:text-2xl">Contact Us</h3>
                <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg> 
                </button>
            </div>
            <div class="p-6 space-y-6">
               <form method="post" class="text-slate-700" id="f_contactUsForm">
                   @csrf
                    <div class="flex gap-x-5">
                        <div class="flex-1 sm:flex-none">
                            <label for="name" class="block">Name</label>
                            <input name="name" class="w-full border-2 rounded border-slate-700" />
                        </div>
                        <div class="flex-1 sm:flex-none">
                            <label for="surname" class="block">Surname</label>
                            <input name="surname" class="w-full border-2 rounded border-slate-700" />
                        </div>
                    </div>
                    <div class="flex mb-5 mt-2 gap-x-5">
                        <div class="basis-7/12">
                            <label for="email" class="block">Email</label>
                            <input name="email" type="email" class="w-full border-2 rounded border-slate-700" />
                        </div>
                        <div class="flex-1 sm:flex-none">
                            <label for="phone" class="block">Phone No.</label>
                            <input name="phone" class="w-full border-2 rounded border-slate-700" />
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block">Message</label>
                        <textarea name="message" class="border-2 rounded border-slate-700 w-full"></textarea>
                    </div>
               </form>
            </div>
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 bg-slate-700">
                <button @click="showModal = false" type="button" class="app-btn app-btn-secondary ml-auto">
                    Close
                </button>
                <button type="button" class="app-btn app-btn-primary" @click.prevent="submitForm">Submit</button>
            </div>
        </div>
    </div>
</div>
