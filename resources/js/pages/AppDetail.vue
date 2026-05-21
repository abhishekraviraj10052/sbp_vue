<template>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <BreadCrumb
            :crumb_data="[
                'my apps',
                '#' + whmcs_service_id + ' ' + app_name,
                'main dashbaord',
            ]"
        ></BreadCrumb>
    </div>
    <!-- /breadcrumb -->
    <div
        class="row d-flex justify-content-center align-items-center"
        style="height: 100vh"
        v-if="isLoading"
    >
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only text-dark">Loading..</span>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'dns-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">DNS</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ dns_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center overflow-hidden box-shadow-info"
                            >
                                <i
                                    class="fa fa-server tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'announcement-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">Announcements</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ announcement_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-success-gradient text-center align-self-center shadow-success overflow-hidden box-shadow-success"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="fa fa-microphone tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'notification-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">Notifications</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ notification_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center shadow-info overflow-hidden box-shadow-info"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="fe fe-message-square tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'device-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">Devices</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ device_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-success-gradient text-center align-self-center shadow-success overflow-hidden box-shadow-success"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="fa fa-sitemap tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'rewarded-ads-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">
                                        Rewarded Advertisements
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ rewarded_ads_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center shadow-info overflow-hidden box-shadow-info"
                                bis_skin_checked="1"
                            >
                                <i class="fas fa-ad tx-20 lh-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'dashboard-ads-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">
                                        Dashboard Advertisements
                                    </h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ dashboard_ads_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center shadow-info overflow-hidden box-shadow-info"
                                bis_skin_checked="1"
                            >
                                <i class="fas fa-ad tx-20 lh-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'client-feedback-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">Client Feedbacks</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ client_feedback_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-success-gradient text-center align-self-center shadow-success overflow-hidden box-shadow-success"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="far fa-comment-dots tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'client-report-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">Client Reports</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ client_report_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center shadow-info overflow-hidden box-shadow-info"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="fa fa-exclamation-triangle tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'api-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">APIS</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ api_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-success-gradient text-center align-self-center success-success overflow-hidden box-shadow-success"
                                bis_skin_checked="1"
                            >
                                <i class="fa fa-key tx-20 lh-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <a
                href="Javascript:void(0);"
                v-on:click="this.$router.push({ name: 'vpn-list' })"
            >
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4 pt-0">
                                <div class="#">
                                    <h6 class="mb-2 tx-12">VPNS</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4
                                            class="tx-26 font-weight-semibold mb-2 counter-count"
                                        >
                                            {{ vpn_count }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon widget bg-info-gradient text-center align-self-center overflow-hidden box-shadow-info"
                                bis_skin_checked="1"
                            >
                                <i
                                    class="bi bi-shield tx-20 lh-lg text-white"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import BreadCrumb from "@/components/bread_crumb/BreadCrumb.vue";
import { useAuthStore } from "@/stores/auth";
export default {
    name: "AppDetail",
    components: {
        BreadCrumb,
    },
    data() {
        return {
            whmcs_service_id: "",
            app_name: "",
            isLoading: false,
            dns_count: 0,
            announcement_count: 0,
            notification_count: 0,
            device_count: 0,
            rewarded_ads_count: 0,
            dashboard_ads_count: 0,
            client_feedback_count: 0,
            client_report_count: 0,
            api_count: 0,
            vpn_count: 0,
        };
    },
    mounted() {
        const auth = useAuthStore();
        this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
        this.app_name = auth.appDetail ? auth.appDetail.title : null;
        if (!this.whmcs_service_id) {
            this.$router.push({ name: "app-list" });
        } else {
            let auth = useAuthStore();
            this.isLoading = true;
            axios
                .post("/admin/app-detail", {
                    whmcs_service_id: this.whmcs_service_id,
                })
                .then((res) => {
                    res.data.dns_count
                        ? (this.dns_count = res.data.dns_count)
                        : (this.dns_count = 0);
                    res.data.announcement_count
                        ? (this.announcement_count =
                              res.data.announcement_count)
                        : (this.announcement_count = 0);
                    res.data.notification_count
                        ? (this.notification_count =
                              res.data.notification_count)
                        : (this.notification_count = 0);
                    res.data.device_count
                        ? (this.device_count = res.data.device_count)
                        : (this.device_count = 0);
                    res.data.rewarded_ads_count
                        ? (this.rewarded_ads_count =
                              res.data.rewarded_ads_count)
                        : (this.rewarded_ads_count = 0);
                    res.data.dashboard_ads_count
                        ? (this.dashboard_ads_count =
                              res.data.dashboard_ads_count)
                        : (this.dashboard_ads_count = 0);
                    res.data.client_feedback_count
                        ? (this.client_feedback_count =
                              res.data.client_feedback_count)
                        : (this.client_feedback_count = 0);
                    res.data.client_report_count
                        ? (this.client_report_count =
                              res.data.client_report_count)
                        : (this.client_report_count = 0);
                    res.data.api_count
                        ? (this.api_count = res.data.api_count)
                        : (this.api_count = 0);
                    res.data.vpn_count
                        ? (this.vpn_count = res.data.vpn_count)
                        : (this.vpn_count = 0);
                    this.isLoading = false;
                });
        }
    },
};
</script>

<style scoped>
a .card:hover {
    box-shadow: 0px 5px 10px -6px #000;
    transition: 0.3s;
    transform: translateY(-8px);
}
.tx-12 {
    font-size: 12px;
}
</style>
