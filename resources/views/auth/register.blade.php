<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="register({registerFormURL: '{{ route('register') }}'})" class="m-auto h-2/3 w-full px-1">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8">Fitness Tracker</h1>
    <h2 class="text-center text-3xl sm:text-3xl mb-5 sm:mb-8">Register</h2>
    <div class="h-[20px] w-11/12 mx-auto rounded-full ring-2 ring-white">
        <div :class="stepsCompleted == 0 ? 'w-1/3' : stepsCompleted == 1 ? 'w-2/3' : 'w-full'" class="bg-blue-600 h-full rounded-full flex content-center justify-center text-sm">
            <span x-cloak x-text="progressBarText[stepsCompleted]"></span>
        </div>
    </div>
    <div>
        <p class="text-red-500 mt-5 text-sm text-center" x-text="errorText"></p>
        <div x-cloak x-show="stepsCompleted == 0" x-transition class="mt-5 p-3 shadow-xl shadow-red-300 rounded">
            <p class="mb-2">The information provided throughout the registration will go towards creating your profile card. This a publicly viewable snapshot of yourself.</p>
            <small>You will have chance to see your card prior to confirming your registration.</small>
            <form class="my-6 border-t-2">
                <div class="my-4">
                    <label for="email">Email<sup>*</sup></label>
                    <input name="email" type="email" class="block mt-1 w-full" placeholder="Enter your email..." x-model="inputData.email" />
                </div>
                <div class="my-4">
                    <label for="password">Password<sup>*</sup></label>
                    <input name="password" type="password" class="block mt-1 w-full" placeholder="Enter your password..." x-model="inputData.password" />
                </div>
                <div class="my-4">
                    <label for="confirm-password">Confirm Password<sup>*</sup></label>
                    <input name="confirm-password" type="password" class="block mt-1 w-full" placeholder="Confirm your password..." x-model="inputData.confirmPassword" />
                </div>
                <div class="my-4 flex gap-x-2">
                    <div class="flex-grow">
                        <label for="firstname">Firstname<sup>*</sup></label>
                        <input name="firstname" type="text" class="block mt-1 w-full" placeholder="Enter your firstname..." x-model="inputData.firstname" />
                    </div>
                    <div class="flex-grow">
                        <label for="firstname">Surname<sup>*</sup></label>
                        <input name="firstname" type="text" class="block mt-1 w-full" placeholder="Enter your surname..." x-model="inputData.surname" />
                    </div>
                </div>
                <button class="app-btn app-btn-primary block mx-auto" @click.prevent="confirmFirstPressed">Confirm</button>
            </form>
        </div>
        <div x-cloak x-show="stepsCompleted == 1" x-transition class="mt-5 p-3 shadow-xl shadow-red-300 rounded">
            <p class="mb-2">Here you have the opportunity to share a little more about yourself. A tag line, a recent achievement or what you're looking forward to. Amongst some key tags you resonate with.</p>
            <form class="my-6 border-t-2">
                <div class="my-4">
                    <label for="tagline">Tagline<sup>*</sup></label>
                    <input name="tagline" type="text" class="block mt-1 w-full" placeholder="Enter a tagline..." maxlength="50" x-model="cardData.tagline" />
                </div>
                <div class="my-4">
                    <label for="tags">Tags<sup>*</sup><small class="ml-4">Tags should be comma seperated.</small></label>
                    <input name="tags" type="text" class="block mt-1 w-full" placeholder="Enter some tags... i.e. sleepy, home workout, in the zone" maxlength="50" x-model="cardData.tags" />
                </div>
                <div class="my-4">
                    <label for="level">Experience Level<sup>*</sup></label>
                    <select name="level" x-model="cardData.level" class="block mt-1 w-full text-black">
                        <option value="" disabled>Select an option...</option>
                        <option value="4">more than 3 years</option>
                        <option value="3">1 - 3 years</option>
                        <option value="2">6 - 12 months</option>
                        <option value="1"> less than 6 months</option>
                    </select>
                </div>
            </form>
            <div class="flex justify-center gap-x-4">
                <button class="app-btn app-btn-secondary" @click.prevent="backPressed">Back</button>
                <button class="app-btn app-btn-primary" @click.prevent="confirmSecondPressed">Confirm</button>
            </div>
        </div>
        <div x-cloak x-show="stepsCompleted == 2" x-transition class="mt-3 p-3">
            <form method="post" id="f_register">
                @csrf
                <div :class="cardData.level == 1 ? 'shadow-green-300' : cardData.level == 2 ? 'shadow-orange-300' : cardData.level == 3 ? 'shadow-indigo-300' : 'shadow-red-300'" class="h-[400px] w-[300px] mx-auto mb-6 flex flex-col shadow-lg rounded">
                    <div class="w-[105px] h-[150px] relative mx-auto">
                        <img src="/img/gravatars/iv219dqg2ef71.jpg" class="w-[105px] h-[105px] rounded-full mx-auto mt-5 cursor-pointer" @click="$refs.avatarUpload.click()" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute -right-2 top-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        <input name="avatar" x-ref="avatarUpload" type="file" accept="image/*" hidden />
                    </div>
                    <div class="mt-2">
                        <p class="text-center text-xl" x-text="inputData.firstname"></p>
                        <p class="text-center text-xl" x-text="inputData.surname"></p>
                    </div>
                    <ul class="flex flex-wrap gap-4 text-center justify-center content-center flex-grow">
                        <template x-for="tag in cardData.tags.split(',')">
                            <li class="border rounded w-[125px] min-h-[30px] flex justify-center items-center px-2 text-sm" x-text="tag.trim()"></li>
                        </template>
                    </ul>   
                    <div class="border-t mt-auto py-2 text-center text-sm" x-text="cardData.tagline"></div>
                </div>
                <div class="flex justify-center gap-x-4">
                    <button class="app-btn app-btn-secondary" type="button" @click="backPressed">Back</button>
                    <button class="app-btn app-btn-primary" @click.prevent="registerBtnPressed()">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- prettier-ignore -->
@section('script')
<!-- prettier-ignore -->
<script>
    const register = ({ registerFormURL }) => ({
        stepsCompleted: 2,
        progressBarText: ["Step 1", "Step 2", "Step 3"],
        errorTextArray: ['Please make sure all fields marked (*) are completed before proceeding', 'Please make sure the password and confirm password fields match.', 'Passwords should contain at least 8 digits and be made up of digits and uppercase / lowercase characters'],
        errorText: null,
        inputData: {
            email: "",
            password: "",
            confirmPassword: "",
            firstname: "",
            surname: "",
        },
        cardData: {
            tagline: '',
            tags: '',
            level: ''
        },
        formEl: null,
        init() {
            this.formEl = document.getElementById('f_register');
        },
        confirmFirstPressed() {
            try {
                const allInputsFilled = Object.values(this.inputData).every((x) => x);
                if (!allInputsFilled) throw Error(0);
                const { password, confirmPassword } = this.inputData;
                if (password !== confirmPassword) throw Error(1);
                if (password.length < 8) throw Error(2);
                if (!/\d/.test(password)) throw Error(2);
                if (!/[A-Z]/.test(password)) throw Error(2);
                if (!/[a-z]/.test(password)) throw Error(2);
                this.stepsCompleted++
                this.errorText = null
            } catch (errCode) {
                const val = errCode.message;
                this.errorText = this.errorTextArray[val]
            }
        },
        confirmSecondPressed() {
            try {
                const allInputsFilled = Object.values(this.cardData).every((x) => x);
                if (!allInputsFilled) throw Error(0);
                this.stepsCompleted++;
                this.errorText = null
            } catch (errCode) {
                const val = errCode.message;
                this.errorText = this.errorTextArray[val]
            }
        },
        backPressed() {
            this.stepsCompleted--;
        },
        createFormDataObj() {
            const formData = new FormData(this.formEl);
            const {email, password, confirmPassword, firstname, surname} = this.inputData;
            const {tagline, tags, level} = this.cardData;
            formData.append('email', email)
            formData.append('password', password)
            formData.append('confirmPassword', confirmPassword);
            formData.append('firstname', firstname);
            formData.append('surname', surname);
            formData.append('tagline', tagline);
            formData.append('tags', tags);
            formData.append('level', level);
            return formData;
        },
        async registerBtnPressed() {
            const formData = this.createFormDataObj();
            try {
                const response = await fetch(registerFormURL, {
                    method: 'post',
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                const p = await response.json();
                console.log(p)
                if (response.status == 422) throw Error(0)
            } catch (errCode) {
                const val = errCode.message;
                this.errorText = this.errorTextArray[val]
            }
        },
    });
</script>
@endsection
