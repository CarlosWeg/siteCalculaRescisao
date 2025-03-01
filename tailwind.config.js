/** @type {import('tailwindcss').Config} */
export default {
  content: ["./**/*.php"],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['DM Sans', 'system-ui', 'sans-serif'],
        'dm-sans': ['DM Sans', 'sans-serif'],
        'karla': ['Karla', 'sans-serif'],
      },
    },
  },
  plugins: [],
};