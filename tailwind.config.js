module.exports = {
  content: ["./app/views/**/*.php", "./public/js/**/*.js"],
  darkMode: "class",
  theme: {
    extend: {
      safelist: ['filter-active'],
      fontFamily: {
        inter: ["Inter", "sans-serif"],
      },
    },
  },
  plugins: [],
};
