/** @type {import('tailwindcss').Config} */
export default {
    content: ['./src/**/*.{html,js}'],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Montserrat ', 'sans-serif']
            },
            colors: {
                'fullGray': '#192231'
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}

