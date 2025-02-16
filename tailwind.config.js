/** @type {import('tailwindcss').Config} */
export default {
    content: ["./**/*.php"], // Para detectar classes dentro dos arquivos PHP
    theme: {
      extend: {
        fontFamily:{
            Dmsans:["DM Sans","sans-serif"],
            Karla:["Karla","sans-serif"],
        },
      },
    },
    plugins: [],
  };
  