<template>
    <tr v-for="(record, index) in records" :key="index">
        <th scope="row">{{ record.id }}</th>
        <td>{{ record.name }}</td>
        <td>{{ record.dns }}</td>
        <td class="text-center">
            <button
                class="btn btn-success mx-1"
                v-on:click="
                    this.$router.push({
                        name: 'dns-manage',
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
export default {
    name: "DnsRecords",
    props: {
        records: {
            type: Array,
        },
        delete: {
            type: Function,
        },
    },
    methods: {
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
