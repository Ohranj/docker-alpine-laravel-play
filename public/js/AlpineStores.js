//prettier-ignore
document.addEventListener("alpine:init", () =>
    Alpine.store("userCard", {
        selectedUser: null,
        userSelf: null,
        csrfToken: null,
        showSuccessToast: false,
        showErrorToast: false,
        toastMessage: '',
        async init() {
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
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
            elem.classList.toggle("text-red-500");
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
                this.userSelf.followings.push(userObj);
                this.toastMessage = "User followed";
                this.showSuccessToast = true;
                return;
            } else {
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
                this.userSelf.followings.splice(isFollowing, 1);
                this.toastMessage = "User unfollowed";
                this.showSuccessToast = true;
            }
        },
    })
);
