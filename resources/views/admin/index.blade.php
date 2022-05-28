@extends('layouts.admin')
<!-- prettier-ignore -->
@section('main-content')
<x-admin-nav />
<div class="w-full h-full flex flex-col">
    <div x-data="uploaders({'uploadUsersURL': '{{route('upload_users')}}'})" class="border w-3/4 mx-auto grid grid-cols-2 items-center justify-items-center flex-grow">
        <div @click="$refs.userUploadInput.click()" class="w-[375px] h-[200px] rounded bg-blue-600 text-white text-2xl text-center flex flex-col justify-center border border-dashed cursor-pointer">
            <h2 class="font-bold">Users</h2>
            <p>click or drag a file to be uploaded</p>
        </div>
        <button @click="uploadUsersBtnPressed($refs.userUploadInput)" class="app-btn app-btn-primary">Upload</button>
        <input name="user_upload_file" x-ref="userUploadInput" type="file" />
    </div>
    <div x-data="downloaders" class="h-[250px] flex flex-col justify-center items-center">
        <h3 class="text-2xl">Downloads</h3>
        <div class="flex items-center justify-center gap-x-2">
            <button class="app-btn bg-red-600">Users</button>
            <button class="app-btn bg-red-600">Misc.</button>
        </div>
    </div>
</div>
@endsection

<!-- prettier-ignore -->
@section('scripts')
<script>
    const uploaders = ({uploadUsersURL}) => ({
        csrfToken: null,
        init() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]')['content']
        },
        async uploadUsersBtnPressed(inputElem) {
            const formData = new FormData();
            formData.append('user_upload_file', inputElem.files[0])
            const response = await fetch(uploadUsersURL, {
                method: 'post',
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': this.csrfToken,
                }
            });
            const json = await response.json();
            console.log(json)
        }
    })
    const downloaders = () => ({
        init() {
            console.log('Uploaders init')
        }
    })
</script>
@endsection