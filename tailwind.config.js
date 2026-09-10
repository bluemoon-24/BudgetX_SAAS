import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#f0f5ff',
                    100: '#e5edff',
                    200: '#cddbfe',
                    300: '#b4c6fc',
                    400: '#8da2fb',
                    500: '#6366f1', // Indigo main
                    600: '#4f46e5',
                    700: '#4338ca',
                    800: '#3730a3',
                    900: '#312e81',
                },
                secondary: {
                    50: '#fdf8f6',
                    100: '#f2e8e5',
                    200: '#eaddd7',
                    300: '#e0cec7',
                    400: '#d2bab0',
                    500: '#a779e9', // Purple accent
                    600: '#9333ea',
                    700: '#7e22ce',
                },
                brand: {
                    50: '#f0f7ff',
                    100: '#e0effe',
                    200: '#bae0fd',
                    300: '#7cc7fb',
                    400: '#38a9f8',
                    500: '#0e8ce1',
                    600: '#026ebe',
                    700: '#03589b',
                    800: '#074b80',
                    900: '#0c406b',
                    950: '#082848',
                },
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                'glow': '0 0 20px rgba(99, 102, 241, 0.3)',
                'premium': '0 8px 30px rgba(0, 0, 0, 0.04)',
                'premium-hover': '0 20px 40px rgba(0, 0, 0, 0.08)',
            },
            borderRadius: {
                'bento': '2.5rem',
            },
            animation: {
                'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                'float': 'float 3s ease-in-out infinite',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
            },
        },
    },

    plugins: [forms, typography],
};