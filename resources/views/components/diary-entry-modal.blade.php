<!-- prettier-ignore -->
<div x-cloak x-show="showModal" :class="showModal ? 'flex' : ''" class="m-auto items-center fixed inset-0 z-50 h-full w-full sm:app-sm-modal">
    <div class="p-4 w-full">
        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-5 rounded-t border-b bg-slate-700">
                <h3 class="text-xl font-semibold lg:text-2xl">Diary Entry</h3>
                <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg> 
                </button>
            </div>
            <div class="p-6 text-slate-700">
                <p class="text-left" x-text="humanDateString"></p>
            </div>
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 bg-slate-700">
                <button @click="showModal = false" type="button" class="app-btn app-btn-secondary ml-auto">Close</button>
                <button type="button" class="app-btn app-btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>