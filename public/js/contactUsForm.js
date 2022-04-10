window.contactUsForm = ({ postContactUsFormURL }) => ({
    showModal: false,
    bodyColours: ["bg-stone-800", "bg-fadedBody"],
    submitSuccess: false,
    showError: false,
    errorTextArray: [
        "An error has occured with your submission. Please note the required fields (*) and try again.",
        "You have exceeded the number of submissions allowed. Please wait 1 minute before trying again.",
    ],
    errorText: "",
    formEl: null,
    bodyEl: null,
    init() {
        this.formEl = document.getElementById("f_contactUsForm");
        this.bodyEl = document.querySelector("body");
        this.applyWatchers();
    },
    applyWatchers() {
        this.$watch("showModal", () =>
            this.bodyColours.map((color) => this.bodyEl.classList.toggle(color))
        );
        this.$watch("showModal", (val) => {
            if (val) return;
            this.submitSuccess = false;
            this.formEl.reset();
            this.showError = false;
        });
    },
    async submitForm() {
        const formData = new FormData(this.formEl);
        try {
            const response = await fetch(postContactUsFormURL, {
                method: "post",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            if (response.status == 422) throw 422;
            if (response.status == 429) throw 429;
            this.submitSuccess = true;
            this.showError = false;
        } catch (errCode) {
            if (errCode == 422) {
                this.errorText = this.errorTextArray[0];
            } else {
                this.errorText = this.errorTextArray[1];
            }
            this.showError = true;
        }
    },
});
