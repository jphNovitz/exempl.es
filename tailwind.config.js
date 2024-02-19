const plugin = require('tailwindcss/plugin')
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            'clear': '#C7F9CC',
            'clearDarken': '#FFC300',
            'dark': '#22577A',
            'primary': '#57CC99',
            'secondary': '#38A3A5',
            'black': '#091920',
        },
        extend: {},
    },
    plugins: [
        plugin(function ({addBase, theme}) {
            addBase({
                'h1': {
                    fontSize: theme('fontSize.3xl'),
                },
                'h2': {
                    fontSize: theme('fontSize.2xl'),
                },
                'h3': {
                    fontSize: theme('fontSize.xl'),
                },
                'h4': {
                    fontSize: theme('fontSize.lg'),
                },
                'p': {
                    fontSize: '16px'
                },
                'h5': {
                    fontSize: theme('fontSize.sm'),
                },
                'h6': {
                    fontSize: theme('fontSize.xs'),
                },
            })
        })],
}
