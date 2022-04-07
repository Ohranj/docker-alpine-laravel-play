window.contactUsForm = () => ({
    showModal: false,
    bodyColours: ["bg-stone-800", "bg-fadedBody"],
    init() {
        const bodyEl = document.querySelector("body");
        this.$watch("showModal", () =>
            this.bodyColours.map((color) => bodyEl.classList.toggle(color))
        );
    },
});
