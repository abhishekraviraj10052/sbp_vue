<template>
    <!-- breadcrumb -->
    <BreadCrumb
        :crumb_data="
            form_data.id
                ? ['my apps', 'main dashboard', 'dashboard ads', 'edit']
                : ['my apps', 'main dashboard', 'dashboard ads', 'add new']
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
                        <div class="form-group" bis_skin_checked="1">
                            <label for="inputtitle"
                                >Title (Leave empty to keep file name as
                                title)</label
                            >
                            <input
                                type="text"
                                name="title"
                                value=""
                                class="form-control title_input"
                            />
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="inputusername"
                                >VPN Username (Optional)</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                v-model="form_data.username"
                            />
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="inputpassword"
                                >VPN Password (Optional)</label
                            >
                            <input
                                type="password"
                                class="form-control"
                                v-model="form_data.password"
                               
                            />
                            <i
                                class="far fa-eye"
                                id="togglePassword"
                                style="margin-left: -40px; cursor: pointer"
                            ></i>
                        </div>
                        <div class="form-group" bis_skin_checked="1">
                            <label for="inputOvn">Upload ovn file / zip</label>
                            <input
                                type="file"
                                class="form-control"
                                style="min-height: 0px !important"
                                v-on:change="handleFileChange"
                            />
                            <span class="text-danger">{{ file_error }}</span>
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
                                {{ disabled ? "Please wait..." : "Submit" }}
                            </button>
                            <button
                                :class="[
                                    'btn btn-light mt-3 mb-0 mx-3',
                                    { disabled: disabled },
                                ]"
                                href="javascript:void(0);"
                                v-on:click="
                                    this.$router.push({
                                        name: 'vpn-list',
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
import BreadCrumb from "../components/bread_crumb/BreadCrumb.vue";

export default {
    name: "VpnManage",
    components: {
        BreadCrumb,
    },
    data() {
        return {
            form_data: {
                id: "",
                title: "",
                username: "",
                password: "",
                file: "",
            },
            file_error: "",
            disabled: false,
        };
    },
    methods: {
        handleFileChange(event) {
            this.form_data.file = event.target.files[0];
            console.log(this.form_data.file);
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
            fd.append("username", this.form_data.username);
            fd.append("password", this.form_data.password);
           
            if (this.form_data.file) {
                fd.append("file", this.form_data.file);
            }
        
            axios
                .post("/admin/vpn-manage", fd, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.disabled = false;
                    if (res.data.errors) {
                        if (res.data.msg.file) {
                            this.file_error = res.data.msg.file[0];
                        }
                    } else {
                        const success = useMessageStore();
                        success.setMessage(res.data.msg);
                        this.$router.push({ name: "vpn-list" });
                    }
                });
        },
    },
    mounted() {
        this.form_data.id = this.$route.params?.id;
        if (this.form_data.id) {
            axios
                .post("/admin/vpn-ads-edit", {
                    id: this.form_data.id,
                })
                .then((res) => {
                    this.form_data.id = res.data.record.id;
                    this.form_data.title = res.data.record.title;
                    this.form_data.message = res.data.record.username;
                    this.form_data.files = res.data.record.password ?? [];
                    this.form_data.status = res.data.record.status;
                });
        }
    },
};
</script>
<style scoped>
#togglePassword {
    position: absolute;
    right: 25px;
    margin-top: -27px;
    font-size: 15px;
}
</style>
