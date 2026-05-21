<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="
            form_data.id
                ? [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'main dashboard',
                      'dashboard ads',
                      'edit',
                  ]
                : [
                      'my apps',
                      '#' + whmcs_service_id + ' ' + app_name,
                      'main dashboard',
                      'dashboard ads',
                      'add new',
                  ]
        "
        whose="app"
    ></BreadCrumb>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
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
                            <label>Message(Optional)</label>
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
                            <label>Image</label>
                            <input
                                type="file"
                                :class="[
                                    'form-control',
                                    { 'border-danger': file_error },
                                ]"
                                multiple
                                accept="image/*"
                                v-on:change="handleFileChange"
                            />
                            <span class="text-danger" v-show="file_error">{{
                                file_error
                            }}</span>
                            <div
                                class="row mt-3"
                                v-if="
                                    form_data.id && form_data.files.length > 0
                                "
                            >
                                <div
                                    class="col-md-3"
                                    v-for="(filename, index) in form_data.files"
                                    :key="index"
                                >
                                    <i
                                        class="fa fa-trash text-danger"
                                        style="cursor: pointer"
                                        v-on:click="deleteImage(filename)"
                                    ></i>
                                    <img
                                        :src="
                                            '/uploads/dashboard_ads/' + filename
                                        "
                                        alt="Image"
                                        style="
                                            max-width: 100px;
                                            max-height: 100px;
                                        "
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <select
                                name=""
                                id=""
                                class="form-control"
                                v-model="form_data.status"
                            >
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
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
                                        name: 'dashboard-ads-list',
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

export default {
    name: "DnsManage",
    components: {
        BreadCrumb,
    },
    data() {
        return {
            whmcs_service_id: "",
            app_name: "",
            form_data: {
                id: "",
                title: "",
                message: "",
                temp_files: [],
                files: [],
                status: "active",
            },
            title_error: "",
            message_error: "",
            file_error: "",
            disabled: false,
        };
    },
    methods: {
        handleFileChange(event) {
            if (this.form_data.id) {
                this.form_data.temp_files = event.target.files;
            } else {
                this.form_data.files = event.target.files;
            }
        },
        deleteImage(filename) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/admin/dashboard-ads-image-delete", {
                            id: this.form_data.id,
                            filename: filename,
                        })
                        .then((res) => {
                            if (!res.errors) {
                                Swal.fire({
                                    icon: "success",
                                    title: res.data.msg,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                                this.form_data.files =
                                    this.form_data.files.filter(
                                        (file) => file !== filename,
                                    );
                            }
                        });
                }
            });
        },

        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.title_error = "";
            this.message_error = "";
            this.file_error = "";
            let fd = new FormData();
            fd.append("id", this.form_data.id ?? "");
            fd.append("title", this.form_data.title);
            fd.append("message", this.form_data.message);
            fd.append("status", this.form_data.status);
            fd.append("content_type", this.form_data.content_type);

            if (this.form_data.id) {
                if (this.form_data.temp_files.length > 0) {
                    for (let i = 0; i < this.form_data.temp_files.length; i++) {
                        fd.append("files[]", this.form_data.temp_files[i]);
                    }
                }
            } else {
                if (this.form_data.files.length > 0) {
                    for (let i = 0; i < this.form_data.files.length; i++) {
                        fd.append("files[]", this.form_data.files[i]);
                    }
                }
            }

            axios
                .post("/admin/dashboard-ads-manage", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        if (res.data.msg.title) {
                            this.title_error = res.data.msg.title[0];
                        }
                        if (res.data.msg.files) {
                            this.file_error = res.data.msg.files[0];
                        }
                        if (res.data.msg["files.0"]) {
                            this.file_error = res.data.msg["files.0"][0];
                        }
                    } else {
                        const success = useMessageStore();
                        success.setMessage(res.data.msg);
                        this.$router.push({ name: "dashboard-ads-list" });
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
                .post("/admin/dashboard-ads-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.title = res.data.record.title;
                    this.form_data.message = res.data.record.text;
                    this.form_data.files = res.data.record.filepath ?? [];
                    this.form_data.status = res.data.record.status;
                });
        }
    },
};
</script>
