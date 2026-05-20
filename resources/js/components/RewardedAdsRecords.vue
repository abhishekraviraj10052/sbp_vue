<template>
    <tr v-for="(record, index) in records" :key="index">
        <th scope="row">{{ record.id }}</th>
        <td>{{ record.title }}</td>
        <td>{{ record.type }}</td>
        <td v-if="record.type === 'message'">{{ record.text }}</td>
        <td v-if="record.type === 'image'"><img :src="'/uploads/rewarded_ads/' + record.filepath[0]" alt="Image" style="max-width: 100px; max-height: 100px;" /></td>
        <td>{{ record.status }}</td>
        <td>{{ record.created_at }}</td>
        <td>{{ record.updated_at }}</td>
        <td>
            <button
                class="btn btn-success mx-1"
                v-on:click="
                    this.$router.push({
                        name: 'rewarded-ads-manage',
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
    name: "RewardedAdsRecords",
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
