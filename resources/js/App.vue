<template>
    <!-- main-header -->
    <Header v-if="$route.name != 'login'"></Header>
    <!-- /main-header -->

    <!-- main-sidebar -->
    <SideBar v-if="$route.name != 'login'"></SideBar>
    <!-- main-sidebar -->

    <!-- main-content -->
    <div
        :class="{
            'main-content': $route.name != 'login',
            'app-content': $route.name != 'login',
        }"
    >
        <!-- container -->
        <div
            :class="{
                'main-container': $route.name != 'login',
                'container-fluid': $route.name != 'login',
            }"
        >
            <router-view></router-view>
        </div>
        <!-- /Container -->
    </div>
    <!-- /main-content -->

    <!-- Sidebar-right-->
    <SideBarRight v-if="$route.name != 'login'"></SideBarRight>
    <!--/Sidebar-right-->

    <!-- Message Modal -->
    <MessageModel v-if="$route.name != 'login'"></MessageModel>
    <!-- /Message Modal -->
    <!-- Footer opened -->
    <Footer v-if="$route.name != 'login'"></Footer>
    <!-- Footer closed -->
</template>

<script>
import Header from "./components/partials/Header.vue";
import MessageModel from "./components/partials/MessageModel.vue";
import SideBar from "./components/partials/SideBar.vue";
import SideBarRight from "./components/partials/SideBarRight.vue";
import Footer from "./components/partials/Footer.vue";

export default {
    name: "App",
    components: {
        Header,
        MessageModel,
        SideBar,
        SideBarRight,
        Footer,
    },
    watch: {
        $route(to) {
            if (to.name === "login") {
                document.body.classList.add("bg-primary");
            } else {
                document.body.classList.remove("bg-primary");
            }
        },
    },
};
</script>
