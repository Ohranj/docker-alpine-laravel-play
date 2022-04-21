document.addEventListener("alpine:init", () =>
    Alpine.store("userCard", {
        selectedUser: null,
        userSelf: null,
        async init() {
            try {
                const response = await fetch("/api/user/json");
                const json = await response.json();
                if (!json.success) throw Error(0);
                this.userSelf = json.user;
                console.log(this.userSelf);
            } catch (errCode) {}
        },
        followUserPressed(userObj) {
            this.selectedUser = userObj;
            console.log(this.selectedUser);
        },
    })
);
