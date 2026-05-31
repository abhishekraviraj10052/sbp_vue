<template>
    <!-- main-header -->
    <Header
        v-if="
            $route.name != 'login' &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail.is_2fa_enabled || auth.userDetail.is_2fa_verified)
        "
    ></Header>
    <!-- /main-header -->

    <!-- main-sidebar -->
    <SideBar
        v-if="
            $route.name != 'login' &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail.is_2fa_enabled || auth.userDetail.is_2fa_verified)
        "
    ></SideBar>
    <!-- main-sidebar -->

    <!-- main-content -->
    <div
        :class="{
            'main-content':
                $route.name != 'login' &&
                $route.name != '2fa-login' &&
                auth.userDetail !== null &&
                (!auth.userDetail.is_2fa_enabled ||
                    auth.userDetail.is_2fa_verified),

            'app-content':
                $route.name != 'login' &&
                $route.name != '2fa-login' &&
                auth.userDetail !== null &&
                (!auth.userDetail.is_2fa_enabled ||
                    auth.userDetail.is_2fa_verified),
        }"
    >
        <!-- container -->
        <div
            :class="{
                'main-container':
                    $route.name != 'login' &&
                    $route.name != '2fa-login' &&
                    auth.userDetail !== null &&
                    (!auth.userDetail.is_2fa_enabled ||
                        auth.userDetail.is_2fa_verified),
                'container-fluid':
                    $route.name != 'login' &&
                    $route.name != '2fa-login' &&
                    auth.userDetail !== null &&
                    (!auth.userDetail.is_2fa_enabled ||
                        auth.userDetail.is_2fa_verified),
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
            $route.name != 'login' &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail.is_2fa_enabled || auth.userDetail.is_2fa_verified)
        "
    ></SideBarRight>
    <!--/Sidebar-right-->

    <!-- Message Modal -->
    <MessageModel
        v-if="
            $route.name != 'login' &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail.is_2fa_enabled || auth.userDetail.is_2fa_verified)
        "
    ></MessageModel>
    <!-- /Message Modal -->
    <!-- Footer opened -->
    <Footer
        v-if="
            $route.name != 'login' &&
            $route.name != '2fa-login' &&
            auth.userDetail !== null &&
            (!auth.userDetail.is_2fa_enabled || auth.userDetail.is_2fa_verified)
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
