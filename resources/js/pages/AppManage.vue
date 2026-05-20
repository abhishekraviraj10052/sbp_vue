<template>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <BreadCrumb
            :crumb_data="
                form_data.id ? ['my apps', 'edit'] : ['my apps', 'add new']
            "
            whose="app"
        ></BreadCrumb>
    </div>
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
                            <label>App name</label>
                            <input
                                type="text"
                                :class="[
                                    'form-control',
                                    { 'border-danger': app_name_error },
                                ]"
                                placeholder="Enter app name"
                                v-model="form_data.app_name"
                            />
                            <span class="text-danger" v-show="app_name_error">{{
                                app_name_error
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label>App type</label>
                            <select
                                name=""
                                id=""
                                :class="[
                                    'form-control',
                                    { 'border-danger': app_type_error },
                                ]"
                                v-model="form_data.app_type"
                            >
                                <option value="">Select app type</option>
                                <option
                                    v-for="(
                                        label, value
                                    ) in form_data.app_types"
                                    :key="value"
                                    :value="value"
                                >
                                    {{ label }}
                                </option>
                            </select>
                            <span class="text-danger" v-show="app_type_error">{{
                                app_type_error
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
                                {{ !disabled ? "Submit" : "Please wait..." }}
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
                app_name: "",
                app_type: "",
                app_types: [],
            },

            app_name_error: "",
            app_type_error: "",
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.app_name_error = "";
            this.app_type_error = "";
            axios.post("/admin/app-manage", this.form_data).then((res) => {
                this.disabled = false;
                if (res.data.errors) {
                    if (res.data.msg.app_name) {
                        this.app_name_error = res.data.msg.app_name[0];
                    }
                    if (res.data.msg.app_type) {
                        this.app_type_error = res.data.msg.app_type[0];
                    }
                } else {
                    if (!this.form_data.id) {
                        const success = useMessageStore();
                        success.setMessage(res.data.msg);
                        this.$router.push({ name: "app-list" });
                    } else {
                        this.success_msg = res.data.msg;
                    }
                }
            });
        },
    },
    mounted() {
        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/app-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.app_name = res.data.record.title;
                    this.form_data.app_type = res.data.record.type;
                });
        }

        axios.post("/admin/app-types").then((res) => {
            this.form_data.app_types = res.data.app_types;
        });
    },
};
</script>
