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
                              <div v-if="success_msg" class="alert alert-success">
                                    {{ success_msg }}
                                </div>
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
                                                            <form action="#" v-if="show_form">
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
                                                                            togglePassword($event)
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
                                                                <div
                                                                    class="form-group"
                                                                >
                                                                    <label
                                                                        >Confirm
                                                                        Password</label
                                                                    >
                                                                    <input
                                                                        :class="[
                                                                            'form-control',
                                                                            {
                                                                                'border-danger':
                                                                                    password_confirmation_error,
                                                                            },
                                                                        ]"
                                                                        v-model="
                                                                            form_data.password_confirmation
                                                                        "
                                                                        placeholder="Confirm password"
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
                                                                            togglePassword($event)
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
                                                                            : "Submit"
                                                                    }}
                                                                </button>
                                                            </form>
                                                            <div
                                                                class="alert alert-danger mt-2"
                                                                v-show="
                                                                    auth_error
                                                                "
                                                            >
                                                                <b>Error:</b><span class="mx-1">{{ auth_error }}</span>
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
import { useMessageStore } from "../stores/messageStore";
export default {
    name: "Login",
    data() {
        return {
            form_data: {
                user_id: "",
                password: "",
                password_confirmation: "",
            },
            text_type: "password",
            password_error: "",
            password_confirmation_error: "",
            auth_error: "",
            disabled: false,
            show_form: false,
            success_msg: "",
        };
    },
    methods: {
        togglePassword(e) {
           e.target.previousElementSibling.type =
                e.target.previousElementSibling.type === "password"
                    ? "text"
                    : "password";
        },
        validateToken(token) {
            axios
                .post("/token-validate", { token: token })
                .then((res) => {
                    if (!res.data.errors) {
                        this.form_data.user_id = res.data.user_id;
                        this.success_msg = res.data.msg;
                        this.show_form = true;
                    } else {
                        this.auth_error = res.data.msg;
                    }
                })
                .catch((error) => {
                    this.auth_error =
                        "An error occurred while validating the token.";
                });
        },
        submit(e) {
            e.preventDefault();
            this.disabled = true;
            this.password_error = "";
            this.password_confirmation_error = "";
            this.auth_error = "";
            axios
                .post("/password-create", this.form_data)
                .then((res) => {
                 this.disabled = false;;
                    if (res.data.errors) {
                        if (res.data.msg.password) {
                            this.password_error = res.data.msg.password[0];
                        }
                        if (res.data.msg.password_confirmation) {
                            this.password_confirmation_error = res.data.msg.password_confirmation[0];
                        }
                        if (res.data.msg.auth_error) {
                            this.auth_error = res.data.msg.auth_error;
                        }
                    } else {
                        const success = useMessageStore();
                        success.setMessage(res.data.msg);
                        this.$router.push({ name: "login" });
                    }
                })
              
        },
    },
    mounted() {
        document.body.classList.add("bg-primary");
        let token = this.$route.params?.token;
        if (token) {
            this.validateToken(token);
        }
    },
};
</script>
<style scoped>
body {
    background: #f5f5f5;
}
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
