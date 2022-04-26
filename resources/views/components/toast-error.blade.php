<!-- prettier-ignore -->
<div x-data x-transition x-cloak x-show="$store.toast.showErrorToast" class="z-50 fixed cursor-pointer bottom-2 right-2 flex items-center justify-between max-w-xs p-4 bg-white border rounded-md shadow-sm shadow-yellow-600 w-[250px]">
  <div class="flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd"
        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
        clip-rule="evenodd" />
    </svg>
    <p class="ml-3 text-sm font-bold text-yellow-600" x-text="$store.toast.toastMessage"></p>
  </div>
  <span class="inline-flex items-center cursor-pointer">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 absolute top-1 right-1" fill="none" viewBox="0 0 24 24"
      stroke="currentColor" @click="$store.toast.showErrorToast = false" @click.outside="$store.toast.showErrorToast = false">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </span>
</div>
