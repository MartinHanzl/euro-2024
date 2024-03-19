// store/auth.ts

import { defineStore } from 'pinia';

interface UserPayloadInterface {
    username: string;
    password: string;
}

export const useAuthStore = defineStore('auth', {
    state: () => ({
        authenticated: false,
        authUser: false,
        loading: false,
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
                const token = useCookie('token', {maxAge: 60*60*24*7}); // useCookie new hook in nuxt 3
                token.value = data?.value?.access_token; // set token to cookie
                this.authenticated = true; // set authenticated  state value to true

                const me = await $fetch('http://localhost:8000/api/auth/me', {
                    method: 'post',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + data?.value?.access_token },
                });

                const user = useCookie('user', {maxAge: 60*60*24*7});
                user.value = me;
                this.authUser = user.value;
            }
        },
        logUserOut() {
            const token = useCookie('token'); // useCookie new hook in nuxt 3
            this.authenticated = false; // set authenticated  state value to false
            this.authUser = false; // set authenticated  state value to false
            token.value = null; // clear the token cookie
        },
    },
})