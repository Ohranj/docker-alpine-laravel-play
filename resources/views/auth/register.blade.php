<!-- prettier-ignore -->
@extends('layouts.guest')

@section('main-content')
<!-- prettier-ignore -->
<div x-data="register({registerFormURL: '{{ route('register') }}'})" class="m-auto h-2/3 w-full px-1">
    <h1 class="text-center text-4xl sm:text-5xl mb-5 sm:mb-8" :class="registeredSuccess ? 'text-red-500' : ''">Fitness Tracker</h1>
    <h2 class="text-center text-3xl sm:text-3xl mb-5 sm:mb-8" :class="registeredSuccess ? 'text-red-500' : ''" x-text="registeredSuccess ? 'Registered' : 'Register'"></h2>
    <div class="h-[20px] w-11/12 mx-auto rounded-full ring-2 ring-white">
        <div :class="stepsCompleted == 0 ? 'w-1/3' : stepsCompleted == 1 ? 'w-2/3' : 'w-full'" class="bg-blue-600 h-full rounded-full flex content-center justify-center text-sm">
            <span x-cloak x-text="progressBarText[stepsCompleted]"></span>
        </div>
    </div>
    <div>
        <p class="text-red-500 mt-5 text-sm text-center" x-text="errorText"></p>
        <div x-cloak x-show="registeredSuccess" x-transition.opacity class="text-slate-700 text-center mx-auto bg-slate-100 rounded mt-5 px-6 py-8">
            <h2>Thank You.</h2>
            <h3 class="my-4">You have successfully registered.</h3>
            <p>You will need to confirm your email address prior to logging in for the first time. An email has been sent to the address you used to register with. Please make sure to check your spam folder.</p>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 animate-bounce mx-auto mt-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <small>
                <a href="{{route('login')}}">You may click here to redirect to the login page.</a>
            </small>
        </div>
        <div x-cloak x-show="stepsCompleted == 0 && !registeredSuccess" class="mt-5 p-3 shadow-xl shadow-red-300 rounded">
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
        <div x-cloak x-show="stepsCompleted == 1 && !registeredSuccess" class="mt-5 p-3 shadow-xl shadow-red-300 rounded">
            <p class="mb-2">Here you have the opportunity to share a little more about yourself. A tag line, a recent achievement or what you're looking forward to. Amongst some key tags you resonate with.</p>
            <form class="my-6 border-t-2">
                <div class="my-4">
                    <label for="tagline">Tagline<sup>*</sup></label>
                    <input name="tagline" type="text" class="block mt-1 w-full" placeholder="Enter a tagline..." maxlength="38" x-model="cardData.tagline" />
                </div>
                <div class="my-4">
                    <label for="tags">Tags<sup>*</sup><small class="ml-4">Tags should be comma seperated.</small></label>
                    <input name="tags" type="text" class="block mt-1 w-full" placeholder="Enter some tags... i.e. sleepy, home workout, in the zone" maxlength="45" x-model="cardData.tags" />
                </div>
                <div class="my-4">
                    <label for="level">Experience Level<sup>*</sup></label>
                    <select name="level" x-model="cardData.level" class="block mt-1 w-full text-black">
                        <option value="0" disabled>Select an option...</option>
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
        <div :class="awaitingSubmitResponse ? 'animate-pulse' : ''" x-cloak x-show="stepsCompleted == 2 && !registeredSuccess" x-transition.opacity class="mt-3 p-3">
            <form method="post" id="f_register">
                @csrf
                <div :class="cardData.level == 1 ? 'shadow-green-300' : cardData.level == 2 ? 'shadow-orange-300' : cardData.level == 3 ? 'shadow-indigo-300' : 'shadow-red-300'" class="h-[400px] w-[300px] mx-auto mb-6 flex flex-col shadow-lg rounded">
                    <div class="w-[105px] h-[105px] relative mx-auto mt-5">
                        <img x-ref="imageEl" src="/img/gravatars/iv219dqg2ef71.jpg" class="w-full h-full rounded-full border-2 mx-auto cursor-pointer object-cover block max-w-full hover:scale-105" @click="$refs.avatarUpload.click()" />
                        <svg xmlns="http://www.w3.org/2000/svg" :class="showUploadIcon ? '' : 'hidden'" class="h-8 w-8 absolute top-10 right-9 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" @click="$refs.avatarUpload.click()" >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" :class="showUploadIcon ? 'hidden' : ''" class="h-6 w-6 absolute -right-2 top-0 cursor-pointer" viewBox="0 0 20 20" fill="currentColor" x-ref="destroyCropperIcon">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                          </svg>
                        <input name="avatar" x-ref="avatarUpload" type="file" accept="image/*" hidden @change="handleFileSelect" />
                    </div>
                    <div class="mt-7">
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
                <div class="flex justify-center gap-x-4" :class="awaitingSubmitResponse ? 'hidden' : ''">
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
        stepsCompleted: 0,
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
            level: 0
        },
        formEl: null,
        showUploadIcon: true,
        registeredSuccess: false,
        cropperObj: null,
        awaitingSubmitResponse: false,
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
        handleFileSelect(e) {
            this.showUploadIcon = false;
            const file = e.target.files[0];
            const imgElement = this.$refs.imageEl;
            imgElement.src =URL.createObjectURL(file)
            const crop = new Cropper(imgElement, {
                viewMode: 0,
                initialAspectRatio: 1,
                aspectRatio: 1/1,
                dragMode: 'move',
                guides: false,
                highlight: false,
                cropBoxMovable: false,
                minContainerWidth: 105,
                minCropBoxWidth: 105,
                minCropBoxHeight: 105,
                center: false,
            });
            ['cropend', 'zoom'].forEach((evt) => 
                imgElement.addEventListener(evt, () => this.cropperObj = crop.getCroppedCanvas({
                    width: 105,
                    height: 105
                }))
            )
            this.$refs.destroyCropperIcon.addEventListener('click', () => this.destroyCropperInstance(crop), {
                once: true
            })
        },
        destroyCropperInstance(cropperInstance) {
            this.$refs.imageEl.src = '/img/gravatars/iv219dqg2ef71.jpg'
            this.$refs.avatarUpload.value = null;
            this.showUploadIcon = true
            cropperInstance.destroy();
            this.cropperObj = null
        },
        createFormDataObj() {
            const formData = new FormData(this.formEl);
            const {email, password, confirmPassword, firstname, surname} = this.inputData;
            const {tagline, tags, level} = this.cardData;
            formData.append('email', email)
            formData.append('password', password)
            formData.append('password_confirmation', confirmPassword);
            formData.append('firstname', firstname);
            formData.append('surname', surname);
            formData.append('tagline', tagline);
            formData.append('tags', tags);
            formData.append('level', level);
            return formData;
        },
        async registerBtnPressed() {
            const formData = this.createFormDataObj();
            
            if (this.cropperObj) {
                const getAvatarBlob = async () => new Promise((res) => this.cropperObj.toBlob((blob) => res(blob)))
                const avatarBlob = await getAvatarBlob();
                formData.append('avatarBlob', avatarBlob);
            }

            this.awaitingSubmitResponse = true;

            try {
                const response = await fetch(registerFormURL, {
                    method: 'post',
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                const json = await response.json();
                if (response.status == 422) throw Error(json.message)
                this.registeredSuccess = true;
            } catch (err) {
                this.errorText = err.message.split('. ')[0]
                this.registeredSuccess = false;
            } finally {
                this.awaitingSubmitResponse = false;
            }
        },
    });
</script>
@endsection
