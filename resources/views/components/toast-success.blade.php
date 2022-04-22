<!-- prettier-ignore -->
<div x-data x-transition x-cloak x-show="$store.userCard.showSuccessToast" class="cursor-pointer absolute bottom-2 right-2 flex items-center justify-between max-w-xs p-4 bg-white border rounded-md shadow-sm shadow-green-600 w-[200px]">
    <div class="flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <p class="ml-3 text-sm font-bold text-green-600" x-text="$store.userCard.toastMessage">
            
        </p>
    </div>
    <span class="inline-flex items-center cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 absolute top-1 right-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" @click="$store.userCard.showSuccessToast = false" @click.outside="$store.userCard.showSuccessToast = false">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </span>
</div>
