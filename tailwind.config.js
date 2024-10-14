import defaultTheme from "tailwindcss/defaultTheme";
import containerQueries from "@tailwindcss/container-queries";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Roboto", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#0D1321",
                secondary: "#1D2D44",
                accent: "#F0EBD8",
            },
        },
    },

    plugins: [containerQueries, forms],
};
