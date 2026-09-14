/** @type {import('tailwindcss').Config} */

export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],

    theme: {
        extend: {

            colors: {
                bulog: {
                    900: '#0D2B6B',
                    800: '#123B7A',
                    700: '#174A91',
                    600: '#245EAD',
                    500: '#3D73C5',
                    cream: '#E8F0FF',
                    beige: '#D5E3F7',
                },

                success: {
                    bg: '#E6F4EA',
                    text: '#1E7B34',
                },

                warning: {
                    bg: '#FEF3C7',
                    text: '#92650A',
                },

                danger: {
                    bg: '#FCE7E7',
                    text: '#B42318',
                },

                info: {
                    bg: '#E0EAFB',
                    text: '#1D4ED8',
                },
            },

            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },

            boxShadow: {
                soft: '0 1px 3px 0 rgba(13, 43, 107, 0.08), 0 1px 2px -1px rgba(13, 43, 107, 0.06)',
                card: '0 4px 16px -4px rgba(13, 43, 107, 0.10)',
            },

            borderRadius: {
                xl2: '1rem',
            },
        },
    },

    plugins: [],
};