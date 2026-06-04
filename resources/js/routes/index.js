import { createWebHistory, createRouter } from "vue-router";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";

import Login from "../pages/Login.vue";

import AppList from "../pages/AppList.vue";
import AppManage from "../pages/AppManage.vue";
import AppDetail from "../pages/AppDetail.vue";

import DnsList from "../pages/DnsList.vue";
import DnsManage from "../pages/DnsManage.vue";

import AnnouncementList from "../pages/AnnouncementList.vue";
import AnnouncementManage from "../pages/AnnouncementManage.vue";

import RewardedAdsList from "../pages/RewardedAdsList.vue";
import RewardedAdsManage from "../pages/RewardedAdsManage.vue";
import RewardedAdsConfig from "../pages/RewardedAdsConfig.vue";

import DashboardAdsList from "../pages/DashboardAdsList.vue";
import DashboardAdsManage from "../pages/DashboardAdsManage.vue";
import DashboardAdsConfig from "../pages/DashboardAdsConfig.vue";

import VpnList from "../pages/VpnList.vue";
import VpnManage from "../pages/VpnManage.vue";

import MaintainenceMode from "../pages/MaintainenceMode.vue";
import AppStoragePreference from "../pages/AppStoragePreference.vue";
import AppUpgrade from "../pages/AppUpgrade.vue";

import TwoFaSetting from "../pages/TwoFaSetting.vue";
import TwoFaLogin from "../pages/TwoFaLogin.vue";
import UserAccessList from "../pages/UserAccessList.vue";

import UserAccessManage from "../pages/UserAccessManage.vue";

import UserAccessVerification from "../pages/UserAccessVerification.vue";

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: "/app-list",
        name: "app-list",
        component: AppList,
        meta: { requiresAuth: true },
    },
    {
        path: "/app-manage/:id?",
        name: "app-manage",
        component: AppManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/app-detail",
        name: "app-detail",
        component: AppDetail,
        meta: { requiresAuth: true },
    },
    {
        path: "/dns-list",
        name: "dns-list",
        component: DnsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/dns-manage/:id?",
        name: "dns-manage",
        component: DnsManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/announcement-list",
        name: "announcement-list",
        component: AnnouncementList,
        meta: { requiresAuth: true },
    },
    {
        path: "/announcement-manage/:id?",
        name: "announcement-manage",
        component: AnnouncementManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/rewarded-ads-list",
        name: "rewarded-ads-list",
        component: RewardedAdsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/rewarded-ads-manage/:id?",
        name: "rewarded-ads-manage",
        component: RewardedAdsManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/rewarded-ads-configure",
        name: "rewarded-ads-configure",
        component: RewardedAdsConfig,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard-ads-list",
        name: "dashboard-ads-list",
        component: DashboardAdsList,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard-ads-manage/:id?",
        name: "dashboard-ads-manage",
        component: DashboardAdsManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/dashboard-ads-configure",
        name: "dashboard-ads-configure",
        component: DashboardAdsConfig,
        meta: { requiresAuth: true },
    },
    {
        path: "/vpn-list",
        name: "vpn-list",
        component: VpnList,
        meta: { requiresAuth: true },
    },
    {
        path: "/vpn-manage/:id?",
        name: "vpn-manage",
        component: VpnManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/maintainence-mode",
        name: "maintainence-mode",
        component: MaintainenceMode,
        meta: { requiresAuth: true },
    },
    {
        path: "/app-storage-preference",
        name: "app-storage-preference",
        component: AppStoragePreference,
        meta: { requiresAuth: true },
    },
    {
        path: "/app-upgrade",
        name: "app-upgrade",
        component: AppUpgrade,
        meta: { requiresAuth: true },
    },
    {
        path: "/2fa-manage",
        name: "2fa-manage",
        component: TwoFaSetting,
        meta: { requiresAuth: true },
    },
    {
        path: "/2fa-login",
        name: "2fa-login",
        component: TwoFaLogin,
        meta: { requiresAuth: true },
    },
    {
        path: "/user-access-list",
        name: "user-access-list",
        component: UserAccessList,
        meta: { requiresAuth: true },
    },
    {
        path: "/user-access-manage/:id?",
        name: "user-access-manage",
        component: UserAccessManage,
        meta: { requiresAuth: true },
    },
    {
        path: "/user-access-verify/:token",
        name: "user-access-verify",
        component: UserAccessVerification,
        meta: { requiresAuth: false },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();

    // if (auth.userDetail === null) {
    //     try {
    //         await auth.getUserDetail();
    //     } catch (error) {
    //         auth.userDetail = null;
    //     }
    //     console.log(auth.userDetail);
    // }
    if (auth.userDetail === null && (to.meta.requiresAuth || to.path === "/")) {
        try {
            await auth.getUserDetail();
        } catch (error) {
            auth.userDetail = null;
        }
    }

   
    if (to.path !== "/" && auth.appDetail === null) {
        try {
            await auth.getAppDetail();
        } catch (error) {
            auth.appDetail = null;
        }
    }

    if (to.meta.requiresAuth) {
        if (auth.userDetail === null) {
            return next("/");
        }
        if (
            auth.userDetail?.is_2fa_enabled &&
            !auth.userDetail?.is_2fa_verified &&
            to.path !== "/2fa-login"
        ) {
            return next("/2fa-login");
        }
        if (
            (auth.userDetail?.is_2fa_enabled &&
                auth.userDetail?.is_2fa_verified &&
                to.path === "/2fa-login") ||
            (!auth.userDetail?.is_2fa_enabled &&
                !auth.userDetail?.is_2fa_verified &&
                to.path === "/2fa-login")
        ) {
            return next("/app-list");
        }
    } else {
        if (auth.userDetail !== null && ["/", "/register"].includes(to.path)) {
            return next("/app-list");
        }
    }

    next();
});

export default router;
