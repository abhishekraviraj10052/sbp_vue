import "./bootstrap";

import { createApp } from "vue";
import router from "./routes";
import App from "./App.vue";
import { createPinia } from "pinia";

createApp(App).use(router).use(createPinia()).mount("#app");
