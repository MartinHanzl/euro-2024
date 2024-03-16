// store/auth.ts
// @ts-ignore
import { defineStore } from 'pinia';

interface UserPayloadInterface {
    username: string;
    password: string;
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        loading: false
    }),
    actions: {
        async authenticateUser({ username, password }: UserPayloadInterface) {
            // useFetch from nuxt 3
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
                const token = useCookie('token', {maxAge: 60*60*20*7}); // useCookie new hook in nuxt 3
                // @ts-ignore
                token.value = data?.value?.access_token; // set token to cookie
                this.authenticated = true; // set authenticated  state value to true

                const me = await $fetch('http://localhost:8000/api/auth/me', {
                    method: 'post',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer' + data?.value?.access_token },
                });

                const authUser = useCookie('authUser', {maxAge: 60*60*24*14});
                // @ts-ignore
                authUser.value = me?.value;
            }
        },
        logUserOut() {
            const token = useCookie('token'); // useCookie new hook in nuxt 3
            const authUser = useCookie('authUser'); // useCookie new hook in nuxt 3

            this.authenticated = false; // set authenticated  state value to false
            // @ts-ignore
            authUser.value = null; // clear the token cookie
            // @ts-ignore
            token.value = null; // clear the token cookie
        },
    },
});
