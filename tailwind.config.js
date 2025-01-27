/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./.php",
    "./**/*.php",
    "./assets/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Roboto', 'sans-serif'],
      },
      backgroundImage: {
        'custom-gradient': 'linear-gradient(to right, #ebb62c, #2d7000)',
      },
    },
  },
  plugins: [],
}