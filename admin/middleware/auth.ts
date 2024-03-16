import {useAuthStore} from "~/store/auth";

export default defineNuxtRouteMiddleware((to) => {
    const {authenticated} = storeToRefs(useAuthStore()); // make authenticated state reactive
    const token = useCookie('token'); // get token from cookies
    const authUser = useCookie('authUser'); // get token from cookies

    // @ts-ignore
    if (token.value) {
        authenticated.value = true;
    }

    // @ts-ignore
    if (authUser.value) {
        authenticated.value = true;
    }

    // @ts-ignore
    if (token.value && authUser.value && to?.name === 'login') {
        return navigateTo('/');
    }

    // @ts-ignore
    if (!token.value && authUser.value && to?.name !== 'login') {
        abortNavigation();
        return navigateTo('/login');
    }
});
