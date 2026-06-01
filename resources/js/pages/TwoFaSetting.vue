<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="['My Apps', '2FA settings (Two-Factor Authenticator)']"
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
            <div class="card box-shadow-0">
                <div class="card-body pt-0">
                    <form>
                        <div class="form-group mt-4">
                            <label class="custom-switch ps-0">
                                <span
                                    class="custom-switch-description tx-17 me-2"
                                    >2FA
                                    <span>{{
                                        is_2fa_enabled ? "enabled" : "disabled"
                                    }}</span></span
                                >
                                <input
                                    type="checkbox"
                                    class="custom-switch-input"
                                    v-on:change="enable2fa"
                                    :checked="is_2fa_enabled"
                                />
                                <span
                                    class="custom-switch-indicator custom-switch-indicator-lg custom-square"
                                ></span>
                            </label>
                        </div>
                        <div class="col-md-12" v-if="!is_2fa_enabled">
                            <p>
                                Using an authenticator app like Google
                                Authenticator or Duo, scan the QR code below.
                            </p>
                            <div class="text-center">
                                <img :src="qr" />
                            </div>
                            <!--  <p style="margin-top: 20px">
                                Having trouble scanning the code? Enter the code
                                manually:
                                <b id="manualcode" data-seccode=""
                                    >6XDCJSME52UMKFWN</b
                                >
                            </p>
                            <p></p> -->
                            <div class="form-group">
                                <label for="inputfillsix"
                                    >Enter the 6-digit code that the application
                                    generates to verify and complete
                                    setup.</label
                                >
                                <input
                                    type="text"
                                    :class="[
                                        'form-control',
                                        { 'border-danger': otp_error },
                                    ]"
                                    placeholder="Enter Code"
                                    v-model="otp"
                                />
                                <span class="text-danger">{{ otp_error }}</span>
                                <div class="invalid-feedback">
                                    Please enter code
                                </div>
                            </div>
                            <div class="form-group">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    v-on:click="verifyOtp"
                                >
                                    {{ !disabled ? "Verify" : "Verifying..." }}
                                </button>
                                <a class="btn btn-light" href="javascript:;"
                                    >Cancel</a
                                >
                            </div>
                        </div>
                        <div class="col-md-12" v-else>
                            <div
                                class="form-group d-flex"
                                v-if="google2fa_backup_code"
                            >
                                <input
                                    class="form-control"
                                    v-model="google2fa_backup_code"
                                />
                                <button class="btn btn-primary mx-2">
                                    <i class="fa fa-copy"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    v-on:click="resetBackUpCode"
                                >
                                    {{
                                        !disabled
                                            ? "Reset Backup Code"
                                            : "Please wait..."
                                    }}
                                </button>
                                <a
                                    class="btn btn-primary mx-2"
                                    href="javascript:;"
                                    v-on:click="handle_download"
                                    >Download Backup Code</a
                                >
                            </div>
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
import { useMessageStore } from "../stores/messageStore.js";
import { useAuthStore } from "@/stores/auth";

import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";
import SuccessMessage from "../components/success_alert/SuccessMessage.vue";
import QRCode from "qrcode";
export default {
    name: "DnsManage",
    components: {
        BreadCrumb,
        SuccessMessage,
    },
    data() {
        return {
            google2fa_backup_code: "",
            is_2fa_enabled: false,

            qr: "",
            otp: "",

            disabled: false,
            otp_error: "",
            success_msg: "",
        };
    },
    methods: {
        async enable2fa() {
            if (this.is_2fa_enabled) {
                Swal.fire({
                    title: "Are you sure you want to disable 2FA?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, disable it!",
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        let res = await axios.post("admin/2fa-disable");
                        if (!res.data.errors) {
                            this.success_msg = res.data.msg;
                            this.is_2fa_enabled = res.data.is_2fa_enabled;
                        }
                    } else {
                        document.querySelector(".custom-switch-input").checked =
                            true;
                    }
                });
            } else {
                let res = await axios.post("admin/2fa-generate");
                this.qr = await QRCode.toDataURL(res.data.qr);
            }
        },
        verifyOtp(e) {
            e.preventDefault();
            this.disabled = true;
            axios
                .post("admin/2fa-otp-verify", {
                    otp: this.otp,
                })
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        if (res.data.msg.otp) {
                            this.otp_error = res.data.msg.otp[0];
                        }
                    } else {
                        this.success_msg = res.data.msg;
                        this.google2fa_backup_code =
                            res.data.google2fa_backup_code;
                        this.is_2fa_enabled = true;
                        this.otp_error = "";
                        this.otp = "";
                    }
                });
        },
        resetBackUpCode(e) {
            e.preventDefault();
            this.disabled = true;
            axios.post("admin/backup-code-reset").then((res) => {
                this.disabled = false;
                if (!res.data.errors) {
                    this.success_msg = res.data.msg;
                }
            });
        },
        handle_download() {
            Swal.fire({
                title: "Are you sure you want to download the backup code?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, download it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios
                            .post(`admin/backup-code-download`, {
                                responseType: "blob",
                            })
                            .then((response) => {
                                const blob = new Blob([response.data], {
                                    type: "text/plain",
                                });

                                const url = window.URL.createObjectURL(blob);

                                const link = document.createElement("a");
                                link.href = url;
                                link.download = "backupcode.txt";

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
    },
    mounted() {
        const auth = useAuthStore();
        this.is_2fa_enabled = auth.userDetail.is_2fa_enabled;
    },
};
</script>
