/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    'templates/**/*.html.twig',
    'assets/js/**/*.js',
    'assets/js/**/*.jsx', // Si vous utilisez des fichiers React JSX
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

