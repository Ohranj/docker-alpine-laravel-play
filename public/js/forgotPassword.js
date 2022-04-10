window.forgotPassword = ({ postForgotPasswordURL }) => ({
    showModal: false,
    bodyColors: ["bg-stone-800", "bg-fadedBody"],
    bodyEl: null,
    formEl: null,
    showFormError: false,
    errorTextsArray: [
        "We are unable to process your request. Please ensure a valid email is provided",
        "You have exceeded the number of submissions allowed. Please wait 1 minute before trying again.",
    ],
    errorText: null,
    submitSuccess: false,
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
        this.$watch("showModal", (val) => {
            if (val) return;
            this.submitSuccess = false;
            this.formEl.reset();
            this.showFormError = false;
        });
    },
    async submitForm() {
        const formData = new FormData(this.formEl);
        try {
            const response = await fetch(postForgotPasswordURL, {
                method: "post",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            if (response.status == 422) throw 422;
            if (response.status == 429) throw 429;
            const json = await response.json();
            if (!json.success) throw null;
            this.showFormError = false;
            this.submitSuccess = true;
        } catch (errCode) {
            switch (errCode) {
                case 422:
                default:
                    this.errorText = this.errorTextsArray[0];
                    break;
                case 429:
                    this.errorText = this.errorTextsArray[1];
                    break;
            }
            this.showFormError = true;
            this.submitSuccess = false;
        }
    },
});
