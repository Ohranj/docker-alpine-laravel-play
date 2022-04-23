//prettier-ignore
document.addEventListener("alpine:init", () =>
    Alpine.store("userCard", {
        selectedUser: null,
        userSelf: null,
        csrfToken: null,
        showSuccessToast: false,
        showErrorToast: false,
        toastMessage: '',
        followIconClasses: ['text-red-500'],
        showMessageModal: false,
        messageUser: {},
        messageMemberFormEl: null,
        memberMessagedSuccess: false,
        showMemberMessageFormError: false,
        memberMessageFormErrorsArray: [
            'Please make sure to provide both a subject and message.', 
            'We are unable to verify your request, please confirm that the intended recipient exists.',
            'Too many requests. Please wait 1 minute before trying again.'
        ],
        errorText: '',
        async init() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            this.messageMemberFormEl = document.getElementById('f_messageMemberForm');
            try {
                const response = await fetch("/api/user/json");
                const json = await response.json();
                if (!json.success) throw Error(0);
                this.userSelf = json.user;
            } catch (errCode) {
                console.log(errCode);
            }
        },
        async followUserPressed(elem, userObj) {
            const isFollowing = this.userSelf.followings.findIndex((x) => x.id == userObj.id);
            if (isFollowing < 0) {
                await fetch('/api/user/follow', {
                    method: 'post',
                    body: JSON.stringify(userObj),
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": this.csrfToken,
                    }
                })
                elem.classList.toggle(...this.followIconClasses);
                this.userSelf.followings.push(userObj);
                this.toastMessage = "User followed";
                this.showSuccessToast = true;
                return;
            } 
            const response = await fetch("/api/user/unfollow", {
                method: "post",
                body: JSON.stringify(userObj),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrfToken,
                },
            });
            const jsonReponse = await response.json();
            if (!jsonReponse.success) {
                this.toastMessage = "Error. Please try again";
                this.showErrorToast = true;
                return;
            }
            elem.classList.toggle(...this.followIconClasses);
            this.userSelf.followings.splice(isFollowing, 1);
            this.toastMessage = "User unfollowed";
            this.showSuccessToast = true;
        },
        async submitMessageForm() {
            const form = Alpine.store('userCard').messageMemberFormEl;
            const formData = new FormData(form);
            try {
                const response = await fetch('api/user/message', {
                    method: 'post',
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    }
                })
                if (response.status == 422) throw Error(0)
                if (response.status == 420) throw Error()
                const json = await response.json();
                if (!json.success) throw new Error(1)
                Alpine.store('userCard').memberMessagedSuccess = true
            } catch (errCode) {
                const store = Alpine.store('userCard')
                switch (errCode.message) {
                    case '0':
                        store.errorText = store.memberMessageFormErrorsArray[0];
                        break;
                    case '1':
                        store.errorText = store.memberMessageFormErrorsArray[1];
                        break;
                    default:
                        store.errorText = store.memberMessageFormErrorsArray[2];
                        break;
                }
                store.showMemberMessageFormError = true;
            }
        },
        closeMessageFormModal() {
            const store = Alpine.store('userCard')
            store.showMessageModal = false;
            store.messageUser = {};
            store.memberMessagedSuccess = false
        }
    })
);
