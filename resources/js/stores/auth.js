import { defineStore } from "pinia";
import axios from "axios";
import router from "@/routes/index.js";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        userDetail: null,
        appDetail: null,
        authLoaded: false,
    }),

    actions: {
        async login(form) {
            await axios.get("/sanctum/csrf-cookie");
            const response = await axios.post("/admin/", form);
            if (!response.data.errors) {
                this.userDetail = response.data.user;
            }
            return response;
        },

        async getUserDetail() {
            try {
                const response = await axios.post("/admin/get-user-detail");
                if (!response.data.errors) {
                    this.userDetail = response.data.user;
                } else {
                    this.userDetail = null;
                }
            } catch {
                this.userDetail = null;
            } finally {
                this.authLoaded = true;
            }
        },

        async getAppDetail(id = null) {
            try {
                const response = await axios.post("/admin/get-app-detail", {
                    id,
                });
                if (!response.data.errors) {
                    this.appDetail = response.data.app_detail;
                } else {
                    this.appDetail = null;
                }
            } catch {
                this.appDetail = null;
            }
        },

        async logout() {
            await axios.post("/admin/logout");
            this.userDetail = null;
            this.appDetail = null;
            router.push("/");
        },
    },
});
