<template>
    <tr v-for="(record, index) in records" :key="index">
        <th scope="row" class="text-center">{{ record.id }}</th>
        <td class="text-center">{{ record.title }}</td>
        <td class="text-center">{{ record.username ?? "n/A" }}</td>
        <td class="text-center">
            <input
                type="password"
                :value="record.shareable_password ?? 'n/A'"
                readonly
                class="form-control-plaintext text-center"
            />
            <i
                class="far fa-eye"
                id="togglePassword"
                style="margin-left: -40px; cursor: pointer"
                v-on:click="togglePassword"
            ></i>
        </td>
        <td class="text-center">{{ record.created_at }}</td>
        <td class="text-center">
            <button
                class="btn btn-success mx-1"
                v-on:click="
                    this.$router.push({
                        name: 'vpn-manage',
                        params: { id: record.id },
                    })
                "
            >
                <i class="fa fa-edit"></i></button
            ><button
                class="btn btn-info"
                v-on:click="handle_download(record.id)"
            >
                <i class="fa fa-download"></i>
            </button>
            <button
                class="btn btn-danger"
                v-on:click="handle_delete(record.id)"
            >
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
</template>
<script>
import axios from "axios";
export default {
    name: "VpnRecords",
    props: {
        records: {
            type: Array,
        },
        delete: {
            type: Function,
        },
    },
    methods: {
        togglePassword() {
            const passwordInput =
                document.getElementById(
                    "togglePassword",
                ).previousElementSibling;
            if (passwordInput) {
                passwordInput.type =
                    passwordInput.type === "password" ? "text" : "password";
            }
        },
        handle_delete(id) {
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
                    this.delete(id);
                }
            });
        },

        handle_download(id) {
            Swal.fire({
                title: "Are you sure you want to download this VPN file?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, download it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        axios
                            .get(`admin/vpn-download/${id}`, {
                                responseType: "blob",
                            })
                            .then((response) => {
                                const blob = new Blob([response.data], {
                                    type: "application/x-openvpn-profile",
                                });

                                const url = window.URL.createObjectURL(blob);

                                const link = document.createElement("a");
                                link.href = url;
                                link.download = "client.ovpn";

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
};
</script>
<style scoped>
#togglePassword {
    position: absolute;
    right: 600px;
    margin-top: -25px;
    font-size: 15px;
}
</style>
