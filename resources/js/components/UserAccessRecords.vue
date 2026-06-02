<template>
    <tr v-for="(record, index) in records" :key="index">
        <th
            scope="row"
            class="cursor-pointer"
            v-on:click="this.redirectToAppDetail(record.id)"
        >
            #{{ record.id }}
        </th>
        <td
            class="cursor-pointer"
            v-on:click="this.redirectToAppDetail(record.id)"
        >
            {{ record.email }}
        </td>
        <td>
            <span v-for="access in record.accesses" :key="access.app_id">
                #{{ access?.app_id }} {{ access?.app?.title }}
                <br />
            </span>
        </td>
        <td>
            <span
                v-if="record.accesses?.[0]?.status === 'inactive'"
                class="badge badge-danger"
            >
                Inactive
            </span>

            <span v-else class="badge badge-success"> Active </span>
        </td>
        <td>
            <button
                class="btn btn-success"
                v-on:click="this.redirectToAppDetail(record.id)"
            >
                Manage</button
            ><button
                class="btn btn-success mx-1"
                v-on:click="
                    this.$router.push({
                        name: 'app-manage',
                        params: { id: record.id },
                    })
                "
            >
                <i class="fa fa-edit"></i></button
            ><button
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
import { useAuthStore } from "@/stores/auth";
export default {
    name: "UserAccessRecords",
    props: {
        records: {
            type: Array,
        },
        delete: {
            type: Function,
        },
    },
    methods: {
        async redirectToAppDetail(id) {
            const auth = useAuthStore();
            await auth.getAppDetail(id);
            this.$router.push({ name: "app-detail" });
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
    },
};
</script>
<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
