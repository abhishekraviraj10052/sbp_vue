import { defineStore } from 'pinia'
import axios from 'axios'
import router from '@/routes/index.js'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        isAuthenticated: false,
        appName: null,
        whmcs_service_id: null,
    }),

    actions: {
       
        async login(form) {
            await axios.get('/sanctum/csrf-cookie');
            const response = await axios.post('/admin/', form)
            if (!response.data.errors) {
                this.user = response.data.user;
                this.isAuthenticated = true;
            }
            return response;
        },

        async getUser() {
            try {
                const response = await axios.post('/admin/auth-check')
                if (!response.data.errors) {
                    this.user = response.data.user
                    this.isAuthenticated = true;
                } else {
                    this.user = null;
                    this.isAuthenticated = false;
                }
            } catch {
                this.user = null
                this.isAuthenticated = false
            }
        },

        async getServiceId() {
            try {
                const response = await axios.post('/admin/get-service-id')
                if(!response.data.errors) {
                    this.whmcs_service_id = response.data.whmcs_service_id
                }else{
                    this.whmcs_service_id = null
                }
            } catch {
                this.whmcs_service_id = null
            }
        },

        async getAppName() {
            try {
                const response = await axios.post('/admin/get-app-name')
                if(!response.data.errors) {
                    this.appName = response.data.app_name
                }else{
                    this.appName = null
                }
            } catch {
                this.appName = null
            }
        },

        async logout() {
            await axios.post('/admin/logout')
            this.user = null
            this.isAuthenticated = false
            this.whmcs_service_id = null
            this.appName = null
            router.push('/')
        },
    },
})