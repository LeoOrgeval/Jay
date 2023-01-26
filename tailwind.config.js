/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
    colors: {
      white: '#FFFFFF',
      blue: '#28293E',
      calendly: '#006BFF',
      cream: '#FDF0E9',
      orange: '#EF6D58',
      dark_brown: '#391400',
      light_brown: 'rgba(57,20,0,0.64)',
      shadow: 'rgba(0,0,0, .4)',
    }
  },
  plugins: [],
}
