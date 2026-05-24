<template>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <BreadCrumb
            :crumb_data="[
                'my apps',
                '#' + whmcs_service_id + ' ' + app_name,
                'maindashboard',
                'announcement',
                'list',
            ]"
            url="announcement-manage"
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
                                    name: 'announcement-manage',
                                });
                            }
                        "
                        ><i class="fa fa-plus"></i>&nbsp&nbspADD</a
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
                    <div class="table-responsive">
                        <!-- Search -->
                        <div class="d-flex justify-content-end mb-3">
                            <!-- <div class="w-100 w-md-auto"> -->
                            <input
                                v-model="search"
                                @input="searchData()"
                                placeholder="Search..."
                                class="form-control w-300"
                            />
                            <!-- </div> -->
                        </div>
                        <!-- Search -->
                        <table
                            class="table table-bordered table-hover mb-0 text-md-nowrap"
                        >
                            <thead>
                                <tr>
                                    <th
                                        @click="sortBy('id')"
                                        class="cursor-pointer"
                                    >
                                        ID
                                    </th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody v-if="records.length == 0">
                                <tr v-if="isLoading">
                                    <td colspan="5" class="text-center">
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
                                    <td colspan="5" class="text-center">
                                        No records found
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-if="isLoading">
                                    <td colspan="5" class="text-center">
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
                                <AnnouncementRecords
                                    v-else
                                    :records="records"
                                    :delete="delete"
                                ></AnnouncementRecords>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="text-center">
                            <button
                                class="btn btn-primary mt-3 mb-0"
                                :disabled="page === 1"
                                @click="changePage(page - 1)"
                            >
                                Prev
                            </button>
                            <button
                                class="btn btn-primary mt-3 mx-3 mb-0"
                                :disabled="records.length == 0"
                                @click="changePage(page + 1)"
                            >
                                Next
                            </button>
                        </div>
                        <!-- Pagination -->
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
import AnnouncementRecords from "../components/AnnouncementRecords.vue";

export default {
    name: "AnnouncementList",
    components: {
        BreadCrumb,
        SuccessMessage,
        AnnouncementRecords,
    },
    data() {
        return {
            whmcs_service_id: "",
            app_name: "",
            isLoading: true,
            success_msg: "",
            records: [],

            search: "",
            page: 1,
            lastPage: 1,
            sortField: "id",
            sortDirection: "desc",
        };
    },
    methods: {
        loadData() {
            try {
                this.isLoading = true;
                axios
                    .post("/admin/announcement-list", {
                        page: this.page,
                        search: this.search,
                        sort_field: this.sortField,
                        sort_direction: this.sortDirection,
                    })
                    .then((res) => {
                        this.records = res.data.records.data;
                        this.lastPage = res.data.last_page;
                        this.isLoading = false;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        changePage(page) {
            this.page = page;
            this.loadData();
        },
        sortBy(field) {
            if (this.sortField === field) {
                this.sortDirection =
                    this.sortDirection === "asc" ? "desc" : "asc";
            } else {
                this.sortField = field;
                this.sortDirection = "asc";
            }

            this.loadData();
        },
        searchData() {
            this.page = 1;
            this.loadData();
        },
        delete(id) {
            axios
                .post("/admin/announcement-delete", {
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
        this.loadData();
    },
};
</script>

<style>
.w-300 {
    width: 300px;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
