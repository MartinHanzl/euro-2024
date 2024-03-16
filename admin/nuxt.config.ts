// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    ssr: false,
    app: {
        head: {
            charset: 'utf-8',
            viewport: 'width=device-width, initial-scale=1',
            title: 'Euro 2024'
        }
    },
    devtools: {enabled: true},
    components: [
        {
            path: '@/components',
            pathPrefix: false
        }
    ],
    modules: [
        '@nuxtjs/tailwindcss',
        '@nuxtjs/i18n',
        '@pinia/nuxt',
        '@nuxtjs/eslint-module'
    ],
    i18n: {
        defaultLocale: 'cs',
        locales: [
            {
                code: 'cs',
                name: 'Čeština',
                file: './lang/cs.json',
            },
            {
                code: 'en',
                name: 'English',
                file: './lang/en.json',
            }
        ]
    },
    eslint: {
        cache: false
    }
})
