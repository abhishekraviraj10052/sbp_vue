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
                    <form>
                        <div class="form-group">
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
                        <div class="form-group">
                            <label>Access</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <label>
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="optradio"
                                            value="option1"
                                            :checked="!specific_apps"
                                            v-on:click="specific_apps = false"
                                        />
                                        All Apps
                                    </label>
                                    <label class="mx-5">
                                        <input
                                            type="radio"
                                            class="form-check-input"
                                            name="optradio"
                                            value="option1"
                                            :checked="specific_apps"
                                            v-on:click="specific_apps = true"
                                        />
                                        Specific Apps
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div v-if="specific_apps" class="form-group">
                            <label>Select Apps</label>
                            <div class="row mg-t-12">
                                <div class="col-lg-12 mg-t-10">
                                    <label>
                                        <input type="checkbox" />
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
                                {{
                                    !disabled ? "Send Invite" : "Please wait..."
                                }}
                            </button>
                            <button
                                :class="[
                                    'btn btn-light mt-3 mb-0 mx-3',
                                    { disabled: disabled },
                                ]"
                                href="javascript:void(0);"
                                v-on:click="
                                    this.$router.push({ name: 'app-list' })
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
import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";

export default {
    name: "AppManage",
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
            user_email_error: "",
            app_error: "",
            specific_apps: false,
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
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
            console.log(this.form_data.apps);
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
                           this.$router.push({ name: "user-access-list" });
                        } 
                    }
                });
        },
    },
    mounted() {
        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/user-access-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.app_name = res.data.record.title;
                    this.form_data.app_type = res.data.record.type;
                });
        }

        axios.post("/admin/user-access-apps").then((res) => {
            this.user_access_apps = res.data.apps;
            console.log(this.form_data.apps);
        });
    },
};
</script>
