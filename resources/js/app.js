require("./bootstrap");

import Cropper from "cropperjs";
import Alpine from "alpinejs";
import Splide from "@splidejs/splide";

import collapse from "@alpinejs/collapse";

Alpine.plugin(collapse);

window.Cropper = Cropper;
window.Alpine = Alpine;
window.Splide = Splide;

Alpine.start();
