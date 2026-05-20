<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="
            form_data.id
                ? [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'maindashboard',
                      'dns',
                      'edit',
                  ]
                : [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'maindashboard',
                      'dns',
                      'add new',
                  ]
        "
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
                    <form>
                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                :class="[
                                    'form-control',
                                    { 'border-danger': dns_name_error },
                                ]"
                                placeholder="Enter dns name"
                                v-model="form_data.dns_name"
                            />
                            <span class="text-danger" v-show="dns_name_error">{{
                                dns_name_error
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Dns</label>
                            <input
                                type="text"
                                :class="[
                                    'form-control',
                                    { 'border-danger': dns_value_error },
                                ]"
                                placeholder="Enter dns"
                                v-model="form_data.dns_value"
                            />
                            <span
                                class="text-danger"
                                v-show="dns_value_error"
                                >{{ dns_value_error }}</span
                            >
                        </div>
                        <div class="form-group">
                            <button
                                type="submit"
                                :class="[
                                    'btn btn-primary mt-3 mb-0',
                                    { disabled: disabled },
                                ]"
                                v-on:click="submit($event)"
                            >
                                {{ !disabled ? "Submit" : "Please wait..." }}
                            </button>
                            <button
                                :class="[
                                    'btn btn-light mt-3 mb-0 mx-3',
                                    { disabled: disabled },
                                ]"
                                href="javascript:void(0);"
                                v-on:click="
                                    this.$router.push({ name: 'dns-list' })
                                "
                            >
                                Cancel
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
import { useAuthStore } from "@/stores/auth";

import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";

export default {
    name: "DnsManage",
    components: {
        BreadCrumb,
        SuccessMessage,
    },
    data() {
        return {
            whmcs_service_id: "",
            app_name: "",
            form_data: {
                id: "",
                dns_name: "",
                dns_value: "",
            },
            dns_name_error: "",
            dns_value_error: "",
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.dns_name_error = "";
            this.dns_value_error = "";
            axios.post("/admin/dns-manage", this.form_data).then((res) => {
                this.disabled = false;
                if (res.data.errors) {
                    if (res.data.msg.dns_name) {
                        this.dns_name_error = res.data.msg.dns_name[0];
                    }
                    if (res.data.msg.dns_value) {
                        this.dns_value_error = res.data.msg.dns_value[0];
                    }
                } else {
                    if (!this.form_data.id) {
                        const success = useMessageStore();
                        success.setMessage(res.data.msg);
                        this.$router.push({ name: "dns-list" });
                    } else {
                        this.success_msg = res.data.msg;
                    }
                }
            });
        },
    },
    mounted() {
        const auth = useAuthStore();
        this.whmcs_service_id = auth.whmcs_service_id;
        this.app_name = auth.appName;

        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/dns-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.dns_name = res.data.record.name;
                    this.form_data.dns_value = res.data.record.dns;
                });
        }
    },
};
</script>
