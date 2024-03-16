import {useAuthStore} from "~/store/auth";

export default defineNuxtRouteMiddleware((to) => {
    const {authenticated, authUser} = storeToRefs(useAuthStore()); // make authenticated state reactive
    const token = useCookie('token'); // get token from cookies
    const user = useCookie('user'); // get token from cookies

    if (token.value) {
        // check if value exists
        authenticated.value = true; // update the state to authenticated
    }

    if (user.value) {
        authUser.value = user;
    }

    // if token exists and url is /login redirect to homepage
    if (token.value && user.value && to?.name === 'login') {
        return navigateTo('/');
    }

    // if token doesn't exist redirect to log in
    if (!token.value && !user.value && to?.name !== 'login') {
        abortNavigation();
        return navigateTo('/login');
    }
});
