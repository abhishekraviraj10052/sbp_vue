<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style mg-b-0">
            <li class="breadcrumb-item" v-for="(data,index) in crumb_data" :key="index"><span>{{ data }}</span></li>
        </ol>
    </nav>
</template>

<script>
export default {
    name: 'BreadCrumb',
    props: {
        crumb_data: Array,
    },
}
</script>
