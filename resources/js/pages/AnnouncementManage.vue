<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="
            form_data.id
                ? [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'maindashboard',
                      'announcement',
                      'edit',
                  ]
                : [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'maindashboard',
                      'announcement',
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
                            <label>Title</label>
                            <input
                                type="text"
                                :class="[
                                    'form-control',
                                    { 'border-danger': title_error },
                                ]"
                                placeholder="Enter title"
                                v-model="form_data.title"
                            />
                            <span class="text-danger" v-show="title_error">{{
                                title_error
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea
                                :class="[
                                    'form-control',
                                    { 'border-danger': message_error },
                                ]"
                                placeholder="Enter message"
                                v-model="form_data.message"
                            >
                            </textarea>
                            <span class="text-danger" v-show="message_error">{{
                                message_error
                            }}</span>
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
                                {{ form_data.id ? "Update" : "Submit" }}
                            </button>
                            <button
                                :class="[
                                    'btn btn-light mt-3 mb-0 mx-3',
                                    { disabled: disabled },
                                ]"
                                href="javascript:void(0);"
                                v-on:click="
                                    this.$router.push({
                                        name: 'announcement-list',
                                    })
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
                title: "",
                message: "",
            },
            title_error: "",
            message_error: "",
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.title_error = "";
            this.message_error = "";
            axios
                .post("/admin/announcement-manage", this.form_data)
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        if (res.data.msg.title) {
                            this.title_error = res.data.msg.title[0];
                        }
                        if (res.data.msg.message) {
                            this.message_error = res.data.msg.message[0];
                        }
                    } else {
                        if (!this.form_data.id) {
                            const success = useMessageStore();
                            success.setMessage(res.data.msg);
                            this.$router.push({ name: "announcement-list" });
                        } else {
                            this.success_msg = res.data.msg;
                        }
                    }
                });
        },
    },
    mounted() {
        const auth = useAuthStore();
        this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
        this.app_name = auth.appDetail ? auth.appDetail.title : null;

        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/announcement-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.title = res.data.record.title;
                    this.form_data.message = res.data.record.message;
                });
        }
    },
};
</script>
