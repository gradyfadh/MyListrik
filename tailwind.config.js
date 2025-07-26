/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
        fontFamily: {
        syne: ['Syne', 'sans-serif'],
        rubik: ['Rubik', 'sans-serif'],
        
      },
    },
  },
  plugins: [],
}

