document.addEventListener("alpine:init", () =>
    Alpine.store("userCard", {
        user: null,
        followUserPressed(userObj) {
            this.user = userObj;
            console.log(this.user);
        },
    })
);
