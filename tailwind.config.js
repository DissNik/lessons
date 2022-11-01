module.exports = {
    content: ["./resources/views/**/*.blade.php"],
    theme: {
        screen: {
            sm: "576px",
            md: "768px",
            lg: "992px",
            xl: "1200px",
        },
        container: {
            center: true,
            padding: "1rem",
        },
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                roboto: ["Roboto", "sans-serif"],
            },
            colors: {
                info: "#3B82F6",
                primary: "#fd3d57",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
