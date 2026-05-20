<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="[
            'my apps',
            'maindashboard',
            'advertisement',
            'dashboard',
            'configure',
        ]"
        whose="app"
    ></BreadCrumb>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
            <SuccessMessage
                v-if="success_msg"
                :success_msg="success_msg"
            ></SuccessMessage>
            <div class="card box-shadow-0">
                <div class="card-body pt-0">
                    <form class="mt-3">
                        <div class="form-group" bis_skin_checked="1">
                            <label
                                class="custom-control custom-checkbox custom-control-md"
                            >
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    name="add_status"
                                    value="1"
                                    :checked="
                                        form_data.add_status ? 'checked' : ''
                                    "
                                    v-model="form_data.add_status"
                                />
                                <span
                                    class="custom-control-label custom-control-label-sm tx-14"
                                    >Tick the box to enable displaying
                                    advertisements on the app.</span
                                >
                            </label>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <input type="hidden" name="saveconfiguration" />
                            <button
                                type="button"
                                id="saveconfiguration-btn"
                                :class="[
                                    'btn btn-primary',
                                    { disabled: disabled },
                                ]"
                                v-on:click="submit($event)"
                            >
                                {{ !disabled ? "Save" : "Please wait..." }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
</template>
<script>
import axios from "axios";
import { useMessageStore } from "../stores/messageStore";
import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";

export default {
    name: "DashboardAdsConfig",
    components: {
        BreadCrumb,
        SuccessMessage,
    },
    data() {
        return {
            form_data: {
                id: "",
                add_status: 0,
            },
            success_msg: "",
            disabled: false,
        };
    },

    methods: {
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            axios
                .post("/admin/dashboard-ads-configure", this.form_data)
                .then((res) => {
                    this.disabled = false;
                    this.success_msg = res.data.msg;
                });
        },
    },
    mounted() {
        axios
            .post("/admin/dashboard-ads-configure-data", {
                id: this.form_data.id,
            })
            .then((res) => {
               this.form_data.add_status = res.data.configurations.add_status == 1 ? true : false;
            });
    },
};
</script>
