window.forgotPassword = ({ postForgotPasswordURL }) => ({
    showModal: false,
    bodyColors: ["bg-stone-800", "bg-fadedBody"],
    bodyEl: null,
    formEl: null,
    init() {
        this.bodyEl = document.querySelector("body");
        this.formEl = document.getElementById("f_forgotPassword");
        this.applyWatchers();
    },
    applyWatchers() {
        const { bodyColors, bodyEl } = this;
        this.$watch("showModal", () =>
            bodyColors.map((color) => bodyEl.classList.toggle(color))
        );
    },
    async submitForm() {
        const formData = new FormData(this.formEl);
        const response = await fetch(postForgotPasswordURL, {
            method: "post",
            body: formData,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
        console.log(response);
        const json = await response.json();
        console.log(json);
    },
});
