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
            'white': '#EDF2F4',
            'clear': '#B7C5DE',
            // 'clear': '#9ca8c0',
            'dark': '#2B2D42',
            'primary': '#0066FF',
            'black': '#0E0F17',
        },
        extend: {},
    },
    plugins: [
        plugin(function ({addBase, theme}) {
            addBase({
                'h1': {
                    fontSize: theme('fontSize.3xl'),
                    fontWeight: theme('fontWeight.black')
                },
                'h2': {
                    fontSize: theme('fontSize.2xl'),
                    fontWeight: theme('fontWeight.bold')
                },
                'h3': {
                    fontSize: theme('fontSize.xl'),
                    fontWeight: theme('fontWeight.medium')
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
                'a': {
                    color: theme('colors.primary'),
                    fontWeight: theme('fontWeight.bold'),
                    textDecoration: theme('textDecoration.underline'),
                },
                '.dark': {
                    'a': {
                        color: theme('colors.dark'),
                        fontWeight: theme('fontWeight.bold'),
                        textDecoration: theme('textDecoration.underline'),
                    },
                },
                '@media (prefers-color-scheme: dark)': {
                    'a':{
                        color: theme('colors.dark'),
                        fontWeight: theme('fontWeight.bold'),
                        textDecoration: theme('textDecoration.underline'),
                    }
                },
            })
        })],
}
