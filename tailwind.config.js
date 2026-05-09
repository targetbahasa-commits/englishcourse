import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],
  safelist: [
    { pattern: /^group\/batch$/ },
    { pattern: /^group-hover\/batch:opacity-\d+$/ },
    { pattern: /^transition-opacity$/ },
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
};
