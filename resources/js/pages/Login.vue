<template>
    <div class="square-box">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div
                        class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center"
                    >
                        <a href="javascript:;">
                            <div
                                data-v-c7378482=""
                                class="display-2 primary--text"
                                bis_skin_checked="1"
                            >
                                SBP Panel
                            </div>
                        </a>
                        <div class="card-sigin">
                            <!-- Demo content-->
                            <div class="main-card-signin d-md-flex">
                                <div class="wd-100p">
                                    <div class="">
                                        <div class="main-signup-header">
                                            <div class="panel panel-primary">
                                                <div
                                                    class="panel-body tabs-menu-body border-0 p-3"
                                                >
                                                    <div class="tab-content">
                                                        <div
                                                            class="tab-pane active"
                                                            id="tab5"
                                                        >
                                                            <form action="#">
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        >Email</label
                                                                    >
                                                                    <input
                                                                        :class="[
                                                                            'form-control',
                                                                            {
                                                                                'border-danger':
                                                                                    email_error,
                                                                            },
                                                                        ]"
                                                                        v-model="
                                                                            form_data.email
                                                                        "
                                                                        placeholder="Enter your email"
                                                                        type="text"
                                                                    />
                                                                    <span
                                                                        class="text-danger"
                                                                        v-show="
                                                                            email_error
                                                                        "
                                                                        >{{
                                                                            email_error
                                                                        }}</span
                                                                    >
                                                                </div>
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        >Password</label
                                                                    >
                                                                    <input
                                                                        :class="[
                                                                            'form-control',
                                                                            {
                                                                                'border-danger':
                                                                                    password_error,
                                                                            },
                                                                        ]"
                                                                        v-model="
                                                                            form_data.password
                                                                        "
                                                                        placeholder="Enter your password"
                                                                        :type="
                                                                            text_type
                                                                        "
                                                                    />
                                                                    <i
                                                                        class="far fa-eye"
                                                                        id="togglePassword"
                                                                        style="
                                                                            cursor: pointer;
                                                                        "
                                                                        v-on:click="
                                                                            togglePassword
                                                                        "
                                                                    ></i>
                                                                    <span
                                                                        class="text-danger"
                                                                        v-show="
                                                                            password_error
                                                                        "
                                                                        >{{
                                                                            password_error
                                                                        }}</span
                                                                    >
                                                                </div>
                                                                <button
                                                                    class="btn btn-primary btn-block"
                                                                    v-on:click="
                                                                        submit(
                                                                            $event,
                                                                        )
                                                                    "
                                                                >
                                                                    {{
                                                                        disabled
                                                                            ? "Please wait..."
                                                                            : "Sign In"
                                                                    }}
                                                                </button>
                                                            </form>
                                                            <div
                                                                class="text-danger mt-2"
                                                                v-show="
                                                                    auth_error
                                                                "
                                                            >
                                                                {{ auth_error }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="main-signin-footer text-center mt-3"
                                            >
                                                <!-- <p><a href="" class="mb-3">Forgot password?</a></p> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { useAuthStore } from "../stores/auth";
export default {
    name: "Login",
    data() {
        return {
            form_data: {
                email: "",
                password: "",
            },
            text_type: "password",
            email_error: "",
            password_error: "",
            auth_error: "",
            disabled: false,
            success_msg: "",
        };
    },
    methods: {
        togglePassword() {
            if (this.text_type === "password") {
                this.text_type = "text";
            } else {
                this.text_type = "password";
            }
        },
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.email_error = "";
            this.password_error = "";
            this.auth_error = "";
            const auth = useAuthStore();
            auth.login(this.form_data).then((res) => {
                this.disabled = false;
                if (res.data.errors) {
                    if (res.data.msg.email) {
                        this.email_error = res.data.msg.email[0];
                    }
                    if (res.data.msg.password) {
                        this.password_error = res.data.msg.password[0];
                    }
                    if (res.data.msg.auth_error) {
                        this.auth_error = res.data.msg.auth_error;
                    }
                } else {
                    this.$router.push({ name: "app-list" });
                }
            });
        },
    },
};
</script>
<style scoped>
.display-2 {
    font-size: 3.5rem;
    font-weight: 400;
    line-height: 1.2;
    color: #fff;
    margin-bottom: 15px;
    margin-top: -20px;
    margin-left: 114px;
}

#togglePassword {
    position: absolute;
    right: 25px;
    margin-top: -27px;
    font-size: 15px;
}
</style>
