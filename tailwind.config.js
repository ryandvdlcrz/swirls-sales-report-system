/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./resources/js/**/*.vue",
    ],
    safelist: [
        "active:scale-95",
        "text-red-500",
        "text-red-300",
        "bg-red-200",
        "bg-white/60",
        "bg-black/50",
        "rounded-2xl",
        "shadow-2xl",
        "shadow",
        "shadow-sm",
    ],
    theme: {
        extend: {
            fontFamily: {
                PP: ['"Poppins"', "sans-serif"],
            },
            spacing: {
                21.25: "85px",
                27.5: "110px",
                44.5: "178px",
                44.75: "179px",
                8.75: "35px",
            },
            width: {
                21.25: "85px",
                27.5: "110px",
                44.5: "178px",
                44.75: "179px",
            },
            height: {
                21.25: "85px",
                44.75: "179px",
                8.75: "35px",
            },
        },
    },
    plugins: [],
};
