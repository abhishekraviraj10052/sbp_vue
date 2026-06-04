import "./bootstrap";

import { createApp } from "vue";
import router from "./routes";
import axios from "axios";
import App from "./App.vue";
import { createPinia } from "pinia";

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        console.log(error.response?.status);
        console.log(error.response?.data.auth_failed);
        if (error.response && error.response?.data?.auth_failed) {
            console.log('session out')
            // router.push({ name: "login" });
            window.location.href = '/';
        }
        if (error.response && error.response?.data?.refresh_permissions) {
            router.push({ name: "app-list" });
        }

        return Promise.reject(error);
    },
);

createApp(App).use(router).use(createPinia()).mount("#app");
