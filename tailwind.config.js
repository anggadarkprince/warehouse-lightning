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
        'body': ['Nunito'],
        'display': ['Nunito'],
        'sans': ['Nunito', 'sans-serif'],
    },
    extend: {},
  },
  variants: {
      opacity: ['responsive', 'hover', 'focus', 'disabled'],
      textColor: ['responsive', 'hover', 'focus', 'group-hover', 'focus-within', 'disabled'],
  },
  plugins: [],
}
