window.contactUsForm = ({ postContactUsFormURL }) => ({
    showModal: false,
    bodyColours: ["bg-stone-800", "bg-fadedBody"],
    init() {
        const bodyEl = document.querySelector("body");
        this.$watch("showModal", () =>
            this.bodyColours.map((color) => bodyEl.classList.toggle(color))
        );
    },
    async submitForm() {
        const form = document.getElementById("f_contactUsForm");
        const formData = new FormData(form);
        try {
            const response = await fetch(postContactUsFormURL, {
                method: "post",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });
            if (response.status == 422) throw Error;
            const json = await response.json();
            console.log(json);
            //Close the modal and show an icon with success
        } catch (err) {
            console.log("Please check the necessaru fields and try again");
        }
    },
});
