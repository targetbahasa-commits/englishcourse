import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
  ],
  safelist: [
    // Existing
    { pattern: /^group\/batch$/ },
    { pattern: /^group-hover\/batch:opacity-\d+$/ },
    'transition-opacity',

    // Gradient from/to for accent lines
    {
      pattern: /^(from|to)-(emerald|violet|rose|amber|blue|slate)-(400|500)$/,
    },
    // bg-gradient-to-r
    'bg-gradient-to-r',

    // Soft badge / icon backgrounds, texts, borders
    {
      pattern: /^(bg|text|border|ring)-(emerald|violet|rose|amber|blue|slate)-(50|100|200|700|800)(\/60)?$/,
      variants: ['hover', 'group-hover', 'focus'],
    },

    // Button backgrounds
    {
      pattern: /^bg-(emerald|violet|rose|amber|blue|slate)-(500|600)$/,
      variants: ['hover'],
    },

    // Shadows (standard)
    {
      pattern: /^shadow-(sm|md|lg|xl|2xl|none)$/,
      variants: ['hover', 'group-hover'],
    },

    // Translate for hover lift
    'hover:-translate-y-0.5',
    'hover:-translate-y-1',
    'hover:-translate-y-1.5',
    '-translate-y-1',
    '-translate-y-1.5',

    // group-hover/item color fills
    {
      pattern: /^group-hover\/item:(bg|text|border|scale)-(white|slate|emerald|amber|blue|violet|rose|gray)-(50|100|200|700|800|900|110)?$/,
    },
    'group-hover/item:scale-110',
    'group-hover/item:translate-x-0.5',
    'group-hover/item:bg-slate-900',
    'group-hover/item:text-white',
    'group-hover/item:shadow-sm',
    'group-hover/item:bg-white',
    'group-hover/item:text-slate-900',
    'group-hover/item:border-transparent',
    'group-hover/item:translate-x-0.5',

    // Rotate for track icon
    'group-hover:-rotate-3',
    'group-hover:scale-105',
    'group-hover:opacity-100',
    'group-hover:translate-x-1',
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
};
