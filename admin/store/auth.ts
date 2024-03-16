// store/auth.ts
// @ts-ignore
import { defineStore } from 'pinia';
import auth from "~/middleware/auth";

interface UserPayloadInterface {
    username: string;
    password: string;
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        loading: false,
        authUser: null
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

                this.authUser = await $fetch('http://localhost:8000/api/auth/me', {
                    method: 'post',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer' + data?.value?.access_token },
                });
            }
        },
        async refreshToken() {
            const { data, pending }: any = await useFetch('http://localhost:8000/api/auth/me', {
                method: 'post',
                headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer' + useCookie('token') }
            });

                const token = useCookie('token');
            if (data.value) {
                // @ts-ignore
                token.value = data?.value?.access_token;
                this.authUser = data?.value;
            }
        },
        logUserOut() {
            const token = useCookie('token'); // useCookie new hook in nuxt 3
            this.authenticated = false; // set authenticated  state value to false
            this.authUser = null;
            // @ts-ignore
            token.value = null; // clear the token cookie
        },
    },
});
