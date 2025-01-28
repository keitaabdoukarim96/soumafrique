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
      animation: {
        fadeIn: "fadeIn 0.3s ease-in-out",
        fadeOut: "fadeOut 0.3s ease-in-out",
      },
      keyframes: {
        fadeIn: {
          from: { opacity: 0 },
          to: { opacity: 1 },
        },
      },
      fadeOut: {
        from: { opacity: 1 },
        to: { opacity: 0 },
      },
  },
},
  plugins: [],
}

