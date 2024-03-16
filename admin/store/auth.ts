// store/auth.ts
// @ts-ignore
import { defineStore } from 'pinia';
import {useRouter} from "#app";

interface UserPayloadInterface {
    username: string;
    password: string;
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        loading: false,
    }),
    actions: {
        async authenticateUser({ username, password }: UserPayloadInterface) {
            // useFetch from nuxt 3
            // @ts-ignore
            const { data, pending }: any = await useFetch('http://localhost:8000/api/auth/login', {
                method: 'post',
                headers: { 'Content-Type': 'application/json' },
                body: {
                    username,
                    password,
                },
            });
            this.loading = pending;

            if (data.value) {
                const token = useCookie('token'); // useCookie new hook in nuxt 3
                // @ts-ignore
                token.value = data?.value?.access_token; // set token to cookie
                this.authenticated = true; // set authenticated  state value to true
            }
        },
        async refreshToken() {
            const { data, pending }: any = await useFetch('http://localhost:8000/api/auth/me', {
                method: 'post',
                headers: { 'Content-Type': 'application/json', 'Authorization': useCookie('token') }
            });

                const token = useCookie('token');
            if (data.value) {
                // @ts-ignore
                token.value = data?.value?.access_token;
            }
        },
        logUserOut() {
            const token = useCookie('token'); // useCookie new hook in nuxt 3
            this.authenticated = false; // set authenticated  state value to false
            // @ts-ignore
            token.value = null; // clear the token cookie
        },
    },
});
