<template>
    <!-- main-header -->
    <Header
        v-if="
            !['login', '2fa-login'].includes($route.name) &&
            auth.userDetail !== null &&
            (!auth.userDetail?.is_2fa_enabled || auth.userDetail?.is_2fa_verified)
        "
    ></Header>
    <!-- /main-header -->

    <!-- main-sidebar -->
    <SideBar
        v-if="
            !['login', '2fa-login'].includes($route.name) &&
            auth.userDetail !== null &&
            (!auth.userDetail?.is_2fa_enabled || auth.userDetail?.is_2fa_verified)
        "
    ></SideBar>
    <!-- main-sidebar -->

    <!-- main-content -->
    <div
        :class="{
            'main-content':
                !['login', '2fa-login'].includes($route.name) &&
                auth.userDetail !== null &&
                (!auth.userDetail?.is_2fa_enabled ||
                    auth.userDetail?.is_2fa_verified),

            'app-content':
                !['login', '2fa-login'].includes($route.name) &&
                auth.userDetail !== null &&
                (!auth.userDetail?.is_2fa_enabled ||
                    auth.userDetail?.is_2fa_verified),
        }"
    >
        <!-- container -->
        <div
            :class="{
                'main-container':
                    !['login', '2fa-login'].includes($route.name) &&
                    auth.userDetail !== null &&
                    (!auth.userDetail?.is_2fa_enabled ||
                        auth.userDetail?.is_2fa_verified),
                'container-fluid':
                    !['login', '2fa-login'].includes($route.name) &&
                    auth.userDetail !== null &&
                    (!auth.userDetail?.is_2fa_enabled ||
                        auth.userDetail?.is_2fa_verified),
            }"
        >
            <router-view></router-view>
        </div>
        <!-- /Container -->
    </div>
    <!-- /main-content -->

    <!-- Sidebar-right-->
    <SideBarRight
        v-if="
            !['login', '2fa-login'].includes($route.name) &&
            auth.userDetail !== null &&
            (!auth.userDetail?.is_2fa_enabled || auth.userDetail?.is_2fa_verified)
        "
    ></SideBarRight>
    <!--/Sidebar-right-->

    <!-- Message Modal -->
    <MessageModel
        v-if="
            !['login', '2fa-login'].includes($route.name) &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail?.is_2fa_enabled || auth.userDetail?.is_2fa_verified)
        "
    ></MessageModel>
    <!-- /Message Modal -->
    <!-- Footer opened -->
    <Footer
        v-if="
            !['login', '2fa-login'].includes($route.name) &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail?.is_2fa_enabled || auth.userDetail?.is_2fa_verified)
        "
    ></Footer>
    <!-- Footer closed -->
</template>

<script>
import Header from "./components/partials/Header.vue";
import MessageModel from "./components/partials/MessageModel.vue";
import SideBar from "./components/partials/SideBar.vue";
import SideBarRight from "./components/partials/SideBarRight.vue";
import Footer from "./components/partials/Footer.vue";
import { useAuthStore } from "@/stores/auth";

export default {
    name: "App",
    components: {
        Header,
        MessageModel,
        SideBar,
        SideBarRight,
        Footer,
    },
    data() {
        return {
            auth: useAuthStore(),
        };
    },
    watch: {
        $route(to) {
            if (to.name === "login" || to.name === "2fa-login") {
                document.body.classList.add("bg-primary");
            } else {
                document.body.classList.remove("bg-primary");
            }
        },
    },
};
</script>
