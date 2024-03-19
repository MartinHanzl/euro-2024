/** @type {import('tailwindcss').Config} */
export default {
    content: ['./src/**/*.{html,js}'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat ', 'sans-serif']
            },
            colors: {
                'fullGray': '#192231',
                'darkBlue': '#000d40',
                'yellow': '#f9bf4b',
                'semiBlue': '#0e2a99',
                'lightBlue': '#143cdb'
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}

