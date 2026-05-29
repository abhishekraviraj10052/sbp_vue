<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="[
            'my apps',
            '#' + whmcs_service_id + ' ' + app_name,
            'maindashboard',
            'dns',
            'edit',
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
            <div class="card box-shadow-0">
                <div class="card-body pt-0">
                    <form>
                        <div class="form-group mt-4">
                            <label class="custom-switch ps-0">
                                <span
                                    class="custom-switch-description tx-17 me-2"
                                    >2FA
                                    <span id="showstatuslogs"
                                        >enable</span
                                    ></span
                                >
                                <input
                                    type="checkbox"
                                    class="custom-switch-input"
                                    v-on:change="enable2fa"
                                />
                                <span
                                    class="custom-switch-indicator custom-switch-indicator-lg custom-square"
                                ></span>
                            </label>
                        </div>
                        <div
                            class="col-md-12"
                            id="basecontentdata"
                            bis_skin_checked="1"
                        >
                            <p>
                                Using an authenticator app like Google
                                Authenticator or Duo, scan the QR code below.
                            </p>
                            <div class="text-center">
                                <img :src="qr" />
                            </div>
                            <p style="margin-top: 20px">
                                Having trouble scanning the code? Enter the code
                                manually:
                                <b id="manualcode" data-seccode=""
                                    >6XDCJSME52UMKFWN</b
                                >
                            </p>
                            <p></p>
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

            qr: "",
            otp: "",

            disabled: false,
            otp_error: "",
            success_msg: "",
        };
    },
    methods: {
        enable2fa() {
            axios.post("admin/2fa-generate").then((res) => {
                this.qr = res.data.qr;
            });
        },
        verifyOtp(e) {
            e.preventDefault();
            this.disabled = true;
            axios
                .post("admin/2fa-verify-otp", {
                    otp: this.otp,
                })
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        this.disabled = false;
                        if (res.data.msg.otp) {
                            this.otp_error = res.data.msg.otp[0];
                        }
                    } else {
                        this.success_msg = res.data.msg;
                        this.otp_error = "";
                        this.otp = "";
                    }
                });
        },
    },
    mounted() {
        const auth = useAuthStore();
        this.whmcs_service_id = auth.appDetail ? auth.appDetail.id : null;
        this.app_name = auth.appDetail ? auth.appDetail.title : null;
    },
};
</script>
