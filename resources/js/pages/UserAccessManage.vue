<template>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <BreadCrumb
            :crumb_data="['User & Access', 'Invite User & Access']"
            whose="app"
        ></BreadCrumb>
    </div>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-md-8">
            <SuccessMessage
                v-if="success_msg"
                :success_msg="success_msg"
            ></SuccessMessage>
            <div class="card box-shadow-0 pt-5">
                <div class="card-body pt-0">
                    <div v-if="exception_error" class="alert alert-danger">
                        {{ exception_error }}
                    </div>
                    <form>
                        <div v-if="!form_data.id" class="form-group">
                            <label>User Email</label>
                            <input
                                type="text"
                                :class="[
                                    'form-control',
                                    { 'border-danger': user_email_error },
                                ]"
                                placeholder="Enter user email"
                                v-model="form_data.user_email"
                            />
                            <span class="text-danger">{{
                                user_email_error
                            }}</span>
                        </div>
                        <div v-if="form_data.id" class="form-group">
                            <label>User Email</label>
                            <div>
                                <b class="mx-1">{{ form_data.user_email }}</b>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row mt-5">
                                <div class="col-lg-12 mg-t-10">
                                    <label>
                                        <input
                                            type="checkbox"
                                            :checked="
                                                form_data.apps.length ===
                                                user_access_apps.length
                                            "
                                            v-on:change="
                                                handleSelectAll($event)
                                            "
                                        />
                                        <span
                                            style="font-weight: bold"
                                            class="mx-3"
                                            >Select All</span
                                        >
                                    </label>
                                </div>
                                <div
                                    v-for="(app, index) in user_access_apps"
                                    :key="index"
                                    class="col-lg-12"
                                >
                                    <label
                                        ><input
                                            type="checkbox"
                                            name="apps[]"
                                            value="{{app.id}}"
                                            v-on:change="
                                                handleAppSelection(
                                                    $event,
                                                    app.id,
                                                )
                                            "
                                            :checked="
                                                form_data.apps.includes(
                                                    app.id,
                                                ) ||
                                                form_data.apps.length ===
                                                    user_access_apps.length
                                            "
                                        /><span class="mx-3"
                                            >#{{ app.id }} {{ app.title }}</span
                                        >
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group"></div>
                        <span class="text-danger">{{ app_error }}</span>
                        <div class="form-group">
                            <button
                                type="submit"
                                :class="[
                                    'btn btn-primary mt-3 mb-0',
                                    { disabled: disabled },
                                ]"
                                v-on:click="submit($event)"
                            >
                                <span v-if="!form_data.id">
                                    {{
                                        !disabled
                                            ? "Send Invite"
                                            : "Please wait..."
                                    }}</span
                                >
                                <span v-else>
                                    {{
                                        !disabled
                                            ? "Update Access"
                                            : "Please wait..."
                                    }}</span
                                >
                            </button>
                            <a
                                :class="[
                                    'btn btn-light mt-3 mb-0 mx-3',
                                    { disabled: disabled },
                                ]"
                                href="javascript:;"
                                v-on:click="
                                    this.$router.push({
                                        name: 'user-access-list',
                                    })
                                "
                            >
                                Cancel
                            </a>
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
    name: "UserAccessManage",
    components: {
        BreadCrumb,
        SuccessMessage,
    },
    data() {
        return {
            form_data: {
                id: "",
                user_email: "",
                apps: [],
            },

            user_access_apps: [],
            exception_error: "",
            user_email_error: "",
            app_error: "",
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
        handleSelectAll(event) {
            if (event.target.checked) {
                this.form_data.apps = [];
                this.form_data.apps = this.user_access_apps.map(
                    (app) => app.id,
                );
            } else {
                this.form_data.apps = [];
            }
        },
        handleAppSelection(event, app_id) {
            const checkbox = event.target;
            if (checkbox.checked) {
                if (!this.form_data.apps.includes(app_id)) {
                    this.form_data.apps.push(app_id);
                }
            } else {
                this.form_data.apps = this.form_data.apps.filter(
                    (id) => id !== app_id,
                );
            }
        },
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.user_email_error = "";
            this.app_type_error = "";
            axios
                .post("/admin/user-access-manage", this.form_data)
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        if (res.data.msg.user_email) {
                            this.user_email_error = res.data.msg.user_email[0];
                        }
                        if (res.data.msg.apps) {
                            this.app_error = res.data.msg.apps[0];
                        }
                    } else {
                        if (!this.form_data.id) {
                            const success = useMessageStore();
                            success.setMessage(res.data.msg);
                            this.$router.push({ name: "user-access-list" });
                        } else {
                            this.success_msg = res.data.msg;
                        }
                    }
                })
                .catch((err) => {
                    this.disabled = false;
                    this.exception_error =
                        err.response?.data?.msg ||
                        "An error occurred. Please try again.";
                });
        },
    },
    mounted() {
        axios.post("/admin/user-access-apps").then((res) => {
            this.user_access_apps = res.data.apps;
        });
        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/user-access-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.user_email = res.data.user_email;
                    this.form_data.apps = res.data.assigned_apps;
                });
        }
    },
};
</script>
