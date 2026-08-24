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
                    900: '#122A20', // sidebar dark prussian green
                    800: '#173626',
                    700: '#1F4732',
                    600: '#2B5C42',
                    500: '#3D7A5A',
                    cream: '#F6F1E4',
                    beige: '#EFE7D3',
                },
                success: { bg: '#E6F4EA', text: '#1E7B34' },
                warning: { bg: '#FEF3C7', text: '#92650A' },
                danger: { bg: '#FCE7E7', text: '#B42318' },
                info: { bg: '#E0EAFB', text: '#1D4ED8' },
            },
            fontFamily: {
                sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            boxShadow: {
                soft: '0 1px 3px 0 rgba(18, 42, 32, 0.08), 0 1px 2px -1px rgba(18, 42, 32, 0.06)',
                card: '0 4px 16px -4px rgba(18, 42, 32, 0.10)',
            },
            borderRadius: {
                xl2: '1rem',
            },
        },
    },
    plugins: [],
};
