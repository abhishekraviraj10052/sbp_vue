<template>
    <div class="sticky">
        <aside class="app-sidebar">
            <div class="main-sidebar-header active">
                <a class="header-logo active text-dark" href="javascript:;">
                    <h4>SBP Panel</h4>
                </a>
            </div>
            <SideBarContent></SideBarContent>
        </aside>
    </div>
</template>

<script>

import SideBarContent from './SideBarContent.vue';
export default {
    name: "SideBar",
    components: {
        SideBarContent
    },
    data() {
        return {
            route_names: ["app-list", "app-manage"],
        };
    },
};
</script>
<style scoped>
.mt-10 {
    margin-top: 10px !important;
}

.sticky {
    position: sticky;
    top: 0;
}

.app-sidebar {
    display: flex;
    flex-direction: column;
    height: 100vh;
}

.main-sidebar-header {
    flex-shrink: 0;
}

.main-sidemenu {
    flex: 1;
    overflow-y: auto;
}
</style>
