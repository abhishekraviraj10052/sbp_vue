<template>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <BreadCrumb
            :crumb_data="[
                'my apps',
                '#' + whmcs_service_id + ' ' + app_name,
                'main dashboard',
                'rewarded ads',
                'list',
            ]"
            url="rewarded-ads-manage"
            :add_btn="true"
        ></BreadCrumb>
        <div class="justify-content-center mt-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15">
                    <a
                        href="javascript:void(0);"
                        class="btn btn-primary text-white"
                        v-on:click="
                            () => {
                                this.$router.push({
                                    name: 'rewarded-ads-manage',
                                });
                            }
                        "
                        ><i class="fa fa-plus"></i>&nbsp&nbspADD</a
                    >
                    <a
                        href="javascript:void(0);"
                        class="btn btn-info text-white mx-2"
                        v-on:click="
                            () => {
                                this.$router.push({
                                    name: 'rewarded-ads-configure',
                                });
                            }
                        "
                        ><i class="fa fa-cog"></i>&nbsp&nbspConfiguration</a
                    >
                </li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <SuccessMessage
                v-if="success_msg"
                :success_msg="success_msg"
            ></SuccessMessage>
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <!-- <h4 class="card-title mg-b-0">My Apps</h4> -->
                    </div>
                </div>
                <div class="card-body">
                    <div
                        class="alert alert-info alert-dismissible announcementsalert fade show"
                        role="alert"
                        bis_skin_checked="1"
                    >
                        <span class="alert-inner--text">
                            <b>Rewarded Advertisements</b>: Enjoy enhanced user
                            engagement as these ads appear after a frequency of
                            events (clicks) that you configure.
                        </span>
                    </div>
                    <div class="table-responsive">
                        <table
                            class="table table-bordered table-hover mb-0 text-md-nowrap"
                        >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Content</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="records.length == 0">
                                <tr v-if="isLoading">
                                    <td colspan="8" class="text-center">
                                        <div
                                            class="spinner-border text-primary"
                                            role="status"
                                        >
                                            <span class="sr-only text-dark"
                                                >Loading...</span
                                            >
                                        </div>
                                    </td>
                                </tr>
                                <tr v-else>
                                    <td colspan="8" class="text-center">
                                        No records found
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-if="isLoading">
                                    <td colspan="8" class="text-center">
                                        <div
                                            class="spinner-border text-primary"
                                            role="status"
                                        >
                                            <span class="sr-only text-dark"
                                                >Loading...</span
                                            >
                                        </div>
                                    </td>
                                </tr>
                                <RewardedAdsRecords
                                    v-else
                                    :records="records"
                                    :delete="delete"
                                ></RewardedAdsRecords>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
</template>

<script>
import axios from "axios";
import { useMessageStore } from "../stores/messageStore";
import { useAuthStore } from "@/stores/auth";

import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";
import RewardedAdsRecords from "../components/RewardedAdsRecords.vue";

export default {
    name: "RewardedAdsList",
    components: {
        BreadCrumb,
        SuccessMessage,
        RewardedAdsRecords,
    },
    data() {
        return {
            whmcs_service_id: "",
            app_name: "",
            isLoading: false,
            success_msg: "",
            records: [],
        };
    },
    methods: {
        delete(id) {
            axios
                .post("/admin/rewarded-ads-delete", {
                    id: id,
                })
                .then((res) => {
                    if (!res.data.errors) {
                        this.success_msg = res.data.msg;
                        this.records = this.records.filter((record) => {
                            if (record.id != id) {
                                return record;
                            }
                        });
                    }
                });
        },
    },
    mounted() {
        const auth = useAuthStore();
        this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
        this.app_name = auth.appDetail ? auth.appDetail.title : null;

        this.isLoading = true;
        const success = useMessageStore();
        if (success.message) {
            this.has_success = true;
            this.success_msg = success.message;
            success.clearMessage();
        }
        axios.post("/admin/rewarded-ads-list").then((res) => {
            this.records = res.data.records.data;
            this.isLoading = false;
        });
    },
};
</script>
