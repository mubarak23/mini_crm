import bearer from "@websanova/vue-auth/drivers/auth/bearer";
import axios from "@websanova/vue-auth/drivers/http/axios.1.x";
import router from "@websanova/vue-auth/drivers/router/vue-router.2.x";
// Auth base configuration some of this options
// can be override in method calls
const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: "mini crm",
    tokenStore: ["localStorage"],
    rolesVar: "role",
    registerData: {
        url: "authservice/register",
        method: "POST",
        redirect: "/login"
    },
    loginData: {
        url: "authservice/login",
        method: "POST",
        redirect: "",
        fetchUser: true
    },
    logoutData: {
        url: "authservice/logout",
        method: "POST",
        redirect: "/",
        makeRequest: true
    },
    fetchData: { url: "auth/user", method: "GET", enabled: true },
    refreshData: {
        url: "authservice/refresh",
        method: "GET",
        enabled: true,
        interval: 30
    }
};
export default config;
