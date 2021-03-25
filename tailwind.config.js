module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: [
        './resources/**/*.html',
        './resources/**/*.php',
        './resources/**/*.vue',
        './resources/**/*.js',
    ],
    theme: {
        fontFamily: {
            'sans': ['Nunito', 'sans-serif'],
            'landing': ['Poppins', 'sans-serif'],
        },
        extend: {
            colors: {
                orange: {
                    50: '#FFF7ED',
                    100: '#FFEDD5',
                    200: '#FED7AA',
                    300: '#FDBA74',
                    400: '#FB923C',
                    500: '#FF5E14', // overridden
                    600: '#EA580C',
                    700: '#C2410C',
                    800: '#9A3412',
                    900: '#7C2D12',
                },
            },
        },
    },
    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover', 'focus-within', 'disabled'],
    },
    plugins: [],
}
