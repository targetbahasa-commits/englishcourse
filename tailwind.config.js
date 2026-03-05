import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        // Gradient colors for vocabulary cards
        'from-blue-400', 'to-blue-600', 'bg-blue-500', 'bg-blue-50', 'text-blue-600', 'border-blue-100', 'text-blue-700', 'bg-blue-100',
        'from-purple-400', 'to-purple-600', 'bg-purple-500', 'bg-purple-50', 'text-purple-600', 'border-purple-100', 'text-purple-700', 'bg-purple-100',
        'from-pink-400', 'to-pink-600', 'bg-pink-500', 'bg-pink-50', 'text-pink-600', 'border-pink-100', 'text-pink-700', 'bg-pink-100',
        'from-indigo-400', 'to-indigo-600', 'bg-indigo-500', 'bg-indigo-50', 'text-indigo-600', 'border-indigo-100', 'text-indigo-700', 'bg-indigo-100',
        'from-cyan-400', 'to-cyan-600', 'bg-cyan-500', 'bg-cyan-50', 'text-cyan-600', 'border-cyan-100', 'text-cyan-700', 'bg-cyan-100',
        'from-green-400', 'to-green-600', 'bg-green-500', 'bg-green-50', 'text-green-600', 'border-green-100', 'text-green-700', 'bg-green-100',
        'from-yellow-400', 'to-yellow-600', 'bg-yellow-500', 'bg-yellow-50', 'text-yellow-600', 'border-yellow-100', 'text-yellow-700', 'bg-yellow-100',
        'from-red-400', 'to-red-600', 'bg-red-500', 'bg-red-50', 'text-red-600', 'border-red-100', 'text-red-700', 'bg-red-100',
        'from-orange-400', 'to-orange-600', 'bg-orange-500', 'bg-orange-50', 'text-orange-600', 'border-orange-100', 'text-orange-700', 'bg-orange-100',
        // Additional colors for new designs
        'from-emerald-400', 'to-emerald-600', 'bg-emerald-500', 'bg-emerald-50', 'text-emerald-600', 'border-emerald-100',
        'from-teal-400', 'to-teal-600', 'bg-teal-500', 'bg-teal-50', 'text-teal-600', 'border-teal-100',
        'from-amber-400', 'to-amber-600', 'bg-amber-500', 'bg-amber-50', 'text-amber-600', 'border-amber-100',
        'from-violet-400', 'to-violet-600', 'bg-violet-500', 'bg-violet-50', 'text-violet-600', 'border-violet-100',
        'from-fuchsia-400', 'to-fuchsia-600', 'bg-fuchsia-500', 'bg-fuchsia-50', 'text-fuchsia-600', 'border-fuchsia-100',
        'from-rose-400', 'to-rose-600', 'bg-rose-500', 'bg-rose-50', 'text-rose-600', 'border-rose-100',
        'from-lime-400', 'to-lime-600', 'bg-lime-500', 'bg-lime-50', 'text-lime-600', 'border-lime-100',
        // Score badge colors
        'text-green-500', 'text-blue-500', 'text-orange-500', 'text-gray-400', 'text-yellow-500',

        // Extended color palette for irregular verbs page
        // Indigo shades
        'from-indigo-500', 'from-indigo-600', 'from-indigo-700', 'to-indigo-600', 'to-indigo-700',
        'bg-indigo-100', 'bg-indigo-200', 'text-indigo-700', 'text-indigo-800', 'border-indigo-200', 'border-indigo-300',
        'from-indigo-50/95', 'from-indigo-100/90', 'from-indigo-200',

        // Violet shades
        'from-violet-500', 'from-violet-600', 'from-violet-700', 'to-violet-600', 'to-violet-700',
        'bg-violet-100', 'bg-violet-200', 'text-violet-600', 'text-violet-700', 'text-violet-800',
        'border-violet-100', 'border-violet-200', 'border-violet-300', 'border-violet-400',
        'from-violet-50/95', 'from-violet-100/90', 'from-violet-200', 'to-violet-200',
        'bg-violet-50/20', 'bg-violet-50/30', 'bg-violet-50/40', 'bg-violet-50/50', 'bg-violet-50/60', 'bg-violet-50/80',
        'bg-violet-100/60', 'bg-violet-100/70', 'bg-violet-100/80',
        'border-violet-100/50', 'border-violet-200/50', 'border-violet-200/60',

        // Purple shades
        'from-purple-50/95', 'to-purple-50/95', 'from-purple-100', 'to-purple-100',
        'from-purple-50/40', 'via-purple-50/40', 'bg-purple-100/70',

        // Rose shades
        'from-rose-50/30', 'from-rose-100/60', 'to-rose-100/60',
        'bg-rose-50/20', 'bg-rose-50/40', 'bg-rose-100/60', 'to-pink-50/20', 'to-pink-100/40',
        'text-rose-700', 'text-rose-800', 'text-rose-900', 'text-rose-950',
        'border-rose-100', 'border-rose-200', 'border-rose-100/50', 'border-rose-200/50',
        'from-rose-100/90', 'via-rose-50/50',

        // Blue shades
        'from-blue-50/30', 'from-blue-100/60', 'to-blue-100/60',
        'bg-blue-50/20', 'bg-blue-50/40', 'bg-blue-100/60', 'to-cyan-50/20', 'to-cyan-100/40',
        'text-blue-700', 'text-blue-800', 'text-blue-900', 'text-blue-950',
        'border-blue-100', 'border-blue-200', 'border-blue-100/50', 'border-blue-200/50',
        'from-blue-100/90', 'via-blue-50/50', 'via-blue-100/90',

        // Emerald/Green shades
        'from-emerald-50/30', 'from-emerald-100/60', 'to-emerald-100/60',
        'bg-emerald-50/20', 'bg-emerald-50/40', 'bg-emerald-100/60', 'to-teal-50/20', 'to-teal-100/40',
        'text-emerald-700', 'text-emerald-800', 'text-emerald-900', 'text-emerald-950',
        'border-emerald-100', 'border-emerald-200', 'border-emerald-100/50', 'border-emerald-200/50',
        'from-emerald-100/90', 'via-emerald-50/50', 'via-emerald-100/90',

        // Amber/Orange shades
        'from-amber-50/30', 'from-amber-50/80', 'from-amber-50/90', 'from-amber-100/60',
        'bg-amber-50/20', 'bg-amber-50/40', 'bg-amber-100/60', 'to-orange-50/20', 'to-orange-50/40', 'to-orange-50/60', 'to-orange-100/40',
        'text-amber-700', 'text-amber-800', 'text-amber-900', 'text-amber-950',
        'border-amber-100', 'border-amber-200', 'border-amber-300', 'border-amber-100/50', 'border-amber-200/50',
        'from-amber-100/90', 'via-amber-50/50', 'via-amber-100/90', 'to-amber-100/90',

        // Fuchsia shades
        'from-fuchsia-100', 'to-fuchsia-100', 'to-fuchsia-200', 'via-fuchsia-50/20',

        // Slate shades
        'from-slate-50', 'from-slate-50/80', 'to-slate-50/80',

        // Gray shades
        'text-gray-700', 'border-gray-100',

        // Shadow variants
        'shadow-xl', 'shadow-2xl', 'shadow-lg', 'shadow-md', 'shadow-sm',
        'shadow-violet-300', 'shadow-violet-400',

        // Border widths
        'border-2', 'border-r-2', 'border-b-2',

        // TOEFL Listening answer styles (Red)
        'has-[:checked]:border-red-500',
        'has-[:checked]:bg-red-50',
        'has-[:checked]:shadow-sm',
        'peer-checked:border-red-600',
        'peer-checked:bg-red-600',
        'peer-checked:text-white', // Keep this as the circle text is white
        'peer-checked:text-red-700',
        'group-hover/option:border-red-400', // Correct shade per blade file
        'group-hover/option:bg-red-50',
        'group-hover/option:text-red-700',
        'hover:border-red-300',
        'hover:bg-red-50',
        'group/option',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
