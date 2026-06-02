<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="[
            'My Apps',
            '#' + whmcs_service_id + ' ' + app_name,
            'Maindashboard',
            'Apk Version',
        ]"
        whose="app"
    ></BreadCrumb>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-md-8">
            <SuccessMessage
                v-if="success_msg"
                :success_msg="success_msg"
            ></SuccessMessage>
            <div class="card box-shadow-0 mt-2 pt-4">
                <div class="card-body pt-0">
                    <form>
                        <div
                            class="form-group"
                            v-if="has_apk_file && !is_editable"
                        >
                            <label>Apk Version Name</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="apk_version_name"
                                disabled
                            />
                        </div>
                        <div
                            class="form-group"
                            v-if="has_apk_file && !is_editable"
                        >
                            <label>Apk Version Code</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="apk_version_code"
                                disabled
                            />
                        </div>
                        <div
                            class="form-group"
                            v-if="!has_apk_file || is_editable"
                        >
                            <label>Apk File</label>
                            <input
                                type="file"
                                :class="[
                                    'form-control',
                                    { 'border-danger': apk_file_error },
                                ]"
                                accept=".apk"
                                v-on:change="handleFileChange"
                            />
                            <span class="text-danger" v-show="apk_file_error">{{
                                apk_file_error
                            }}</span>
                        </div>
                        <div v-show="has_apk_file" class="mt-3">
                            <span class=""> Current APK File :</span>
                            &nbsp;
                            <i
                                class="fa fa-download"
                                v-on:click="handle_download(id)"
                            ></i>
                            &nbsp;
                            <i
                                class="fa fa-edit"
                                v-on:click="is_editable = !is_editable"
                            ></i>
                            &nbsp;
                            <i
                                class="fa fa-trash"
                                v-on:click="deleteApkFile"
                            ></i>
                        </div>
                        <div class="form-group">
                            <button
                                type="submit"
                                :class="[
                                    'btn btn-primary mt-3 mb-0',
                                    { disabled: disabled },
                                ]"
                                v-on:click="submit"
                                v-if="!has_apk_file || is_editable"
                            >
                                {{ !disabled ? "Submit" : "Please wait..." }}
                            </button>
                        </div>
                        <div
                            v-if="uploadPercentage > 0"
                            style="
                                height: 25px;
                                border: 1px solid #ccc;
                                margin-top: 20px;
                            "
                        >
                            <div
                                :style="{
                                    width: uploadPercentage + '%',
                                    height: '100%',
                                    background: 'green',
                                    transition: '0.3s',
                                }"
                            ></div>
                            <span v-if="uploadPercentage > 0">
                                {{ uploadPercentage }}%
                            </span>
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

            id: null,
            apk_file_name: "",
            apk_version_name: "",
            apk_version_code: "",

            apk_file_error: "",
            selected_file: null,
            has_apk_file: false,
            is_editable: false,
            disabled: false,
            success_msg: "",
            uploadPercentage: 0,
        };
    },
    methods: {
        handleFileChange(event) {
            this.selected_file = event.target.files[0];
            console.log(this.selected_file);
        },
        async submit(event) {
            event.preventDefault();
            if (!this.selected_file) {
                this.apk_file_error = "Please select an apk file";
                return;
            }
            this.disabled = true;
            this.apk_file_error = "";
            //Upload apk start

            const chunkSize = 1024 * 1024; // 1MB
            const totalChunks = Math.ceil(this.selected_file.size / chunkSize);
            const uniqueFileName = Date.now() + "_" + this.selected_file.name;
            console.log(chunkSize, totalChunks, uniqueFileName);
            try {
                for (
                    let chunkIndex = 0;
                    chunkIndex < totalChunks;
                    chunkIndex++
                ) {
                    const start = chunkIndex * chunkSize;
                    const end = Math.min(
                        start + chunkSize,
                        this.selected_file.size,
                    );
                    const chunk = this.selected_file.slice(start, end);
                    const formData = new FormData();

                    formData.append("file", chunk);
                    formData.append("fileName", uniqueFileName);
                    formData.append("chunkIndex", chunkIndex);
                    formData.append("totalChunks", totalChunks);
                    await axios.post("admin/app-version-manage", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },

                        onUploadProgress: (progressEvent) => {
                            const chunkProgress =
                                progressEvent.loaded / progressEvent.total;

                            const overallProgress =
                                ((chunkIndex + chunkProgress) / totalChunks) *
                                100;

                            this.uploadPercentage = Math.round(overallProgress);
                        },
                    });
                }
            } catch (error) {
                this.selected_file = null;
                this.disabled = false;
                this.uploadPercentage = 0;
                this.apk_file_error = error;
                return;
            }

            Swal.fire({
                icon: "success",
                title: "Apk uploaded successfully",
                showConfirmButton: false,
                timer: 1500,
            }).then(async () => {
                this.selected_file = null;
                this.disabled = false;
                this.uploadPercentage = 0;
                await axios.get("admin/app-version-manage").then((res) => {
                    this.id = res.data.record?.id;
                    this.apk_version_name = res.data.record?.apk_version_name;
                    this.apk_version_code = res.data.record?.apk_version_code;
                    this.has_apk_file = this.id ? true : false;
                    this.is_editable = this.id ? false : true;
                });
            });
            //Upload apk end
        },
        handle_download(id) {
            Swal.fire({
                title: "Are you sure you want to download this APK file?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, download it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios
                            .get(`admin/apk-download/${id}`, {
                                responseType: "blob",
                            })
                            .then((response) => {
                                const blob = new Blob([response.data], {
                                    type: "application/vnd.android.package-archive",
                                });

                                const url = window.URL.createObjectURL(blob);

                                const link = document.createElement("a");
                                link.href = url;
                                link.download = this.apk_file_name + ".apk";

                                document.body.appendChild(link);
                                link.click();

                                document.body.removeChild(link);

                                window.URL.revokeObjectURL(url);
                            });
                    } catch (error) {
                        console.error(error);
                    }
                }
            });
        },
        deleteApkFile() {
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("admin/app-version-delete", {
                            id: this.id,
                            delete_file: true,
                        })
                        .then((res) => {
                            if (!res.data.errors) {
                                Swal.fire(
                                    "Deleted!",
                                    "Your file has been deleted.",
                                    "success",
                                );
                                this.id = null;
                                this.selected_file = null;
                                this.apk_version_name = "";
                                this.apk_version_code = "";
                                this.has_apk_file = false;
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

        axios.get("admin/app-version-manage").then((res) => {
            this.id = res.data.record?.id;
            this.apk_version_name = res.data.record?.apk_version_name;
            this.apk_version_code = res.data.record?.apk_version_code;
            this.has_apk_file = this.id ? true : false;
        });
    },
};
</script>
<style scoped>
.form-control {
    color: #000;
}
</style>
