const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./public/js/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                Poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "accent-blue": "#2563eb",
                fadedBody: "rgba(0, 0, 0, 0.65)",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
